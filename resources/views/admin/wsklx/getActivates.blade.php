@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">得到激活码</div>
                    <div class="panel-body">
                        @foreach ($results as $activate)
                            <div class="activate">
                                <h4>{{ $activate }}</h4>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection