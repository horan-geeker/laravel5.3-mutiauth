@extends('admin.layouts.app')
@section('content')
    @include('admin.components.create-edit-component',[
    'pageTitle'=>'新增管理员',
    'smallTitle'=>'权限配置',
    'indexUrl'=>'/managers/',
    'postUrl'=>'/managers/',
    'formItems' => [
            [
                'text'=>'名称',
                'name'=>'name',
                'require' => [
                    [
                        'role_type'=>'data-rule-maxlength',
                        'role_value' => '50',
                    ]
                ]
            ],
            [
                'text'=>'邮箱',
                'name'=>'email',
            ],
            [
                'text'=>'权限',
                'name'=>'permissions',
                'type'=>'checkbox',
                'checkbox'=> [
                    'value'=>'name',
                    'description'=>'description',
                    'lists'=>$permissions
                ]
            ]
        ],
    ])
@endsection