@extends('layouts.app')

@section('title')
Thay đổi mật khẩu
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/app.css">
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
                    <div class="panel-heading row justify-content-between">
                        <div class="col-8 text-left">
                            <h3 class="panel-title">Thay đổi mật khẩu</h3>
                        </div>
                        <div class="col-4 panel-heading-item item-btn">
                            <button>
                                <a href="{{ route('admin.show') }}">Thông tin của tôi</a>
                            </button>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form action="{{ route('admin.changepass.update')}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label><b>Mật khẩu cũ<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" type="password" name="old_password" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('old_password') }}</div>
                            @endif

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

                            <button type="submit" class="btn btn-lg btn-success" style="margin-top: 15px">Thay đổi</button>
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