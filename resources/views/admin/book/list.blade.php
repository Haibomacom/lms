@extends('admin.layout')

@section('title') 图书列表 @endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/dataTables.semanticui.min.css') }}">
@endsection

@section('content')
<div class="ui container">
    <div class="ui breadcrumb">
        <i class="dashboard icon"></i>
        <a class="section" href="{{ url('admin') }}">管理后台</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/book') }}">图书管理</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/book') }}">图书列表</a>
    </div>
    <div class="ui segment">
        <table id="list" class="ui celled table" width="100%">
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
        </table>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.semanticui.min.js') }}"></script>
<script type="text/javascript">$(document).ready(function(){$('#list').DataTable({language:{"sProcessing":"处理中...","sLengthMenu":"显示 _MENU_ 项结果","sZeroRecords":"没有匹配结果","sInfo":"显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项","sInfoEmpty":"显示第 0 至 0 项结果，共 0 项","sInfoFiltered":"(由 _MAX_ 项结果过滤)","sInfoPostFix":"","sSearch":"搜索:","sUrl":"","sEmptyTable":"表中数据为空","sLoadingRecords":"载入中...","sInfoThousands":",","oPaginate":{"sFirst":"首页","sPrevious":"上页","sNext":"下页","sLast":"末页"},"oAria":{"sSortAscending":": 以升序排列此列","sSortDescending":": 以降序排列此列"}},processing:true,serverSide:true,autoWidth:true,ajax:'{{ url('admin/book/data?include=author,category') }}',searching:false,ordering:false,deferRender:true,columns:[{data:'id'},{data:'title'},{data:'category.data.name'},{data:'author.data.name_cn'},{data:'isbn'},{data:'publish_house'},{data:function(a){return'<a class="ui mini button" href="{{ url('admin/book') }}/'+a.id+'">查看详情</a><a class="ui mini red button delete">删除</a>'},width:155}]});$('.delete').on('click',function(){alert(1)})})</script>
@endsection