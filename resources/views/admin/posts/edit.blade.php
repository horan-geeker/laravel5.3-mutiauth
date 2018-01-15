@extends('admin.layouts.app')
@section('content')
    @include('admin.components.create-edit-component',[
    'obj'=>$post,
    'pageTitle'=>'编辑文章',
    'smallTitle'=>'编辑用户文章',
    'indexUrl'=>'/admin/posts/',
    'postUrl'=>"/posts/$post->id/",
    'formItems' => [
            [
                'text'=>'标题',
                'name'=>'title',
                'require' => [
                    [
                        'role_type'=>'data-rule-maxlength',
                        'role_value' => '50',
                    ]
                ]
            ],
            [
                'text'=>'内容',
                'name'=>'content',
                'type'=>'textarea'
            ],
            [
                'text'=>'标签',
                'name'=>'tag',
                'type'=>'select',
                'options'=>[
                    'value'=>'id',
                    'description'=>'type',
                    'lists'=>$tags
                ]
            ]
        ],
    ])
@endsection