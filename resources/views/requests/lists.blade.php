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
                    <form action="{{route('request.search')}}">
                        <input class="input-search" type="text" name="search" placeholder="Từ khóa tìm kiếm">
                        <button class="btn btn-secondary btn-search" type="submit">Tìm kiếm</button>
                    </form>
                </div>
                <div class="col-sm-4 panel-heading-item item-btn text-right">
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
                        <th scope="col" class="text-center width-15">Nhân viên yêu cầu</th>
                        <th scope="col" class="text-center width-15">Lý do</th>
                        <th scope="col" class="text-center width-10">Ngày tạo</th>
                        <th scope="col" class="text-center width-5">Tình trạng</th>
                        <th scope="col" class="text-center width-15">Người xác nhận</th>
                        <th scope="col" class="text-center width-10">Ngày xác nhận</th>
                        <th scope="col" class="text-center width-5">Bàn giao</th>
                        <th scope="col" class="text-center width-10">Ngày bàn giao</th>
                        <th scope="col" class="text-center width-10">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td class="text-center" scope="row">{{$request->id}}</td>
                        <td>
                            <div><b>{{$request->users->first_name}} {{$request->users->last_name}}</b></div>
                            <span class="text-blue"><i>{{$request->users->email}}</i></span>
                        </td>
                        <td scope="row">{{$request->reason}}</td>
                        <td class="text-center" scope="row">{{$request->created_at->format('yy-m-d')}}</td>
                        <td>{{\Config::get('common.request_status.' . $request->status)}}</td>
                        <td>
                            @if($request->leader_id != NULL)
                            <div><b>{{$request->leaders->first_name}} {{$request->leaders->last_name}}</b></div>
                            <span class="text-blue"><i>{{$request->leaders->email}}</i></span>
                            @endif
                        </td>
                        <td class="text-center" scope="row">
                            @if ($request->approved_at != NULL) {{$request->approved_at->format('yy-m-d')}}
                            @endif
                        </td>
                        <td class="text-center popup" scope="row">
                            @if ($request->status == App\Request::COMPLETED)
                            <a id="handover-item" device-item="{{$request->device_users->first()->devices}}" 
                                device-name="{{$request->device_users->first()->devices->name}}" 
                                device-category="{{\Config::get('common.category.' . $request->device_users->first()->devices->category)}}" 
                                device-user="{{$request->device_users->first()}}"
                                data-toggle="modal" data-target="#handover-modal" href="">
                                #{{$request->device_users->first()->id}}              
                            </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($request->status == App\Request::COMPLETED) 
                                {{$request->device_users->first()->handover_at}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if (\Config::get('common.request_status.' . $request->status) == 'New')
                            <ul class="list-inline">
                                <li class="list-inline-item"><a id="approve-item" request-id="{{$request->id}}" user-id="{{Auth::user()->id}}" data-toggle="modal" data-target="#approve-modal" href="">Approve</a></li>
                                <li class="list-inline-item"><a id="reject-item" request-id="{{$request->id}}" user-id="{{Auth::user()->id}}" data-toggle="modal" data-target="#reject-modal" href="">Reject</a></li>
                            </ul>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer d-flex">
            <div class="col-sm-4 left-panel">
                <p>Tổng số bản ghi: {{count($requests)}}</p>
            </div>
            <div class="col-sm-8">
                {{ $requests->links('layouts.paginate', ['paginator' => $requests]) }}
            </div>
        </div>
    </div>
</div>

<!-- Handover Modal -->
<div class="modal fade" id="handover-modal" role="dialog" aria-labelledby="handover-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="handover-modal-label">Bàn giao <span class="device_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-black mb-0">
                    <div class="label-content">
                        <div class="label">Danh mục</div>
                        <div class="content_category"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">Mã sản phẩm</div>
                        <div class="content_code"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">Tên sản phẩm</div>
                        <div class="content_name"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">Ngày bàn giao</div>
                        <div class="content_handover_at"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">Ngày thu hồi</div>
                        <div class="content_released_at"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- /Handover Modal -->

<!-- Approve Modal -->
<div class="modal fade" id="approve-modal" role="dialog" aria-labelledby="approve-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-label">Confirm approve</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approveForm" action="" method="POST">
                {{method_field('post')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="text-black mb-0">
                        <p>Bạn có muốn xác nhận yêu cầu này phải không?</p>
                        <input class="status" type="hidden" name="status" value="">
                        <input class="approved_at" type="hidden" name="approved_at" value="">
                        <input class="leader_id" type="hidden" name="leader_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="approve-btn">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Approve Modal -->

<!-- Reject Modal -->
<div class="modal fade" id="reject-modal" role="dialog" aria-labelledby="reject-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-label">Confirm reject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" action="" method="POST">
                {{method_field('post')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="text-black mb-0">
                        <p>Bạn có muốn từ chối yêu cầu này phải không?</p>
                        <input class="status" type="hidden" name="status" value="">
                        <input class="approved_at" type="hidden" name="approved_at" value="">
                        <input class="leader_id" type="hidden" name="leader_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="reject-btn">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Approve Modal -->
@endsection

@section('script')
<script>
    $(document).on('click', '#handover-item', function() {
        var device_name = $(this).attr('device-name');
        $('.modal-header .device_name').text(device_name);

        var device = JSON.parse($(this).attr('device-item'));
        var device_user = JSON.parse($(this).attr('device-user'));
        var category = $(this).attr('device-category');

        $('.modal-body .content_category').text(category);
        $('.modal-body .content_code').text(device.code);
        $('.modal-body .content_name').text(device.name);
        $('.modal-body .content_handover_at').text(device_user.handover_at);
        $('.modal-body .content_released_at').text(device_user.released_at);
    });

    function setApproveTime() {
        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var today = date.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        $(".approved_at").attr('value', today);
    }

    $(document).on('click', '#approve-item', function() {
        setApproveTime();

        $(".status").attr('value', 2);

        var leader_id = $(this).attr('user-id');
        $(".leader_id").attr('value', leader_id);

        var request_id = $(this).attr('request-id');
        var url = "{{route('request.approve', ':id')}}";
        url = url.replace(':id', request_id);
        $("#approveForm").attr('action', url);
    });

    $(document).on('click', 'approve-btn', function() {
        $("#approveForm").submit();
    });

    $(document).on('click', '#reject-item', function() {
        setApproveTime();

        $(".status").attr('value', 3);

        var leader_id = $(this).attr('user-id');
        $(".leader_id").attr('value', leader_id);

        var request_id = $(this).attr('request-id');
        var url = "{{route('request.approve', ':id')}}";
        url = url.replace(':id', request_id);
        $("#rejectForm").attr('action', url);
    });

    $(document).on('click', 'reject-btn', function() {
        $("#rejectForm").submit();
    });
</script>
@endsection