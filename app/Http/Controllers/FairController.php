<?php

namespace App\Http\Controllers;

use App\Datacite\Datacite;
use App\fuji\FujiClient;
use App\Jobs\ProcessDataciteMetadataRetrieval;
use App\Jobs\ProcessFujiFairAssessment;
use App\Models\FairAssessment;
use App\Models\FairAssessmentBatch;
use App\Models\FairAssessmentGroup;
use App\Models\FairAssessmentGroupList;
use App\Models\FairAssessmentObject;
use App\Models\Exports\ExportFairAssessmentGroupList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FairController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the lists overview.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function lists(Request $request)
    {
        $versions = FairAssessmentGroupList::select('version')->distinct()->get()->pluck('version')->toArray();

        $selectedVersion = $request->query('version', max($versions));

        $lists = FairAssessmentGroupList::where('version', $selectedVersion)->with('fair_assessment_groups', 'fair_asessment_batches')->get();

        $versions = FairAssessmentGroupList::select('version')->distinct()->get()->pluck('version')->toArray();

        return view('list-overview', ['lists' => $lists, 'versions' => $versions, 'selectedVersion' => $selectedVersion]);
    }

    public function addListForm()
    {
        $versions = FairAssessmentGroupList::select('version')->distinct()->get()->pluck('version')->toArray();
        $selectedVersion = max($versions);

        return view('list-add', ['versions' => $versions, 'selectedVersion' => $selectedVersion]);
    }

    public function addList(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:fair_assessment_group_lists|max:255',
            'version' => 'required',
        ]);

        $list = FairAssessmentGroupList::create([
            'name' => $request->name,
            'version' => $request->version,
            'description' => $request->description ?? ''
        ]);

        return redirect()->route('list-overview')->with('status', 'New list added!');
    }

    public function groups($list_id)
    {
        $groups = FairAssessmentGroup::where('fair_assessment_group_list_id', $list_id)->with('fair_assessment_objects')->get();

        return view('group-overview', ['groups' => $groups, 'listId' => $list_id]);
    }

    public function addGroupForm($list_id)
    {
        return view('group-add', ['listId' => $list_id]);
    }

    public function addGroup($list_id, Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('fair_assessment_groups')->where(function ($query) use ($request) {
                    return $query->where('fair_assessment_group_list_id', $request->list_id);
                }),
                'max:255',
            ]
        ]);

        $group = FairAssessmentGroup::create([
            'name' => $request->name,
            'fair_assessment_group_list_id' => $list_id
        ]);


        return redirect()->route('groups-overview', ['list_id' => $list_id])->with('status', 'New group added!');
    }

    public function objects($group_id)
    {
        $group = FairAssessmentGroup::where('id', $group_id)->first();

        $objects = $group->fair_assessment_objects;

        return view('object-overview', ['objects' => $objects, 'groupId' => $group_id]);
    }

    public function addObjectForm($group_id)
    {
        return view('object-add', ['groupId' => $group_id]);
    }

    public function addObject($group_id, Request $request)
    {
        $request->validate([
            'pids' => 'required'
        ]);

        $pids = explode("\n", $request->pids);
        $pids = array_unique($pids);

        foreach($pids as $pid) {
            $pid = trim($pid);
            if(strlen($pid) > 0) {
                //check if pid already exists...
                if(FairAssessmentObject::where('pid', $pid)->exists()) {
                    // connect existing
                    $existing = FairAssessmentObject::where('pid', $pid)->first();

                    DB::table('fair_asessment_group_object')->insert([
                        'fair_assessment_object_id' => $existing->id,
                        'fair_assessment_group_id' => $group_id,
                    ]);
                } else {
                    // add new
                    $object = FairAssessmentObject::create([
                        'pid' => $pid,
                        'datacite_publisher' => '',
                    ]);

                    DB::table('fair_asessment_group_object')->insert([
                        'fair_assessment_object_id' => $object->id,
                        'fair_assessment_group_id' => $group_id,
                    ]);
                }
            }
        }

        return redirect()->route('objects-overview', ['group_id' => $group_id])->with('status', 'New object(s) added!');
    }

    public function batches($list_id)
    {
        $batches = FairAssessmentBatch::where('fair_assessment_group_list_id', $list_id)->with('fair_assessments')->get();

        return view('batch-overview', ['batches' => $batches, 'listId' => $list_id]);
    }

    public function startBatchProcessing($version)
    {
        //create new batch
        $batch = FairAssessmentBatch::create([]);

        $lists = FairAssessmentGroupList::where('version', $version)->get();
        $objectIds = [];

        foreach($lists as $list) {
            $groups = $list->fair_assessment_groups;
            foreach($groups as $group) {
                $objects = $group->fair_assessment_objects;
                foreach($objects as $object) {
                    $objectIds[] = $object->id;
                }
            }
        }

        $objectIds = array_unique($objectIds);
        shuffle($objectIds);

        foreach($objectIds as $objectId) {
            $assessment = FairAssessment::create([
                'fair_assessment_batch_id' => $batch->id,
                'fair_assessment_object_id' => $objectId
            ]);

            ProcessFujiFairAssessment::dispatch($assessment);
        }

        return redirect()->route('list-overview')->with('status', 'batch processing started!');
    }

    public function assessments($batch_id)
    {
        $assessments = FairAssessment::where('fair_assessment_batch_id', $batch_id)->with('fair_assessment_object')->get();

        return view('assessment-overview', ['assessments' => $assessments]);
    }

    public function assessment($assessment_id)
    {
        $assessment = FairAssessment::where('id', $assessment_id)->first();

        return view('assessment-detail', ['assessment' => $assessment]);
    }

    public function exports()
    {
        return view('exports-overview');
    }

    public function stats()
    {
        $lists = ExportFairAssessmentGroupList::where('version', 2)->get();

        $results = [];

        foreach ($lists as $list) {
            $groups = $list->export_fair_assessment_groups;
            foreach($groups as $group) {
                $objects = $group->export_fair_assessment_objects;
                foreach($objects as $object) {
                    $measurement1 = $object->export_fair_assessments->where('measurement_grouped_batch', 1)->first();
                    $measurement2 = $object->export_fair_assessments->where('measurement_grouped_batch', 3)->first();

                    if($measurement1 && $measurement2) {
                        if(isset($results[$group->name])) {
                            $results[$group->name]['total_1'] = ($results[$group->name]['total_1'] + $measurement1->score_percent);
                            $results[$group->name]['count_1'] = $results[$group->name]['count_1'] + 1;
                            $results[$group->name]['total_2'] = ($results[$group->name]['total_2'] + $measurement2->score_percent);
                            $results[$group->name]['count_2'] = $results[$group->name]['count_2'] + 1;

                            $results[$group->name]['abs_change'] = $results[$group->name]['abs_change'] + ($measurement2->score_percent - $measurement1->score_percent);
                        } else {
                            $results[$group->name]['total_1'] = $measurement1->score_percent;
                            $results[$group->name]['count_1'] = 1;
                            $results[$group->name]['total_2'] = $measurement2->score_percent;
                            $results[$group->name]['count_2'] = 1;
                            $results[$group->name]['abs_change'] = $measurement2->score_percent - $measurement1->score_percent;                            
                        }
                    }
                }
            }
        }

        $tempTotal = 0;
        $tempCount = 0;
        foreach($results as &$result) {
            $result['avg_1'] = $result['total_1'] / $result['count_1'];
            $result['avg_2'] = $result['total_2'] / $result['count_2'];

            $result['per_change'] = (($result['avg_2'] - $result['avg_1']) / $result['avg_1']) * 100;
            $tempTotal = $tempTotal + $result['per_change'];
            $tempCount++;
        }

        //dd($tempTotal / $tempCount);


        return view('stats-overview', ['stats' => $results]);
    }

    public function exportTable()
    {
        // drop other export tables
        DB::statement('DROP TABLE export_fair_assessments');
        DB::statement('DROP TABLE export_fair_assessment_batches');
        DB::statement('DROP TABLE export_fair_assessment_objects');
        DB::statement('DROP TABLE export_fair_assessment_groups');
        DB::statement('DROP TABLE export_fair_assessment_group_lists');
        DB::statement('DROP TABLE export_fair_assessment_group_object');

        // repopulate tables based on source tables
        DB::statement('create table laravel.export_fair_assessment_batches as select * from laravel.fair_assessment_batches');
        DB::statement('create table laravel.export_fair_assessment_objects as select * from laravel.fair_assessment_objects');
        DB::statement('create table laravel.export_fair_assessment_groups as select * from laravel.fair_assessment_groups');
        DB::statement('create table laravel.export_fair_assessment_group_lists as select * from laravel.fair_assessment_group_lists');
        DB::statement('create table laravel.export_fair_assessment_group_object as select * from laravel.fair_asessment_group_object');

        // assessments set by this script
        DB::statement('create table laravel.export_fair_assessments as select * from laravel.fair_assessments');
        DB::table('export_fair_assessments')->truncate();
        // add measurement int to assessments table to store batch/measurement number
        DB::statement('alter table laravel.export_fair_assessments add measurement_grouped_batch int');



        // batch 3 highest fair assessments
        $assessmentsBatch3 = DB::table('fair_assessments')->select('fair_assessment_object_id')->where('fair_assessment_batch_id', '>=', 34)->groupBy('fair_assessment_object_id')->get();
        $batch3ObjectIds = $assessmentsBatch3->pluck('fair_assessment_object_id')->all();

        foreach($batch3ObjectIds as $objectId) {
            $highestAssessment = DB::table('fair_assessments')->where('fair_assessment_object_id', $objectId)->where('fair_assessment_batch_id', '>=', 34)->orderBy('score_percent', 'desc')->first();
            $highestAssessment = (array)$highestAssessment;
            $highestAssessment['measurement_grouped_batch'] = 3;
            unset($highestAssessment['id']);

            DB::table('export_fair_assessments')->insert($highestAssessment);
        }


        // batch 2 highest fair assessments
        $assessmentsBatch2 = DB::table('fair_assessments')->select('fair_assessment_object_id')->where('fair_assessment_batch_id', '>=', 23)->where('fair_assessment_batch_id', '<', 34)->groupBy('fair_assessment_object_id')->get();
        $batch2ObjectIds = $assessmentsBatch2->pluck('fair_assessment_object_id')->all();        

        foreach($batch2ObjectIds as $objectId) {
            $highestAssessment = DB::table('fair_assessments')->where('fair_assessment_object_id', $objectId)->where('fair_assessment_batch_id', '>=', 23)->where('fair_assessment_batch_id', '<', 34)->orderBy('score_percent', 'desc')->first();
            $highestAssessment = (array)$highestAssessment;
            $highestAssessment['measurement_grouped_batch'] = 2;
            unset($highestAssessment['id']);

            DB::table('export_fair_assessments')->insert($highestAssessment);
        }

        $objectIds = array_merge($batch3ObjectIds, $batch3ObjectIds);
        $objectIds = array_unique($objectIds);

        // batch 1 highest fair assessments - object must exist in batch 2
        $assessmentsBatch1 = DB::table('fair_assessments')->select('fair_assessment_object_id')->where('fair_assessment_batch_id', '<=', 14)->whereIn('fair_assessment_object_id', $objectIds)->groupBy('fair_assessment_object_id')->get();
        $batch1ObjectIds = $assessmentsBatch1->pluck('fair_assessment_object_id')->all();

        foreach($batch1ObjectIds as $batch1ObjectId) {
            $highestAssessment = DB::table('fair_assessments')->where('fair_assessment_object_id', $batch1ObjectId)->where('fair_assessment_batch_id', '<=', 14)->orderBy('score_percent', 'desc')->first();
            $highestAssessment = (array)$highestAssessment;
            $highestAssessment['measurement_grouped_batch'] = 1;
            unset($highestAssessment['id']);

            DB::table('export_fair_assessments')->insert($highestAssessment);
        }

        return redirect()->route('exports-overview')->with('status', 'export table populated');
    }

    public function datacite()
    {
        return view('datacite-overview');
    }

    public function updateDatacite()
    {

        //$objects = FairAssessmentObject::where('pid', 'LIKE', '10.%')->get();
        $objects = FairAssessmentObject::where('pid', 'LIKE', '10.%')->where('datacite_metadata', NULL)->get();

        foreach($objects as $object) {
            // dispatch jobs
            ProcessDataciteMetadataRetrieval::dispatch($object);
        }

        return redirect()->route('datacite-overview')->with('status', 'datacite processing started!');
    }

    public function queryDatacite(Request $request)
    {
        $request->validate([
            'va' => 'required',
            'datacite_query' => 'required',
        ]);

        $datacite = new Datacite;

        $result = $datacite->doisRequestQuery($request->datacite_query);

        if($result->response_code == 200) {
            $dois = [];
            foreach($result->response_body['data'] as $data) {
                $dois[] = $data['attributes']['doi'];
            }

            return response()->streamDownload(function () use ($dois): void {
                foreach($dois as $doi) {
                    echo $doi . "\n";
                }
            }, $request->va . '.txt');
        }

        return redirect()->route('datacite-overview')->with('status', 'error generating va file');
    }


}
