@extends('admin.layout')

@section('title') 用户资料 [{{ $user->mobile }}] @endsection

@section('css')
@endsection

@section('content')
<div class="ui container">
    <div class="ui breadcrumb">
        <i class="dashboard icon"></i>
        <a class="section" href="{{ url('admin') }}">管理后台</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/user') }}">用户管理</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/user/' . $user->id) }}">{{ $user->mobile }}</a>
    </div>
    <div class="ui segment">
        <div class="ui list">
            <div class="item"><div class="header">用户ID</div>{{ $user->id }}</div>
            <div class="item"><div class="header">用户组</div>{{ $user->role }}</div>
            <div class="item"><div class="header">手机号码</div>{{ $user->mobile }}}}</div>
            <div class="item"><div class="header">注册时间</div>{{ $user->created_at }}</div>
            <div class="item"><div class="header">上次活动时间</div>{{ $user->updated_at }}</div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection