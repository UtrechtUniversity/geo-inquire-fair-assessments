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

                    
                    @if(count($assessments) > 0)
                        <table class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">pid</th>
                            <th scope="col">total score</th>
                            <th scope="col">created at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($assessments as $assessment)
                        <tr>
                            <th scope="row">{{ $assessment->id }}</th>
                            <td><a href="{{ route('assessment-overview', ['assessment_id' => $assessment->id]) }}" title="view assessment details">{{ $assessment->fair_assessment_object->pid }}</a></td>
                            <td>{{ $assessment->score_percent }}</td>
                            <td>{{ $assessment->created_at }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    @else
                        <p>No assessments found</p>
                    @endif

                    <a class="btn btn-primary" href="{{ route('list-add-form') }}" role="button">Add list</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
