<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="">
            <span class="logo-entry logo-main current-logo loaded" style="width:200px; height: 47px; color:white">
                KIAISOFT
            </span>
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="list-menu">
            <a class="menu-item {{ Route::is('me.device.index') ? 'active' : '' }}" href="{{route('me.device.index')}}">{{ trans('header.my_device') }}</a>
            <a class="menu-item {{ Route::is('request.me.index') ? 'active' : '' }}" href="{{route('request.me.index')}}">{{ trans('header.my_request') }}</a>
            @if(Auth::user()->role == 1)
            <a class="menu-item {{ Route::is('device.index') ? 'active' : '' }}" href="{{route('device.index')}}">{{trans('header.list_device')}}</a>
            <a class="menu-item {{ Route::is('device.user.index') ? 'active' : '' }}" href="{{route('device.user.index')}}">{{trans('header.user_list_device')}}</a>
            <a class="menu-item {{ Route::is('request.index') ? 'active' : '' }}" href="{{route('request.index')}}">{{trans('header.list_request')}}</a>
            <a class="menu-item {{ Route::is('user.index') ? 'active' : '' }}" href="{{route('user.index')}}">{{trans('header.list_user')}}</a>
            @else

            @endif

            <span class="d-inline-block ml-3">
                <form action="{{ route('lang') }}" class="form-lang" method="post">
                    <select name="locale" onchange='this.form.submit();'>
                        <option value="vi">{{ trans('header.lang.vi') }}</option>
                        <option value="en" {{ Lang::locale() === 'en' ? 'selected' : '' }}>{{ trans('header.lang.en') }}</option>
                    </select>
                    {{ csrf_field() }}
                </form>
            </span>

            <span class="user-icon ml-3"><a href="{{route('logout')}}"><img src="img/user.png" alt="" class="icon"></a></span>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
</nav>