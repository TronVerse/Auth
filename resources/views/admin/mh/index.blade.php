@extends('layouts.app')

@section('content')
    <style>
        .paginate{text-align:center}
    </style>
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-info"> {{Session::get('message')}}
            </div>
        @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">激活码管理</div>
                    <br>
                   <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif
                       <p style="color:black;font-size:18px;">
                           激活码总数: {{ $activateSum }}
                           &nbsp;&nbsp;
                           激活数量: {{ $activeSum }}
                           &nbsp;&nbsp;
                           冻结数量: {{ $freezeSum }}
                           &nbsp;&nbsp;
                       </p>
                       <hr>
                       <a href="{{ url('admin/mh/create') }}" class="btn-success btn-lg btn-primary">新增</a>
                        &nbsp;&nbsp;&nbsp;
                       <a href="{{ url('admin/mh/freeze') }}" class="btn-success btn-lg btn-primary">冻结</a>
                       &nbsp;&nbsp;&nbsp;
                       <a href="{{ url('admin/mh/query') }}" class="btn-success btn-lg btn-primary">查询</a>
                       &nbsp;&nbsp;&nbsp;
                       <a href="{{ url('admin/mh/massdelete') }}" class="btn-success btn-lg btn-primary">批量删码</a>
                       @if ($isAdmin == 1)
                           &nbsp;&nbsp;&nbsp;
                           <a href="{{ url('admin/mh/checkAgent') }}" class="btn-success btn-lg btn-primary">查看代理情况</a>
                       @endif
                       @foreach ($activates as $activate)
                            <hr>
                            <div class="activate">
                                <h4>{{ $activate->register }}</h4>
                                <div class="content">
                                    {{ $activate->UUID }}
                                    <div class="pull-right text-center">
                                        <form action="{{ url('admin/mh/delete/'.$activate->id) }}" method="POST" style="display: inline;">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger">删除</button>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="paginate">
                    {{ $activates->links() }}
                </div>
            </div>
        </div>
    </div>


@endsection
