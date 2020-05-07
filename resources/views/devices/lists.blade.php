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
                    <button><a href="{{ route('device.create') }}">+ Thêm thiết bị</a></button>
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
            <table class="table table-bordered" data-toggle="modal" data-target="#confirmModal">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center width-5">ID</th>
                        <th scope="col" class="text-center width-10">Danh mục</th>
                        <th scope="col" class="text-center width-10">Mã SP</th>
                        <th scope="col" class="text-center width-15">Tên sản phẩm</th>
                        <th scope="col" class="text-center width-15">Mô tả</th>
                        <th scope="col" class="text-center width-10">Giá</th>
                        <th scope="col" class="text-center width-10">Trạng thái</th>
                        <th scope="col" class="text-center width-25">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devices as $device)
                    <tr>
                        <td class="text-center" scope="row">{{$device->id}}</td>
                        <td>{{\Config::get('common.category.' . $device->category)}}</td>
                        <td>{{$device->code}}</td>
                        <td>{{$device->name}}</td>
                        <td>{{$device->description}}</td>
                        <td class="text-center">{{ number_format($device->price) }}</td>
                        <td>{{\Config::get('common.status.' . $device->status)}}</td>
                        <td class="text-center">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a id="assign-item" device-code="{{$device->code}}" device-name="{{$device->name}}" device-id="{{$device->id}}" data-toggle="modal" data-target="#assign-modal" href="">Assign</a></li>
                                <li class="list-inline-item"><a id="history-item" device-code="{{$device->code}}" device-name="{{$device->name}}" device-id="{{$device->id}}" data-toggle="modal" data-target="#history-modal" href="">History</a></li>
                                <li class="list-inline-item"><a href="{{route('device.show', ['id' => $device->id])}}">Edit</a></li>
                                <li class="list-inline-item">
                                    <a id="delete-item" data-id="{{$device->id}}" data-name="{{$device->name}}" data-toggle="modal" data-target="#deleteModal" href="">Delete</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer d-flex">
            <div class="col-sm-4 left-panel">s
                <p>Tổng số bản ghi: {{count($devices)}}</p>
            </div>
            <div class="col-sm-8">
                {{ $devices->links('layouts.paginate', ['paginator' => $devices]) }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" action="" method="POST">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="text-black mb-0">
                        <p>Bạn có muốn xóa thiết bị <span id="item-name"></span> không?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="delete-btn">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<!-- Assign Modal -->
<div class="modal fade" id="assign-modal" role="dialog" aria-labelledby="assign-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assign-modal-label">
                    <span class="device_code"></span>:
                    <span class="device_name"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignForm" action="" method="POST">
                {{method_field('post')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="text-black mb-0 w-75 mx-auto" >
                        <div class="error-message ml-0"></div>
                        <div class="assign-choose">
                            <label class="radio-inline w-25">
                                <input name="status" value="1" type="radio">Bàn giao
                            </label>
                            <label class="radio-inline w-25">
                                <input name="status" value="2" type="radio">Thu hồi
                            </label>
                        </div>

                        <div class="assign-date">
                            <p>Ngày bàn giao/thu hồi</p>
                            <input id="datepicker" class="assign_date" type="text" value="" autocomplete="off" name="date">
                        </div>
                        <div class="staff">
                            <p>Bạn muốn bàn giao thiết bị cho</p>
                            <select name="user_id" class="staff-name w-75">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="request">
                            <p>Thiết bị được mua bởi yêu cầu</p>
                            <select name="request_id" class="reason w-100">
                                @foreach($requests->whereIn('status', [App\Request::APPROVED, App\Request::COMPLETED]) as $request)
                                <option value="{{$request->id}}">{{$request->reason}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="assign-btn">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Assign Modal -->

<!-- History Modal -->
<div class="modal fade" id="history-modal" role="dialog" aria-labelledby="history-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="history-modal-label">Lịch sử bàn giao thiết bị
                    <span class="device_code"></span>:
                    <span class="device_name"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignForm" action="" method="POST">
                {{method_field('post')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="text-black mb-0 w-100" >
                        <table class="table table-bordered main-table" data-toggle="modal" data-target="#confirmModal">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-center width-40" fieldName="user">Tên nhân viên</th>
                                    <th scope="col" class="text-center width-30" fieldName="handover_at">Ngày bàn giao</th>
                                    <th scope="col" class="text-center width-30" fieldName="released_at">Ngày thu hồi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /History Modal -->

@endsection

@section('script')
<script>
    $(document).on('click', '#delete-item', function() {
        var device_id = $(this).attr('data-id');
        var device_name = $(this).attr('data-name');
        $('.modal-body #item-name').text(device_name);
        var url = "{{route('device.destroy', ':id')}}";
        url = url.replace(':id', device_id);
        $("#deleteForm").attr('action', url);
    });

    $(document).on('click', 'delete-btn', function() {
        $("#deleteForm").submit();
    });

    function getUser(device_id) {
        var url_tmp = "{{route('device.user', ':id')}}";
        url_tmp = url_tmp.replace(':id', device_id);

        $.ajax({
            type: 'GET',
            url: url_tmp,
            async: false,
            success: function(data) {
                if (data.user !== undefined) {
                    $('#assign-modal .modal-body .staff-name').val(data.user);
                } else {
                    $('#assign-modal .modal-body .staff-name option:first').prop('selected', true);
                }
            }
        });
    }

    function getReason(device_id) {
        var url_tmp = "{{route('device.reason', ':id')}}";
        url_tmp = url_tmp.replace(':id', device_id);

        $.ajax({
            type: 'GET',
            url: url_tmp,
            async: false,
            success: function(data) {
                if (data.reason !== undefined) {
                    $('#assign-modal .modal-body .reason').val(data.reason);
                } else {
                    $('#assign-modal .modal-body .reason option:first').prop('selected', true);
                }
            }
        });
    }

    function checkAssign() {
        if ($('select[name=user_id] option').filter(':selected').val() != undefined && $('#assign-modal .modal-body input[name=status]:checked').val() == 1) return false;
        return true;
    }

    function checkStatus() {
        if ($('#assign-modal .modal-body input[name=status]:checked').val() == undefined) return false;
        return true;
    }

    $(document).on('click', '#assign-item', function() {
        $('#assign-modal .modal-body .error-message').text('');
        var device_code = $(this).attr('device-code');
        $('#assign-modal .modal-header .modal-title .device_code').text(device_code);
        var device_name = $(this).attr('device-name');
        $('#assign-modal .modal-header .modal-title .device_name').text(device_name);

        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var today = date.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
        });
        $('#assign-modal .modal-body .assign_date').val(today);

        var device_id = $(this).attr('device-id');
        getUser(device_id);
        getReason(device_id);

        var url = "{{route('device.assign', [':device_id', ':user_id'])}}";
        url = url.replace(':user_id', $('.modal-body .staff-name').val());
        url = url.replace(':device_id', device_id);
        $("#assignForm").attr('action', url);
    });

    $(document).on('click', '#assign-btn', function(e) {
        if (!checkStatus()) {
            e.preventDefault();
            $('#assign-modal .modal-body .error-message').text('Bạn chưa chọn Bàn giao/Thu hồi');
        } else if (!checkAssign()) {
            e.preventDefault();
            $('#assign-modal .modal-body .error-message').text('Thiết bị này đang được assign cho nhân viên khác');
        } else {
            $("#assignForm").submit();
        }
    });

    $(document).on('click', '#history-item', function() {
        var device_code = $(this).attr('device-code');
        $('#history-modal .modal-header .modal-title .device_code').text(device_code);
        var device_name = $(this).attr('device-name');
        $('#history-modal .modal-header .modal-title .device_name').text(device_name);

        var device_id = $(this).attr('device-id');
        var url_tmp = "{{route('device.history', ':id')}}";
        url_tmp = url_tmp.replace(':id', device_id);

        var fields = $('.main-table th[fieldName]');
        $('.main-table tbody').empty();

        $.ajax({
            method: 'GET',
            url: url_tmp,
            async: false,
            success: function(data) {
                $.each(data, function(index, item) {
                    var rowHTML = $('<tr></tr>');
                    $.each(fields, function(fieldIndex, fieldItem) {
                        var fieldName = fieldItem.getAttribute('fieldName');
                        var value = item[fieldName];
                        var cls = 'text-left';

                        if (value == null) value = '';
                        if (fieldName == 'handover_at' || fieldName == 'released_at') cls = 'text-center';

                        rowHTML.append('<td class = "' + cls + '">' + value + '</td');
                    });

                    $('.main-table tbody').append(rowHTML);
                });
            }
        });
    });
</script>
@endsection