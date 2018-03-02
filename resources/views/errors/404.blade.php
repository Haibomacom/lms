@extends('admin.layout')

@section('title') 404 Not Found @endsection

@section('css')
@endsection

@section('content')
<div class="ui container">
    <h1 class="ui center aligned icon header" style="margin-bottom: 30px">
        <i class="warning sign red icon"></i>
        404 Not Found
    </h1>
    <div class="ui centered grid">
        <button class="ui labeled icon button" onclick="window.history.back()">
            <i class="left arrow icon"></i>
            返回上一页
        </button>
        <a class="ui right labeled icon button" href="{{ url('admin') }}">
            <i class="home icon"></i>
            返回首页
        </a>
    </div>
</div>
@endsection

@section('js')
@endsection