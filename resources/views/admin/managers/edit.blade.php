@extends('admin.layouts.app')
@section('content')
    @include('admin.components.create-edit-component',[
    'obj'=>$admin,
    'pageTitle'=>'编辑管理员',
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
                'array_checked'=>$admin->permissions->pluck('id')->toArray(),
                'checked_key' => 'id',
                'checkbox'=> [
                    'value'=>'name',
                    'description'=>'description',
                    'lists'=>$permissions
                ]
            ]
            //[
            //    'text'=>'权限',
            //    'name'=>'description',
            //    'type'=>'select',
            //    'options'=>[
            //        [
            //            'name'=>'超级管理员',
            //            'value'=>'superAdmin',
            //        ],
            //        [
            //            'name'=>'普通管理员',
            //            'value'=>'normalAdmin',
            //        ]
            //    ]
            //]
        ],
    ])
@endsection