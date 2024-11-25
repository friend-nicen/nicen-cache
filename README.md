```
/**
 * Plugin Name: Nicen-Cache
 * Plugin URI:https://nicen.cn/7759.html
 * Description: Wordpress静态缓存管理
 * Version: 1.0.0
 * Author: 友人a丶
 * Author URI: https://nicen.cn
 * Text Domain: Nicen-Cache
 * License: GPLv2 or later
 */
```

# 插件介绍

nicen-cache，是一款超快的基于nginx的Wordpress缓存加速插件！

> 缓存生效之后文章再多都不怕卡啦

之前写过一篇关于Wordpress缓存的文章（插件原理）：[https://nicen.cn/3107.html](https://nicen.cn/3107.html)

通过手动配置后，就可以实现自动缓存站点页面，但是存在一些缺点：

* 没有对应的缓存刷新机制，更新缓存只能靠手动删除
* 有一定的使用门槛，不适合小白
* ...

为了解决上面的问题，便开发了一款对应的缓存管理插件：

* 通过插件功能开关来开启/禁用缓存
* 文章发布、更新时，自动更新相关联的所有缓存
* 文章有新的评论时，自动更新相关联的所有缓存
* 如果是已登录的用户访问页面，不缓存。
* ...

-----> 插件演示站：<https://nicen.cn/7759.html>

# 仓库地址

Github：<https://github.com/friend-nicen/nicen-cache>

Gitee：<https://gitee.com/friend-nicen/nicen-cache>

# 插件推荐

## Wordpress用户行为回放插件

Github：<https://github.com/friend-nicen/nicen-replay>

Gitee：<https://gitee.com/friend-nicen/nicen-replay>

## Wordpress远程图片本地化插件

Github：<https://github.com/friend-nicen/nicen-localize-image>

Gitee：<https://gitee.com/friend-nicen/nicen-localize-image>

## 插件使用

### 1. 安装

下载上传插件后直接启用插件，启用后访问插件的管理页面，打开插件的缓存功能。

> 启用插件后，插件会将缓存文件保存在站点的根目录下的cache目录，如果插件自动创建目录失败，请手动创建，并给可写权限！

> 注意：插件与其他有缓存功能的插件不兼容，同时启用多个缓存插件将导出缓存异常！

为了确保缓存生效，需要调整一下wordpress的伪静态：

```nginx
# 原来的
location /
{
    try_files $uri $uri/ /index.php?$args;
}

# 调整为
location / {
    # 对于POST请求不走缓存
    if ($request_method ~ ^(POST)$){
	  rewrite / /index.php?$args last;
    }	
    try_files /cache/$uri /cache${uri}_${args}/index.html  $uri $uri/  /index.php?$args;
}
```

### 2. 关于缓存

当文章等页面被访问时才会产生缓存，所以第一次会是正常的访问速度（会自动缓存被访问的页面），产生缓存之后才会有加速效果！

### 3. 适用范围

页面被缓存之后，所有访客访问的都是这个缓存页面，所以插件只适用于静态内容为主的站点（比如我的博客）。

> 仓库内的版本永远是最新版本，如您觉得插件给你带来了帮助，欢迎star！祝您早日达成自己的目标！
