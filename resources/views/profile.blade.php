@extends('layouts.app')

@section('title')
Thông tin của tôi
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/app.css">
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
                    <div class="panel-heading row justify-content-between">
                        <div class="col-8 text-left">
                            <h3 class="panel-title">{{trans('profile.my_infor')}}</h3>
                        </div>
                        <div class="col-4 panel-heading-item item-btn">
                            <button><a href="{{ route('admin.changepass.show') }}">{{trans('header.change_pass')}}</a></button>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form id="form-submit" action="{{ route('admin.update')}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label><b>{{trans('profile.first_name')}}<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="first_name" value="{{$user->first_name}}" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('first_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>{{trans('profile.last_name')}}<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="last_name" value="{{$user->last_name}}" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('last_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>{{trans('profile.email')}}</b></label>
                                <input class="form-control" name="email" value="{{$user->email}}" />
                            </div>
                            <div class="form-group">
                                <label><b>{{trans('profile.gender')}}</b></label>
                                <label class="radio-inline">
                                    <input name="gender" value="1" type="radio" @if($user->gender == App\User::MALE) { checked="" }
                                    @endif>{{trans('profile.male')}}
                                </label>
                                <label class="radio-inline">
                                    <input name="gender" value="2" type="radio" @if($user->gender == App\User::FEMALE) { checked="" }
                                    @endif>{{trans('profile.female')}}
                                </label>
                            </div>
                            <div class="form-group">
                                <label><b>{{trans('profile.birthday')}}</b></label>
                                <input class="form-control" id="datepicker" name="birthday" value="{{$user->birthday}}" autocomplete="off" type="date" />
                            </div>
                            <div class="form-group">
                                <label><b>{{trans('profile.address')}}</b></label>
                                <input class="form-control" name="address" value="{{$user->address}}" />
                            </div>

                            <button type="submit" id="btn-submit" class="btn btn-lg btn-success mt-3">{{trans('common.save')}}</button>
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
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#form-submit').submit(function() {
            $('#loading').show();
        });
    });
</script>
@endsection