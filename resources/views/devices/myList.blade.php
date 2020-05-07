@extends('layouts.app')

@section('title')
{{$title}}
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="css/list.css">
@endsection

@section('content')
<div id="loading">
    <img src="img/loading.gif" alt="Loading..." />
</div>

<div id="page-wrapper">
    <div class="container">
        <div class="panel">
            <div class="panel-heading row">
                <div class="col-sm-8 left-panel">
                </div>
                <div class="col-sm-4 panel-heading-item item-btn text-right">
                    <button><a href="{{route('request.me.index')}}">Yêu cầu của tôi</a></button>
                    <button><a href="{{route('request.create')}}">+ Yêu cầu thiết bị</a></button>
                </div>
            </div>
            <div class="panel-body">
                @if (session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
                @endif
            </div>
        </div>

        <div class="content">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center width-10">ID</th>
                        <th scope="col" class="text-center width-20">Danh mục</th>
                        <th scope="col" class="text-center width-20">Mã sản phẩm</th>
                        <th scope="col" class="text-center width-30">Tên sản phẩm</th>
                        <th scope="col" class="text-center width-20">Ngày nhận</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($device_users as $device_user)
                    <tr>
                        <td class="text-center" scope="row">{{$device_user->devices->id}}</td>
                        <td>{{\Config::get('common.category.' . $device_user->devices->category)}}</td>
                        <td>{{$device_user->devices->code}}</td>
                        <td>{{$device_user->devices->name}}</td>
                        <td class="text-center">{{$device_user->handover_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer d-flex">
            <div class="col-sm-4 left-panel">
                <p>Tổng số bản ghi: {{count($device_users)}}</p>
            </div>
            <div class="col-sm-8">
                {{ $device_users->links('layouts.paginate', ['paginator' => $device_users]) }}
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#form-submit').submit(function() {
            $('#loading').show();
        });
    });
</script>
@endsection