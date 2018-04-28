@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <a href="{{ url('admin/wsklx') }}" class="btn btn-lg btn-success col-xs-12">绝地求生:刺激战场</a>
                    </div>
                    <div class="panel-body">
                        <a href="{{ url('admin/mh') }}" class="btn btn-lg btn-success col-xs-12">终结者2</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection