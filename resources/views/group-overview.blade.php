@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Group overview</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    @if(count($groups) > 0)
                        <table class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Objects</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($groups as $group)
                        <tr>
                            <th scope="row">{{ $group->id }}</th>
                            <td>{{ $group->name }}</td>
                            <td><a href="{{ route('objects-overview', ['group_id' => $group->id]) }}" title="view objects">{{ $group->fair_assessment_objects()->count() }}</a></td>
                            <td>{{ $group->created_at }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    @else
                        <p>No groups found</p>
                    @endif

                    <a class="btn btn-primary" href="{{ route('group-add-form', ['list_id' => $listId]) }}" role="button">Add group</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
