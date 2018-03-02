@extends('admin.layout')

@section('title') 图书详情[{{ $book->title }}]@endsection

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
        <a class="section" href="{{ url('admin/book/' . $book->id) }}">{{ $book->title }}</a>
    </div>
    <div class="ui segment">
        <form class="ui form" method="post" action="{{ url('admin/book/edit') }}">
            <div class="two fields">
                <div class="field">
                    <label>书名</label>
                    <input type="text" name="title"
                           placeholder="{{ $book->title }}"
                           value="{{ $book->title }}">
                </div>
                <div class="field">
                    <label>ISBN</label>
                    <input type="text" name="isbn"
                           placeholder="{{ $book->isbn }}"
                           value="{{ $book->isbn }}">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>作者</label>
                    <input type="text" name="author"
                           placeholder="{{ $book->author->name_cn }}"
                           value="{{ $book->author->name_cn }}">
                </div>
                <div class="field">
                    <label>分类</label>
                    <input type="text" name="category"
                           placeholder="{{ $book->category->name }}"
                           value="{{ $book->category->name }}">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>出版社</label>
                    <input type="text" name="publish_house"
                           placeholder="{{ $book->publish_house }}"
                           value="{{ $book->publish_house }}">
                </div>
                <div class="field">
                    <label>出版时间</label>
                    <input type="text" name="publish_time"
                           placeholder="{{ $book->publish_time }}"
                           value="{{ $book->publish_time }}">
                </div>
            </div>
            <div class="field">
                <label>载体形式</label>
                <input type="text" name="object"
                       placeholder="{{ $book->object }}"
                       value="{{ $book->object }}">
            </div>
            <div class="field">
                <label>图书介绍</label>
                <textarea name="intro" placeholder="{{ $book->intro }}">{{ $book->intro }}</textarea>
            </div>
            <div class="field">
                <label>豆瓣id</label>
                <input type="text" name="object"
                       placeholder="{{ $book->douban_id }}"
                       value="{{ $book->douban_id }}">
            </div>
            <div class="field">
                <label>各大商店价格</label>
                <table class="ui celled table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>当前状态</th>
                        <th>位置</th>
                        <th>价格/元</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($book->location as $location)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if($location->status==1)<td class="positive">可借阅</td>@else<td class="negative">已借出</td>@endif

                        <td>{{ $location->location }}</td>
                        <td>{{ $location->money }}</td>
                    </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="field">
                <label>借阅位置</label>
                <table class="ui celled table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>平台</th>
                        <th>价格/元</th>
                        <th>其他信息</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach(json_decode($book->douban_price) as $price)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $price->shop }}</td>
                        <td>{{ $price->price }}</td>
                        <td>{{ $price->other }}</td>
                    </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="field">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $book->id }}">
                <button class="ui primary button">确认修改</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
@endsection