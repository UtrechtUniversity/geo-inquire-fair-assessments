@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Assessment overview</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    @if($assessment)
                        <table class="table table-sm">
                        <thead>
							
						</thead>
						<tbody>
							<tr>
								<td>id:</td>
								<td>{{ $assessment->id }}</td>
							</tr>
							<tr>
								<td>pid:</td>
								<td>{{ $assessment->fair_assessment_object->pid }}</td>
							</tr>
							<tr>
								<td>processed:</td>
								<td>{{ $assessment->processed }}</td>
							</tr>
							<tr>
								<td>response code:</td>
								<td>{{ $assessment->response_code }}</td>
							</tr>
							
							<tr>
								<td>score F:</td>
								<td>{{ $assessment->score_F }}</td>
							</tr>
							<tr>
								<td>score F1:</td>
								<td>{{ $assessment->score_F1 }}</td>
							</tr>
							<tr>
								<td>score F2:</td>
								<td>{{ $assessment->score_F2 }}</td>
							</tr>
							<tr>
								<td>score F3:</td>
								<td>{{ $assessment->score_F3 }}</td>
							</tr>
							<tr>
								<td>score F4:</td>
								<td>{{ $assessment->score_F4 }}</td>
							</tr>
							
							<tr>
								<td>score A:</td>
								<td>{{ $assessment->score_A }}</td>
							</tr>
							<tr>
								<td>score A1:</td>
								<td>{{ $assessment->score_A1 }}</td>
							</tr>
							<tr>
								<td>score A2:</td>
								<td>{{ $assessment->score_A2 }}</td>
							</tr>
							
							<tr>
								<td>score I:</td>
								<td>{{ $assessment->score_I }}</td>
							</tr>
							<tr>
								<td>score I1:</td>
								<td>{{ $assessment->score_I1 }}</td>
							</tr>
							<tr>
								<td>score I2:</td>
								<td>{{ $assessment->score_I2 }}</td>
							</tr>
							<tr>
								<td>score I3:</td>
								<td>{{ $assessment->score_I3 }}</td>
							</tr>
							
							<tr>
								<td>score R:</td>
								<td>{{ $assessment->score_R }}</td>
							</tr>
							<tr>
								<td>score R1:</td>
								<td>{{ $assessment->score_R1 }}</td>
							</tr>
							<tr>
								<td>score R1_1:</td>
								<td>{{ $assessment->score_R1_1 }}</td>
							</tr>
							<tr>
								<td>score R1_2:</td>
								<td>{{ $assessment->score_R1_2 }}</td>
							</tr>
							<tr>
								<td>score R1_3:</td>
								<td>{{ $assessment->score_R1_3 }}</td>
							</tr>
							
							
							<tr>
								<td>score overal percentage:</td>
								<td>{{ $assessment->score_percent }}</td>
							</tr>																					
						</tbody>
                        </table>

                        <p>Full response:</p>
					    <div class="overflow-scroll"><pre>{{ $assessment->getResponseBodyAsJson(true) }}</pre></div>
                    @else
                        <p>No assessment found</p>
                    @endif

                    <a class="btn btn-primary" href="{{ route('list-add-form') }}" role="button">Add list</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
