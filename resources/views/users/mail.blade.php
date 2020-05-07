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
            <p>Dear {{$name}},</p>
            <p>Bạn đã dăng kí thành công tài khoản của chúng tôi với Email và Mật khẩu sau đây:</p>
            <p>Email: {{$email}}</p>
            <p>Password: {{$password}}</p>
            <p>Chúc bạn sử dụng dịch vụ của chúng tôi vui vẻ.</p>
            <p>Xin chân thành cảm ơn.</p>
            <p>Admin.</p>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>
