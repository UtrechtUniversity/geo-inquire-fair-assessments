@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Batch overview</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    @if(count($batches) > 0)
                        <table class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Assessments</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($batches as $batch)
                        <tr>
                            <th scope="row">{{ $batch->id }}</th>
                            <td><a href="{{ route('assessments-overview', ['batch_id' => $batch->id]) }}" title="view assessments">{{ $batch->fair_assessments()->count() }}</a></td>
                            <td>{{ $batch->created_at }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    @else
                        <p>No batches found</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
