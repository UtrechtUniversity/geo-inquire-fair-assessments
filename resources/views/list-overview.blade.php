@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">List overview</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form class="row align-items-right" method="get" action="">
                    <div class="col-10"></div>
                    <div class="col-2">
                    <label for="version">version</label> 
                    <select class="form-select form-select-sm" id="version" name="version" onchange="this.form.submit();">
                        @foreach($versions as $version)
                        <option @if($version == $selectedVersion) selected @endif value="{{ $version }}">{{ $version }}</option>
                        @endforeach
                    </select>
                    </div>
                    </form>
                    
                    @if(count($lists) > 0)
                        <table class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Groups</th>
                            <th scope="col">Batches</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($lists as $list)
                        <tr>
                            <th scope="row">{{ $list->id }}</th>
                            <td>{{ $list->name }}</td>
                            <td><a href="{{ route('groups-overview', ['list_id' => $list->id]) }}" title="view groups">{{ $list->fair_assessment_groups()->count() }}</a></td>
                            <td><a href="{{ route('batches-overview', ['list_id' => $list->id]) }}" title="view batches">{{ $list->fair_asessment_batches()->count() }}</a></td>
                            <td>{{ $list->created_at }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    @else
                        <p>No lists found</p>
                    @endif

                    <a class="btn btn-primary" href="{{ route('list-add-form') }}" role="button">Add list</a>
                    <hr>
                    <form action="{{ route('start-batch', ['version' => $selectedVersion]) }}" method="post">@csrf<button type="submit" class="btn btn-primary">Start batches</button></form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
