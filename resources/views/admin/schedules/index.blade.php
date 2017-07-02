@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">
        邮件群发
        <small>对用户群发邮件</small>
    </h3>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="/admin/schedules" method="post">
                {{ csrf_field() }}
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>email</th>
                        <th>操作(<a href="#" id="selectAll">全选</a>)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><input type="checkbox" class="select" name="emails[]" value="{{ $user->email }}"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-info pull-right">发送</button>
            </form>
        </div>
    </div>

    <script>
        var selectAll = document.getElementById('selectAll')
        var select = document.getElementsByClassName('select')
        selectAll.onclick = function () {
            var selected = true
            for (var i = 0; i < select.length; i++) {
                if (!select[i].checked) {
                    selected = false
                }
            }
            if (selected) {
                for (var i = 0; i < select.length; i++) {
                    select[i].checked = false
                }
            } else {
                for (var i = 0; i < select.length; i++) {
                    select[i].checked = true
                }
            }
        }
    </script>
@endsection
