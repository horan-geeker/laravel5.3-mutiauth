@extends('admin.layouts.app')

@section('content')
    @include('admin.components.index-component',[
    'pageTitle'=>'文章管理',
    'smallTitle'=>'所有用户文章管理',
    'linkCreateCaption'=>'新增文章',
    'createUrl'=>'/admin/posts/create/',
    'indexUrl'=>'/admin/posts/',
    'postUrl'=>'/admin/posts/',
    'search' => null,
    'tableHeaders' => ['标题','内容','作者','标签','创建时间'],
    'list' => $posts,
    'listItems' => ['title','lessContent','author','type','created_at'],
    'redirectTo' => '/'
    ])
@endsection