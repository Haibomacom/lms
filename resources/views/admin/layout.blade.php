<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ asset('css/semantic.min.css') }}">
@yield('css')
</head>
<body>
@if(session('admin.id'))
<div class="ui menu stackable">
    <div class="item">借阅伴侣管理后台</div>
    <a class="item" href="{{ url('admin/dashboard') }}">控制台</a>
    <div class="ui dropdown item">用户管理 <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="{{ url('admin/user') }}">用户列表</a>
        </div>
    </div>
    <div class="ui dropdown item">图书管理 <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="{{ url('admin/book') }}">图书列表</a>
            <a class="item" href="{{ url('admin/book/search') }}">图书搜索</a>
            <a class="item" href="{{ url('admin/book/add') }}">新增图书</a>
        </div>
    </div>
    <div class="ui dropdown item">借阅管理 <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="{{ url('admin/borrow') }}">借阅列表</a>
        </div>
    </div>
    <div class="ui dropdown item">网站设置 <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="{{ url('admin/setting') }}">基本设置</a>
        </div>
    </div>
    <div class="right menu">
        <div class="item">{{ session('admin.username') }}</div>
        <a class="item" href="{{ url('admin/logout') }}">退出</a>
    </div>
</div>
@endif
@yield('content')
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/semantic.min.js') }}"></script>
<script type="text/javascript">$('.ui.dropdown').dropdown()</script>
@yield('js')
</body>
</html>