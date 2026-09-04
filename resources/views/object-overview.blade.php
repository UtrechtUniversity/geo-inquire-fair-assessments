@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Object overview</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    @if(count($objects) > 0)
                        <table class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">pid</th>
                            <th scope="col">Assessments</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($objects as $object)
                        <tr>
                            <th scope="row">{{ $object->id }}</th>
                            <td>{{ $object->pid }}</td>
                            <td>{{ $object->fair_assessments()->count() }}</td>
                            <td>{{ $object->created_at }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    @else
                        <p>No objects found</p>
                    @endif

                    <a class="btn btn-primary" href="{{ route('object-add-form', ['group_id' => $groupId]) }}" role="button">Add object</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
