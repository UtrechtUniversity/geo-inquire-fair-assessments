@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add group</div>

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

                    <form method="post" action="{{ route('group-add', ['list_id' => $listId]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="listName" class="form-label">Group name</label>
                        <input type="text" class="form-control" id="listName" name="name" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Add group</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
