@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">激活码:{{ $activate->register }}  &nbsp;&nbsp;&nbsp;&nbsp;  {{ $message }}</div>
                    <div class="panel-body">
                        <p style="color:black;font-size:18px;">
                            创建时间: {{ $activate->created_at }}
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            @if($isActivate)
                                激活时间: {{ $activate->activetime }}
                            @endif

                            @if($isAdministrator)
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                创建者昵称: {{ $agentName }}
                            @endif
                        </p>
                        <form action="{{ url('admin/wsklx/freezeActivate/') }}" method="POST" style="display: inline;">
                            <input hidden="hidden" name="freezeActivate" value="{{ $activate->register }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success">冻结</button>
                        </form>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <form action="{{ url('admin/wsklx/unfreezeActivate/') }}" method="POST" style="display: inline;">
                            <input hidden="hidden" name="unfreezeActivate" value="{{ $activate->register }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success">解冻</button>
                        </form>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <form action="{{ url('admin/wsklx/delete/'.$activate->id) }}" method="POST" style="display: inline;">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">删除</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection