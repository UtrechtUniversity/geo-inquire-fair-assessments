@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add list</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('list-add') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="listName" class="form-label">List name</label>
                        <input type="text" class="form-control" id="listName" name="name" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="listVersion" class="form-label">List version</label>
                        <select class="form-select form-select-sm" id="version" name="version">
                            @foreach($versions as $version)
                            <option @if($version == $selectedVersion) selected @endif value="{{ $version }}">{{ $version }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="listDescription" class="form-label">description</label>
                        <textarea class="form-control" id="listDescription" name="description" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add list</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
