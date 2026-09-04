@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add object</div>

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

                    <form method="post" action="{{ route('object-add', ['group_id' => $groupId]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="listName" class="form-label">pids</label>
                        <textarea class="form-control" id="listName" name="pids" placeholder="" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add object</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
