@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Stats</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table>
                        <tr>
                            <th>VA</th>
                            <th>avg 1</th>
                            <th>avg 2</th>
                            <th>per_change</th>
                            <th>abs_change</th>
                        </tr>
                        @foreach($stats as $va => $stat)
                            <tr>
                                <td>{{ $va }}</td>
                                <td>{{ $stat['avg_1'] }}</td>
                                <td>{{ $stat['avg_2'] }}</td>
                                <td>{{ $stat['per_change'] }}</td>
                                <td>{{ $stat['abs_change'] }}</td>
                            </tr>
                        @endforeach
                    </table>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
