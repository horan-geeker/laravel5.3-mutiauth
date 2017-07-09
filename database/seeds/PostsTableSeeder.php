<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Post::create([
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
        ]);
    }
}
