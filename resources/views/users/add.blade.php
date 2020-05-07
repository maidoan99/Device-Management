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
                    <div class="panel-heading row justify-content-md-center">
                        <div class="col-7 panel-heading-item text-center">
                            <h4 class="panel-title">Thêm user</h4>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form id="form-submit" action="{{ route('user.store')}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label><b>Họ và tên đệm<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="first_name" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('first_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Tên<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="last_name" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('last_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Email<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control" name="email" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('email') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Giới tính</b></label>
                                <label class="radio-inline">
                                    <input name="gender" value="1" type="radio">Nam
                                </label>
                                <label class="radio-inline">
                                    <input name="gender" value="2" type="radio">Nữ
                                </label>
                            </div>
                            <div class="form-group">
                                <label><b>Ngày sinh</b></label>
                                <input class="form-control" id="datepicker" name="birthday" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label><b>Địa chỉ</b></label>
                                <input class="form-control" name="address" />
                            </div>

                            <button class="btn btn-lg btn-secondary ml-3"><a href="{{ url()->previous() }}">Back</a></button>
                            <button type="submit" id="btn-submit" class="btn btn-lg btn-success mt-3">Lưu</button>
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