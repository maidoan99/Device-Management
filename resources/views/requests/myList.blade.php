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
                    <button><a href="{{route('request.create')}}">+ {{trans('header.add_request')}}</a></button>
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
                        <th scope="col" class="text-center width-20">{{trans('request.reason')}}</th>
                        <th scope="col" class="text-center width-10">{{trans('request.created_at')}}</th>
                        <th scope="col" class="text-center width-5">{{trans('request.status')}}</th>
                        <th scope="col" class="text-center width-20">{{trans('request.admin')}}</th>
                        <th scope="col" class="text-center width-10">{{trans('request.approved_at')}}</th>
                        <th scope="col" class="text-center width-5">{{trans('request.assign')}}</th>
                        <th scope="col" class="text-center width-15">{{trans('request.handoverd_at')}}</th>
                        <th scope="col" class="text-center width-10">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td class="text-center" scope="row">{{$request->id}}</td>
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
                            <a id="handover-item" device-item="{{$request->device_users[0]->devices}}" 
                                device-name="{{$request->device_users[0]->devices->name}}" 
                                device-category="{{\Config::get('common.category.' . $request->device_users[0]->devices->category)}}" 
                                device-user="{{$request->device_users[0]}}"
                                data-toggle="modal" data-target="#handover-modal" href="">
                                #{{$request->device_users[0]->id}}              
                            </a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($request->status == App\Request::COMPLETED) 
                                {{$request->device_users[0]->handover_at}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if (\Config::get('common.request_status.' . $request->status) == 'New')
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{route('request.show', ['id' => $request->id])}}">Edit</a></li>
                                <li class="list-inline-item"><a id="delete-item" data-id="{{$request->id}}" data-toggle="modal" data-target="#delete-modal" href="">Delete</a></li>
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
                <p>{{trans('common.number_records')}}: {{count($requests)}}</p>
            </div>
            <div class="col-sm-8">
                {{ $requests->links('layouts.paginate', ['paginator' => $requests]) }}
            </div>
        </div>
    </div>
</div>

<!-- Request Modal -->
<div class="modal fade" id="handover-modal" role="dialog" aria-labelledby="handover-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="handover-modal-label">{{trans('request.approve')}} <span class="device_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-black mb-0">
                    <div class="label-content">
                        <div class="label">{{trans('device.category')}}</div>
                        <div class="content_category"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">{{trans('device.code')}}</div>
                        <div class="content_code"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">{{trans('device.name')}}</div>
                        <div class="content_name"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">{{trans('request.handoverd_at')}}</div>
                        <div class="content_handover_at"></div>
                    </div>
                    <div class="label-content">
                        <div class="label">{{trans('request.released_at')}}</div>
                        <div class="content_released_at"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('common.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- /Attachment Modal -->

<!-- Attachment Modal -->
<div class="modal fade" id="delete-modal" role="dialog" aria-labelledby="delete-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-label">Confirm delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" action="" method="POST">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="text-black mb-0">
                        <p>{{trans('request.cf_delete')}}</p>
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
<!-- /Attachment Modal -->
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

    $(document).on('click', '#delete-item', function() {
        var request_id = $(this).attr('data-id');
        $('.modal-body #item-name').text(request_id);
        var url = "{{route('request.destroy', ':id')}}";
        url = url.replace(':id', request_id);
        $("#deleteForm").attr('action', url);
    });

    $(document).on('click', 'delete-btn', function() {
        $("#deleteForm").submit();
    });
</script>
@endsection