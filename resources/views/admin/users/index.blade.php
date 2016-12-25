@extends('admin.layouts.app')

@section('content')
    @include('admin.components.index-component',[
    'pageTitle'=>'用户管理',
    'smallTitle'=>'普通用户配置',
    'linkCreateCaption'=>'新增用户',
    'createUrl'=>'/admin/users/create/',
    'indexUrl'=>'/admin/users/',
    'postUrl'=>'/admin/users/',
    'search' => null,
    'tableHeaders' => ['名称','邮箱','创建时间'],
    'list' => $users,
    'listItems' => ['name'
    ,'email','created_at'],
    'redirectTo' => '/'
    ])
@endsection