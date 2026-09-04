@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Exports metadata</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <form action="{{ route('export-table') }}" method="post">@csrf<button type="submit" class="btn btn-primary">Populate assessment export table</button></form>
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
