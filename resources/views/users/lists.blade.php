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
                    <form action="{{route('user.search')}}">
                        <input class="input-search" type="text" name="search" placeholder="Từ khóa tìm kiếm">
                        <button class="btn btn-secondary btn-search" type="submit">Tìm kiếm</button>
                    </form>
                </div>
                <div class="col-sm-4 panel-heading-item item-btn text-right">
                    <button><a href="{{ route('user.create') }}">+ Add user</a></button>
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
                        <th scope="col" class="text-center width-5">Avatar</th>
                        <th scope="col" class="text-center width-15">Tên</th>
                        <th scope="col" class="text-center width-20">Email</th>
                        <th scope="col" class="text-center width-5">Giới tính</th>
                        <th scope="col" class="text-center width-10">Ngày sinh</th>
                        <th scope="col" class="text-center width-15">Địa chỉ</th>
                        <th scope="col" class="text-center width-5">Role</th>
                        <th scope="col" class="text-center width-20">Actition</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center" scope="row">{{$user->id}}</td>
                        <td class="text-center">
                            <img class="icon" src="{{$user->avatar}}" alt="">
                        </td>
                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                        <td class="text-center 
                            @if ($user->email_verified_at != NULL) { text-blue }
                            @endif">{{$user->email}}</td>
                        <td class="text-center">
                            @if ($user->gender == App\User::MALE) {{"Nam"}}
                            @elseif ($user->gender == App\User::FEMALE) {{"Nữ"}}
                            @endif
                        </td>
                        <td class="text-center">{{$user->birthday}}</td>
                        <td class="text-center">{{$user->address}}</td>
                        <td class="text-center 
                            @if ($user->role == App\User::ADMIN) { text-blue }
                            @elseif ($user->role == App\User::USER) { text-yellow }
                            @endif">
                            @if ($user->role == App\User::ADMIN) {{"admin"}}
                            @elseif ($user->role == App\User::USER) {{"user"}}
                            @endif
                        </td>
                        <td class="text-center">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{route('user.changepass.show', ['id' => $user->id])}}">Pass</a></li>
                                <li class="list-inline-item"><a href="{{route('user.changerole.show', ['id' => $user->id])}}">Role</a></li>
                                <li class="list-inline-item"><a href="{{route('user.show', ['id' => $user->id])}}">Edit</a></li>
                                <li class="list-inline-item"><a id="delete-item" data-id="{{$user->id}}" data-email="{{$user->email}}" data-toggle="modal" data-target="#deleteModal" href="">Delete</a></li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer d-flex">
            <div class="col-sm-4 left-panel">
                <p>Tổng số bản ghi: {{count($users)}}</p>
            </div>
            <div class="col-sm-8">
                {{ $users->links('layouts.paginate', ['paginator' => $users]) }}
            </div>
        </div>

    </div>
</div>

<!-- Attachment Modal -->
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
                        <p>Bạn có muốn xóa nhân viên <span id="item-name"></span> không?</p>
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
    $(document).on('click', '#delete-item', function() {
        var user_id = $(this).attr('data-id');
        var user_email = $(this).attr('data-email');
        $('.modal-body #item-name').text(user_email);
        var url = "{{route('user.destroy', ':id')}}";
        url = url.replace(':id', user_id);
        $("#deleteForm").attr('action', url);
    });

    $(document).on('click', 'delete-btn', function() {
        $("#deleteForm").submit();
    });
</script>
@endsection