@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <caption>批量删除预览</caption>
            <thead>
            <tr>
                <th>激活码</th>
                <th>当前状态</th>
            </tr>
            </thead>
            <tbody>
            @foreach($info as $curActivate)
                <tr>
                    <td>{{ $curActivate['activate'] }}</td>
                    <td>{{ $curActivate['message'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/mh/massdeleteActivate') }}">
            {{ csrf_field() }}

            @foreach($info as $curActivate)
                <input hidden name="massdeleteActivate[]" value="{{ $curActivate['activate'] }}">
            @endforeach

            <div class="form-group pull-center">
                <div>
                    <button type="submit" class="btn btn-default">提交</button>
                </div>
            </div>

        </form>
    </div>
@endsection
