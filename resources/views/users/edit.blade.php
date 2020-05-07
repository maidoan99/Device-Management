@extends('layouts.app')

@section('title')
{{$title}}
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="css/edit.css">
@endsection

@section('content')
<div id="loading">
    <img src="img/loading.gif" alt="Loading..." />
</div>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-7 panel-default">
                <div class="login-panel panel">
                    <div class="panel-heading row">
                        <div class="col-7 panel-heading-item text-left edit-user">
                            <h4 class="panel-title">Thông tin của
                                <span style="color:red">{{$user->first_name}} {{$user->last_name}}</span>
                            </h4>
                        </div>
                        <div class="col-2 panel-heading-item item-btn">
                            <button><a href="{{ route('user.changerole.show', ['id' => $user->id]) }}">Change Role</a></button>
                        </div>
                        <div class="col-3 panel-heading-item item-btn">
                            <button><a href="{{ route('user.changepass.show', ['id' => $user->id]) }}">Thay đổi mật khẩu</a></button>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form id="form-submit" action="{{ route('user.update', ['id' => $user->id])}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label><b>Họ và tên đệm<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="first_name" value="{{$user->first_name}}" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('first_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Tên<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="last_name" value="{{$user->last_name}}" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('last_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Email</b></label>
                                <input class="form-control" name="email" value="{{$user->email}}" />
                            </div>
                            <div class="form-group">
                                <label><b>Giới tính</b></label>
                                <label class="radio-inline">
                                    <input name="gender" value="1" type="radio" @if($user->gender == App\User::MALE) { checked="" }
                                    @endif>Nam
                                </label>
                                <label class="radio-inline">
                                    <input name="gender" value="2" type="radio" @if($user->gender == App\User::FEMALE) { checked="" }
                                    @endif>Nữ
                                </label>
                            </div>
                            <div class="form-group">
                                <label><b>Ngày sinh</b></label>
                                <input class="form-control" id="datepicker" name="birthday" value="{{$user->birthday}}" autocomplete="off" type="date" />
                            </div>
                            <div class="form-group">
                                <label><b>Địa chỉ</b></label>
                                <input class="form-control" name="address" value="{{$user->address}}" />
                            </div>

                            <button class="btn btn-lg btn-secondary mt-3"><a href="{{ url()->previous() }}">Back</a></button>
                            <button type="submit" id="btn-submit" class="btn btn-lg btn-success mt-3">Thay đổi</button>
                            <form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var date = new Date();

        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            selectMonths: true,
            selectYears: 15,
            maxDate: date,
        });

        $('#form-submit').submit(function() {
            $('#loading').show();
        });
    });
</script>
@endsection