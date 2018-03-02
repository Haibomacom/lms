@extends('admin.layout')

@section('title') 用户列表 @endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/dataTables.semanticui.min.css') }}">
@endsection

@section('content')
<div class="ui container">
    <div class="ui breadcrumb">
        <i class="dashboard icon"></i>
        <a class="section" href="{{ url('admin') }}">管理后台</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/user') }}">用户管理</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ url('admin/user') }}">用户列表</a>
    </div>
    <div class="ui segment">
        <table id="list" class="ui celled striped table">
            <thead>
            <tr>
                <th>用户id</th>
                <th>用户组</th>
                <th>手机号码</th>
                <th>注册时间</th>
                <th>上次活动时间</th>
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
<script type="text/javascript">$(document).ready(function(){$('#list').DataTable({language:{"sProcessing":"处理中...","sLengthMenu":"显示 _MENU_ 项结果","sZeroRecords":"没有匹配结果","sInfo":"显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项","sInfoEmpty":"显示第 0 至 0 项结果，共 0 项","sInfoFiltered":"(由 _MAX_ 项结果过滤)","sInfoPostFix":"","sSearch":"搜索手机号码:","sUrl":"","sEmptyTable":"表中数据为空","sLoadingRecords":"载入中...","sInfoThousands":",","oPaginate":{"sFirst":"首页","sPrevious":"上页","sNext":"下页","sLast":"末页"},"oAria":{"sSortAscending":": 以升序排列此列","sSortDescending":": 以降序排列此列"}},processing:true,serverSide:true,ordering:false,deferRender:true,ajax:'{{ url('admin/user/data') }}',columns:[{data:'id',searchable:false},{data:'role',searchable:false},{data:'mobile'},{data:'created_at',searchable:false},{data:'updated_at',searchable:false},{data:function(a){return'<a class="ui mini button" href="{{ url('admin/user') }}/'+a.id+'">查看详情</a>'},searchable:false,width:90}]})})</script>
@endsection