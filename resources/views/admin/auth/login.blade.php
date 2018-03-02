@extends('admin.layout')

@section('title') 后台登录 @endsection

@section('css')
<style type="text/css">
    body {
        background-color: #fafafa;
    }

    .column {
        max-width: 450px;
        margin: 200px 10px 0;
    }
</style>
@endsection

@section('content')
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui header">后台登录</h2>
        <form class="ui large form" method="post" action="{{ url('admin/login') }}">
            <div class="ui raised segment">
                <div class="field{{ $errors->has('username') ? ' error' : '' }}">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" placeholder="管理账户" value="{{ old('username') }}">
                    </div>
                </div>
                <div class="field{{ $errors->has('password') ? ' error' : '' }}">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="管理密码">
                    </div>
                </div>
                {{ csrf_field() }}
                <button class="ui fluid large primary submit button" type="submit">登录</button>
            </div>

            @if(!$errors->isEmpty())<div class="ui error message" style="display: block">{{ $errors->first() }}</div>@endif

        </form>
    </div>
</div>
@endsection

@section('js')
@endsection