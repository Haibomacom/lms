@extends('admin.layout')

@section('title')@endsection

@section('css')
@endsection

@section('content')
<div class="ui container">
    <div class="ui breadcrumb">
        <i class="dashboard icon"></i>
        <a class="section" href="{{ url('admin') }}">管理后台</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/book') }}">图书管理</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/book/add') }}">新增图书</a>
    </div>
    <div class="ui segment">
        <form class="ui form" method="post" action="{{ url('admin/book/add') }}">
            <div class="two fields">
                <div class="field">
                    <label>书名</label>
                    <input type="text" name="title" placeholder="书名">
                </div>
                <div class="field">
                    <label>ISBN</label>
                    <input type="text" name="isbn" placeholder="ISBN">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>作者</label>
                    <input type="text" name="author" placeholder="作者">
                </div>
                <div class="field">
                    <label>分类</label>
                    <input type="text" name="category" placeholder="分类">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>出版社</label>
                    <input type="text" name="publish_house" placeholder="出版社">
                </div>
                <div class="field">
                    <label>出版时间</label>
                    <input type="text" name="publish_time" placeholder="出版时间">
                </div>
            </div>
            <div class="field">
                <label>载体形式</label>
                <input type="text" name="object" placeholder="载体形式">
            </div>
            <div class="field">
                <label>图书介绍</label>
                <textarea name="intro" placeholder="图书介绍"></textarea>
            </div>
            <div class="field">
                <label>豆瓣id</label>
                <input type="text" name="douban_id" placeholder="豆瓣id">
            </div>
            <div class="field">
                {{ csrf_field() }}
                <button class="ui primary button">新增</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
@endsection