# 使用方法

```nginx
location / {
    # 对于POST请求不走缓存
    if ($request_method ~ ^(POST)$){
	  rewrite / /index.php?$args last;
    }	
    try_files /cache/$uri /cache${uri}_${args}/index.html  $uri $uri/  /index.php?$args;
}
```