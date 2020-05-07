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
                    <form action="{{route('device.search')}}">
                        <input class="input-search" type="text" name="search" placeholder="Từ khóa tìm kiếm">
                        <button class="btn btn-secondary btn-search" type="submit">Tìm kiếm</button>
                    </form>
                </div>
                <div class="col-sm-4 panel-heading-item item-btn text-right">
                    <button><a href="{{ route('device.index') }}">Danh sách thiết bị</a></button>
                    <button><a href="{{ route('request.index') }}">Danh sách yêu cầu</a></button>
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
                        <th scope="col" class="text-center width-5">ID</th>
                        <th scope="col" class="text-center width-20">Tên nhân viên</th>
                        <th scope="col" class="text-center width-10">Danh mục</th>
                        <th scope="col" class="text-center width-10">Mã SP</th>
                        <th scope="col" class="text-center width-15">Tên sản phẩm</th>
                        <th scope="col" class="text-center width-15">Ngày bàn giao</th>
                        <th scope="col" class="text-center width-10">Ngày thu hồi</th>
                        <th scope="col" class="text-center width-5">YC</th>
                        <th scope="col" class="text-center width-10">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($device_users as $device_user)
                    <tr>
                        <td class="text-center" scope="row">{{$device_user->users->id}}</td>
                        <td scope="row">
                            <div><b>{{$device_user->users->first_name}} {{$device_user->users->last_name}}</b></div>
                            <span class="text-blue"><i>{{$device_user->users->email}}</i></span>
                        </td>
                        <td>{{\Config::get('common.category.' . $device_user->devices->category)}}</td>
                        <td>{{$device_user->devices->code}}</td>
                        <td>{{$device_user->devices->name}}</td>
                        <td class="text-center">{{$device_user->handover_at}}</td>
                        <td class="text-center">{{$device_user->released_at}}</td>
                        <td class="text-center popup">
                            <a id="request-item" data-id="{{$device_user->request_id}}" data-name="{{$device_user->users->first_name}} {{$device_user->users->last_name}}" data-reason="{{$device_user->requests->reason}}" data-toggle="modal" data-target="#request-modal" href="">
                                @if($device_user->released_at != '') #{{$device_user->request_id}}
                                @endif
                            </a>
                        </td>
                        <td class="text-center popup">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a id="release-item" user-id="{{$device_user->users->id}}" device-id="{{$device_user->devices->id}}" user-name="{{$device_user->users->first_name}} {{$device_user->users->last_name}}" device-name="{{$device_user->devices->name}}" data-toggle="modal" data-target="#release-modal" href="">
                                        @if($device_user->released_at == '') {{ "Thu hồi" }} 
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </td>
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

<!-- Request Modal -->
<div class="modal fade" id="request-modal" role="dialog" aria-labelledby="request-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-modal-label">Yêu cầu #<span class="request_id"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-black mb-0">
                    <p>Nhân viên <span class="user_name"></span> đã yêu cầu thiết bị, lí do:</p>
                    <textarea class="reason w-100" type="text" rows="3" disabled></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- /Attachment Modal -->

<!-- Release Modal -->
<div class="modal fade" id="release-modal" role="dialog" aria-labelledby="release-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-modal-label">Thu hồi <span class="device_name"></span> của nhân viên <span class="user_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="updateForm" action="" method="POST">
                {{method_field('post')}}
                {{csrf_field()}}
            <div class="modal-body">
                <div class="text-black mb-0">
                    <p>Ngày thu hồi</p>
                    <input id="datepicker" class="released_at" type="text" value="" autocomplete="off" name="released_at">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary" id="submit-btn">Thay đổi</button>
            </div>
        </div>
    </div>
</div>
<!-- /Attachment Modal -->

@endsection

@section('script')
<script>
    $(document).on('click', '#request-item', function() {
        var request_id = $(this).attr('data-id');
        var user_name = $(this).attr('data-name');
        var resason = $(this).attr('data-reason');
        $('.modal-header .request_id').text(request_id);
        $('.modal-body .user_name').text(user_name);
        $('.modal-body .reason').text(resason);
    });

    $(document).on('click', '#release-item', function() {
        var device_name = $(this).attr('device-name');
        var user_name = $(this).attr('user-name');
        $('.modal-header .modal-title .device_name').text(device_name);
        $('.modal-header .modal-title .user_name').text(user_name);

        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();

        var today = date.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
        });
        $('.modal-body .released_at').val(today);

        var user_id = $(this).attr('user-id');
        var device_id = $(this).attr('device-id');
        var url = "{{route('device.release', [':device_id', ':user_id'])}}";
        url = url.replace(':user_id', user_id);
        url = url.replace(':device_id', device_id);
        $("#updateForm").attr('action', url);
    });

    $(document).on('click', 'submit-btn', function() {
        $("#updateForm").submit();
    });
</script>
@endsection