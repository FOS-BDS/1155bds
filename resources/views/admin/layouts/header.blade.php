<header class="header">
    <a class="logo" href="/">FOS</a>
    <div class="navbar navbar-static-top" role="navigation">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="collapsed navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown sub-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-tasks"></i>
                        <span>{!!Lang::get('app.rule_manager')!!} <i class="caret"></i></span>
                    </a>
                    <ul class="menu dropdown-menu">
                        <li class="header">
                            <a href="{{url('admin/conditions')}}">
                                <i class="fa fa-tasks"></i>
                                {!!Lang::get('app.conditions')!!}
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/rules')}}">
                                <i class="fa fa-tasks"></i>
                                {!!Lang::get('app.rules')!!}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span>{!!Session::get('user.username')!!} <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                                <p>
                                    {!!Session::get('user.email')!!}
                                    <small>Member since Nov. 2014</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/users/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>