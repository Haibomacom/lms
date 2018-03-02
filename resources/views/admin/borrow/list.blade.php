@extends('admin.layout')

@section('title') 借阅列表 @endsection

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
        <a class="section" href="{{ url('admin/book') }}">借阅列表</a>
    </div>
    <div class="ui segment">
        <table id="list" class="ui celled table" width="100%">
            <thead>
            <tr>
                <th>状态</th>
                <th>用户</th>
                <th>图书</th>
                <th>创建时间</th>
                <th>付款时间</th>
                <th>借阅时间</th>
                <th>归还时间</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.semanticui.min.js') }}"></script>
<script type="text/javascript">$(document).ready(function(){$('#list').DataTable({language:{"sProcessing":"处理中...","sLengthMenu":"显示 _MENU_ 项结果","sZeroRecords":"没有匹配结果","sInfo":"显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项","sInfoEmpty":"显示第 0 至 0 项结果，共 0 项","sInfoFiltered":"(由 _MAX_ 项结果过滤)","sInfoPostFix":"","sSearch":"搜索:","sUrl":"","sEmptyTable":"表中数据为空","sLoadingRecords":"载入中...","sInfoThousands":",","oPaginate":{"sFirst":"首页","sPrevious":"上页","sNext":"下页","sLast":"末页"},"oAria":{"sSortAscending":": 以升序排列此列","sSortDescending":": 以降序排列此列"}},processing:true,serverSide:true,autoWidth:true,ajax:'{{ url('admin/borrow/data?include=user') }}',searching:false,ordering:false,deferRender:true,columns:[{data:'status'},{data:function(a){return'<a href="{{ url('admin/user') }}/'+a.user.data.id+'">'+a.user.data.mobile+'</a>'}},{data:function(a){return'<a href="{{ url('admin/book') }}/'+a.book.data.id+'">'+a.book.data.title+'</a>'}},{data:'origin.created_at'},{data:'origin.paid_at'},{data:'origin.borrowed_at'},{data:'origin.restored_at'}]});$('.delete').on('click',function(){alert(1)})})</script>
@endsection