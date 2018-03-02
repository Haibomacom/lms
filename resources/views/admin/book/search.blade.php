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
        <a class="section" href="{{ url('admin/book/search') }}">搜索图书</a>
    </div>
    <div class="ui segment">
        <div class="ui two column centered grid">
            <form class="column" method="post" action="{{ url('admin/book/search') }}">
                <div class="ui fluid action input">
                    <input type="text" name="search" placeholder="输入书名、作者、isbn、出版社" value="{{ $search or '' }}">
                    <button class="ui button" type="submit">搜索</button>
                </div>
            </form>
        </div>
        <div class="ui list">
            <table class="ui celled table" width="100%">
                <thead>
                <tr>
                    <th>图书id</th>
                    <th>书名</th>
                    <th>分类</th>
                    <th>作者</th>
                    <th>isbn</th>
                    <th>出版社</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

                {{--@foreach($list as $book)--}}

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                {{--@endforeach--}}

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection