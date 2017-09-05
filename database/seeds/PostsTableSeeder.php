<?php

use Illuminate\Database\Seeder;
use App\Services\KafkaService;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postJenkins = [
            'tag_id' => 4,
            'user_id' => 1,
            'title' => 'jenkins 项目回滚',
            'thumbnail' => 'http://oqngxmzlf.bkt.clouddn.com/jenkins_fun.jpeg',
            'content' => <<<MARKDOWN
## 回滚
使用（安装）插件 `Copy Artifacts Plugin`  
* 在目标项目（以hippo-web为例，一个需要在生产环境支持回滚的项目）中勾选 `Permission to Copy Artifact`
![image](http://oqngxmzlf.bkt.clouddn.com/Screen%20Shot%202017-07-09%20at%2012.17.06.png)
并且在`Post-build Actions`中添加`Archive the artificts`
![image](http://oqngxmzlf.bkt.clouddn.com/Screen%20Shot%202017-07-09%20at%2012.19.49.png)
* 新建一个专用来回滚的项目（hippo-web-rollback）
* 勾选`This project is parameterized`使用`String Parameter`如下:
```
Name: PL_BUILD_NUMBER
Default Value: 空
Description: 空
```
![image](http://oqngxmzlf.bkt.clouddn.com/Screen%20Shot%202017-07-09%20at%2015.16.45.png)
* Build 选项中使用`Copy artifacts from another project`,配置如下
```
Project name: hippo-web
Which build: Speicific build
Build number: \${PL_BUILD_NUMBER}
Target directory: ../hippo-web
```
![image](http://oqngxmzlf.bkt.clouddn.com/Screen%20Shot%202017-07-09%20at%2015.17.06.png)
* 在构建回滚项目时，输入目标项目(hippo-web)的构建号进行构建，因为该项目的每次构建都会创建一个副本在服务器jenkins目录的jobs文件夹里，此时的回滚就是复制了一份久的文件覆盖了`../hippo-web`目录，也就是`hippo-web`的实际工作目录
![image](http://oqngxmzlf.bkt.clouddn.com/Screen%20Shot%202017-07-09%20at%2015.16.45.png)
* 最后在回滚时选择回滚项目(hippo-web-rollback)，手动选择一个版本号
![image](http://oqngxmzlf.bkt.clouddn.com/Screen%20Shot%202017-07-09%20at%2015.23.00.png)

**jenkins 完**
MARKDOWN
,
        ];
        $postJenkins = \App\Models\Post::create($postJenkins);

        $postOR = [
            'tag_id' => 2,
            'user_id' => 1,
            'title' => 'Openresty 框架',
            'thumbnail' => 'http://oqngxmzlf.bkt.clouddn.com/openresty-nginx-parallels-8-638.jpg',
            'content' => <<<MARKDOWN
## 这是一个非常易用简单的 web api 框架，采取了一些较好的 php 框架的设计

#### 主要目录结构分为 lib（公共方法），model（数据库相关），controller（由 nginx location 指向的 lua文件也就是控制器）

以下是一些基本用法：
```
local cjson = require('cjson')
local conf = require('config.app')
local Model = require('models.model')
local request = require('lib.request')
local validator = require('lib.validator')

--use request to get all http args
ngx.say(cjson.encode(request))
--curl "localhost:8001?id=1" -d name=foo     
--{"name":"foo","id":"1"}

local ok,msg = validator:check({
    name = {require=1,max=6,min=4},
    id = {require=0}},
    request)

if not ok then
    ngx.say(msg)
end

local User = Model:new('users')
ngx.say('where demo:\n',cjson.encode(User:where('username','=','cgreen'):where('password','=','7c4a8d09ca3762af61e59520943dc26494f8941b'):get()))
-- {"password":"7c4a8d09ca3762af61e59520943dc26494f8941b","gender":"?","id":99,"username":"cgreen","email":"jratke@yahoo.com"}

ngx.say('orwhere demo:\n',cjson.encode(User:where('id','=','1'):orwhere('id','=','2'):get()))
-- {"password":"7c4a8d09ca3762af61e59520943dc26494f8941b","gender":"?","id":1,"username":"hejunwei","email":"hejunweimake@gmail.com"},
-- {"password":"7c4a8d09ca3762af61e59520943dc26494f8941b","gender":"?","id":2,"username":"ward.antonina","email":"hegmann.bettie@wolff.biz"}

local Admin = Model:new('admins')
local admin = Admin:find(1)
ngx.say('find demo:\n',cjson.encode(admin))
-- {"password":"d033e22ae348aeb5660fc2140aec35850c4da997","id":1,"email":"hejunwei@gmail.com","name":"admin"}
--Admin:update({name='update demo'}):where('id','=','3'):query()
Admin:update({
        name='update test',
        password="111111"
    }):where('id','=',3):query()

Admin:insert({
    id=3,
    password='123456',
    name='horanaaa',
    email='horangeeker@geeker.com',
})
```

## github:[nana framework](https://github.com/horan-geeker/nana)
MARKDOWN
        ];
        $postOR = \App\Models\Post::create($postOR);
//        KafkaService::produce([
//            json_encode([
//            'type' => 'elasticsearch',
//            'data' => $postJenkins->load('tag')->toArray()
//            ]),
//            json_encode([
//            'type' => 'elasticsearch',
//            'data' => $postOR->load('tag')->toArray()
//            ]),
//        ]);
    }
}
