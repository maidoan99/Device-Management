@extends('layouts.app')

@section('title')
{{$title}}
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="css/edit.css">
@endsection

@section('content')
<div id="loading" style="display:none">
    <img src="img/loading.gif" alt="Loading..." />
</div>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-7 panel-default">
                <div class="login-panel panel">
                    <div class="panel-heading row justify-content-md-center">
                        <div class="panel-heading-item text-center">
                            <h3 class="panel-title">Thay đổi mật khẩu:
                                <span style="color:red">{{$user->first_name}} {{$user->last_name}}</span>
                            </h3>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form id="form-submit" action="{{ route('user.changepass.update', ['id' => $user->id])}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label><b>Mật khẩu mới<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" type="password" name="new_password" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('new_password') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Nhập lại mật khẩu<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" type="password" name="cf_password" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('cf_password') }}</div>
                            @endif

                            <button class="btn btn-lg btn-secondary mt-3"><a href="{{ url()->previous() }}">Back</a></button>
                            <button type="submit" class="btn btn-lg btn-success mt-3">Thay đổi</button>
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
        $('#form-submit').submit(function() {
            $('#loading').show();
        });
    });
</script>
@endsection