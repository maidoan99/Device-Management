<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Device Management">
    <meta name="author" content="">

    <title>Đăng nhập</title>
    <base href="{{asset('')}}">

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Style Sheet -->
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-5 panel-default">
                <div class="login-panel panel">
                    <div class="panel-heading">
                        <h2 class="panel-title">Quản lý thiết bị</h3>
                        <h3 class="panel-title">Đăng nhập</h3>
                    </div>
                    <div class="panel-body">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}} <br>
                                @endforeach
                            </div>
                        @endif

                        @if(session('message'))
                            <div class="alert alert-danger">
                                {{session('message')}}
                            </div>
                        @endif

                        <form role="form" action="login" method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"> 
    
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="">
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">Đăng nhập</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="admin_asset/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="admin_asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>
