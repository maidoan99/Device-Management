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
                            <h4 class="panel-title">Thêm thiết bị</h4>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form id="form-submit" action="{{route('device.store')}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label><b>Danh mục<span class="obligatory"> (*)</span></b></label>
                                <select name="category" class="w-75">
                                    @for ($i = 1; $i <= count(\Config::get('common.category')); $i++) <option value="{{ $i }}">{{\Config::get('common.category.' . $i)}}</option>
                                        @endfor
                                </select>
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('category') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Tên sản phẩm<span class="obligatory"> (*)</span></b></label>
                                <input class="form-control w-75" name="name" />
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('name') }}</div>
                            @endif

                            <div class="form-group">
                                <label><b>Giá</b></label>
                                <input class="form-control w-75" name="price" />
                            </div>

                            <div class="form-group">
                                <label><b>Mô tả</b></label>
                                <textarea name="description" class="form-control w-75" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label><b>Trạng thái</b></label>
                                <select name="status" class="w-75">
                                    @for ($i = 1; $i <= count(\Config::get('common.status')); $i++) <option value="{{ $i }}">{{\Config::get('common.status.' . $i)}}</option>
                                        @endfor
                                </select>
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('status') }}</div>
                            @endif

                            <button class="btn btn-lg btn-secondary mt-3"><a href="{{ url()->previous() }}">Back</a></button>
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
        $('#form-submit').submit(function() {
            $('#loading').show();
        });
    });
</script>
@endsection