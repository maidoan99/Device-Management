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
                        <div class="col-12 panel-heading-item text-center">
                            <h4 class="panel-title">Sửa yêu cầu 
                                <span style="color:red">#{{$request->id}}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-separate"></div>
                    <div class="panel-body">

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif

                        <form id="form-submit" action="{{ route('request.update', ['id' => $request->id])}}" method="POST" enctype="multipart/form-data">
                            <!-- de truyen du lieu -->
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label><b>Lí do <span class="obligatory"> (*)</span></b></label>
                                <textarea name="reason" rows="5" class="w-100">{{$request->reason}}</textarea>
                            </div>
                            @if (count($errors) > 0)
                            <div class="error-message">{{ $errors->first('reason') }}</div>
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
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#form-submit').submit(function() {
            $('#loading').show();
        });
    });
</script>
@endsection