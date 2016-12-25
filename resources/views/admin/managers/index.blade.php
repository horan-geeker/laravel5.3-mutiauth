@extends('admin.layouts.app')

@section('content')
    @include('admin.components.index-component',[
    'pageTitle'=>'管理员配置',
    'smallTitle'=>'权限配置',
    'linkCreateCaption'=>'新增管理员',
    'createUrl'=>'/admin/managers/create/',
    'indexUrl'=>'/admin/managers/',
    'postUrl'=>'/admin/managers/',
    'search' => null,
    'tableHeaders' => ['名称','邮箱','创建时间'],
    'list' => $managers,
    'listItems' => ['name'
    ,'email','created_at'],
    'redirectTo' => '/'
    ])
@endsection