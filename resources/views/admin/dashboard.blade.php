@extends('admin.layout')

@section('title')控制台@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.semanticui.min.css') }}">
@endsection

@section('content')
<div class="ui container">
    <div class="ui breadcrumb">
        <i class="dashboard icon"></i>
        <a class="section" href="{{ url('admin') }}">管理后台</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/dashboard') }}">控制台</a>
    </div>
    <div class="ui segment">
        <div class="ui four statistics">
            <div class="statistic green">
                <div class="value">{{ $data['newUser'] }}</div>
                <div class="label">今日新增用户</div>
            </div>
            <div class="statistic orange">
                <div class="value">{{ $data['activeUser'] }}</div>
                <div class="label">今日活跃用户</div>
            </div>
            <div class="statistic yellow">
                <div class="value">{{ $data['newBorrow'] }}</div>
                <div class="label">今日新增借阅</div>
            </div>
            <div class="statistic blue">
                <div class="value">{{ $data['finishBorrow'] }}</div>
                <div class="label">今日完成付款</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection