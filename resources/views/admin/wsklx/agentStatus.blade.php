@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <caption>代理情况</caption>
            <thead>
            <tr>
                <th>名称</th>
                <th>激活码生成数量</th>
                <th>已激活数量</th>
                <th>已冻结数量</th>
            </tr>
            </thead>
            <tbody>
            @foreach($info as $agent)
                <tr>
                    <td>{{ $agent['agentName'] }}</td>
                    <td>{{ $agent['activateSum'] }}</td>
                    <td>{{ $agent['activeSum'] }}</td>
                    <td>{{ $agent['freezeSum'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
