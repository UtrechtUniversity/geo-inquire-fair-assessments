@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Datacite metadata</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <form action="{{ route('update-datacite') }}" method="post">@csrf<button type="submit" class="btn btn-primary">Update datacite records</button></form>
                    </div>

                    <hr>

                    <div class="row">
                        <form action="{{ route('query-datacite') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="va" class="form-label">VA</label>
                                <input class="form-control" type="text" name="va" id="va">
                            </div>
                            <div class="mb-3">
                                <label for="datacite_query" class="form-label">query</label>
                                <input class="form-control" type="text" name="datacite_query" id="datacite_query">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Create file</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
