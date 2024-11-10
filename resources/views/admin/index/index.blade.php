@include('admin.layout.head')
{{--<link rel="stylesheet" href="/static/admin/css/index.css" media="all">--}}
<nav class="navbar navbar-inverse" style="border-radius: 0;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#top-header-collapse" aria-expanded="false">
                <span class="sr-only">Expand</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
        <div class="collapse navbar-collapse" id="top-header-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{url('admin/index')}}">Index <span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Data Management <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sql Execution</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Admin user <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('/logout')}}" title="To logout the Admin dashboard">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="row" style="text-align:center;"><h4>Hello {{$username}}! welcome back.</h4></div>
