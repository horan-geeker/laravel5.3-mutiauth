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

        $postVIM = [
            'tag_id' => 4,
            'user_id' => 1,
            'title' => 'vim 技巧',
            'thumbnail' => 'http://oqngxmzlf.bkt.clouddn.com/Vimlogo.svg',
            'content' => <<<MARKDOWN
# vim

## sudo 保存
`w !sudo tee %`

## 粘贴模式
`:set paste`  
进入paste模式以后，可以在插入模式下粘贴内容，不会有任何变形。

## 技巧
关闭不再使用 wq 使用 shift+ZZ
删除一个字符使用 shift+X

## 搜索
`:/word`  
这个是查找文件中“word”这个单词，是从文件上面到下面查找 
`:?word`  
这个是查找文件中“word”这个单词，是从文件下上面到面查找

## 撤销
`:u`

## 常用命令
```
1,\$s/aaa/bbb 从第1行到末尾替换aaa为bbb
1,\$s/aaa/bbb/c 加参数c有提示
:r text  读取text文本内容附加到下一行
yy 复制游标所在行 
3yy 复制游标所在行下的3行
p 粘贴
dd 删除一行 1,\$d 全部删除
w filename 另存为filename
gg 页首
G 页尾
行头1
行尾$
向上 k
向下 j
向左 h
向右 l
删除1-n行  1,nd
删除一个字元 dw
34j 跳到34行
10l 跳到10列
```

## 多文件显示
```
open file #打开一个文件
split #两个视窗同时显示
ctrl ww #视窗间切换
```
## 配置

#### 默认语法配置文件位置
`/usr/share/vim/vim70/syntax`

#### 新文件类型配置
以vue文件类型为例  
在 **`~/.vimrc`** 文件:  
`au BufNewFile,BufRead *.vue set  filetype=html`

#### 引用配置
<http://git.oschina.net/hejunwei_669/vimrc>

#### 手动配置
下面两个方法修改配置都可以,看自己需要取舍
1. 在用户目录下创建一个 `.vimrc` 的文件并将以下代码复制到里面保存
2. 如果想所有的用户都共享这个配置可以在  `/etc/vim/vimrc` 这里直接修改     //操作有风险,修改先备份
```
syn on                      " 开启高亮
set number                  " 显示行号  
set cursorline              " 突出显示当前行  
set ruler                   " 打开状态栏标尺  
set shiftwidth=4            " 设定 << 和 >> 命令移动时的宽度为 4  
set softtabstop=4           " 使得按退格键时可以一次删掉 4 个空格  
set tabstop=4               " 设定 tab 长度为 4  
set nobackup                " 覆盖文件时不备份  
set autoindent              " 自动对齐
set autochdir               " 自动切换当前目录为当前文件所在的目录  
filetype plugin indent on   " 开启插件  
set backupcopy=yes          " 设置备份时的行为为覆盖  
set ignorecase smartcase    " 搜索时忽略大小写，但在有一个或以上大写字母时仍保持对大小写敏感  
set nowrapscan              " 禁止在搜索到文件两端时重新搜索  
set incsearch               " 输入搜索内容时就显示搜索结果  
set hlsearch                " 搜索时高亮显示被找到的文本  
set noerrorbells            " 关闭错误信息响铃  
set novisualbell            " 关闭使用可视响铃代替呼叫  
set t_vb=                   " 置空错误铃声的终端代码  
set showmatch               " 插入括号时，短暂地跳转到匹配的对应括号  
" set matchtime=2             " 短暂跳转到匹配括号的时间   
set hidden                  " 允许在有未保存的修改时切换缓冲区，此时的修改由 vim 负责保存   
set smartindent             " 开启新行时使用智能自动缩进  
set backspace=indent,eol,start  
                            " 不设定在插入状态无法用退格键和 Delete 键删除回车符  
set cmdheight=5             " 设定命令行的行数为 1  
set laststatus=2            " 显示状态栏 (默认值为 1, 无法显示状态栏)  
set statusline=\ %<%F[%1*%M%*%n%R%H]%=\ %y\ %0(%{&fileformat}\ %{&encoding}\ %c:%l/%L%)\   
                            " 设置在状态行显示的信息  
set foldenable              " 开始折叠  
set foldmethod=syntax       " 设置语法折叠  
set foldcolumn=0            " 设置折叠区域的宽度  
setlocal foldlevel=1        " 设置折叠层数为  

" Python 文件的一般设置，比如不要 tab 等  
autocmd FileType python set tabstop=4 shiftwidth=4 expandtab  
autocmd FileType python map <F12> :!python %<CR>  

" 打开javascript折叠  
let b:javascript_fold=1  
" 打开javascript对dom、html和css的支持  
let javascript_enable_domhtmlcss=1  
" 设置字典 ~/.vim/dict/文件的路径  
autocmd filetype javascript set dictionary=\$VIMFILES/dict/javascript.dict  
autocmd filetype css set dictionary=\$VIMFILES/dict/css.dict  
autocmd filetype php set dictionary=\$VIMFILES/dict/php.dict
```
MARKDOWN

        ];

        $postVIM = \App\Models\Post::create($postVIM);

        KafkaService::produce([
            json_encode([
                'type' => 'elasticsearch',
                'data' => $postJenkins->load('tag')->toArray()
            ]),
            json_encode([
                'type' => 'elasticsearch',
                'data' => $postOR->load('tag')->toArray()
            ]),
            json_encode([
                'type' => 'elasticsearch',
                'data' => $postVIM->load('tag')->toArray()
            ]),
        ]);
    }
}
