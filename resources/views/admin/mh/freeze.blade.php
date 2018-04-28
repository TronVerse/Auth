@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">输入冻结的激活码</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/mh/freezeActivate') }}">
                            {{ csrf_field() }}

                            <div class="form-group pull-center">
                                <label for="amount" class="col-md-4 control-label">激活码</label>

                                <div class="col-md-6">
                                    <input id="freezeActivate" type="text" class="form-control" name="freezeActivate" value="{{ old('freezeActivate') }}">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-default">提交</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
