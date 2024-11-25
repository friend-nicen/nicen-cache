<?php
/**
 * Plugin Name: Nicen-Cache
 * Plugin URI:https://nicen.cn/7759.html
 * Description: 静态缓存管理
 * Version: 1.0.0
 * Author: 友人a丶
 * Author URI: https://nicen.cn
 * Text Domain: Nicen-Cache
 * License: GPLv2 or later
 */


define( 'nicen_cache_path', plugin_dir_path( __FILE__ ) ); //插件目录
define( 'nicen_cache_url', plugin_dir_url( __FILE__ ) ); //插件URL
define( 'nicen_cache_save', ABSPATH . "cache" ); //插件URL


include_once nicen_cache_path . '/config.php'; //加载插件配置
include_once nicen_cache_path . '/admin/install.php'; //安装时触发
include_once nicen_cache_path . '/admin/common.php'; //公共变量和方法
include_once nicen_cache_path . '/admin/when-post.php'; //初始化插件功能
/*
 * 只在后台才触发
 * */
if ( is_admin() ) {
	include_once nicen_cache_path . '/admin/load.php'; //加载后台插件资源
	include_once nicen_cache_path . '/admin/form.php'; //加载后台设置表单
	include_once nicen_cache_path . '/admin/setting.php';//渲染表单
	include_once nicen_cache_path . '/admin/initialize.php'; //初始化插件功能
} else {

	$nicen_save_cache = true;

	/* 获取用户代理字符串 */
	$userAgent     = $_SERVER['HTTP_USER_AGENT'];
	$ua_black_list = [ "spider", "Bot", "bot" ];

	/* 排除爬虫  */
	foreach ( $ua_black_list as $ua ) {
		/* 如果包含黑名单关键词 */
		if ( strpos( $userAgent, $ua ) !== false ) {
			$nicen_save_cache = false;
		}
	}

	/* 如果未登录，或者登录了不是管理员 */
	if ( $nicen_save_cache ) {
		ob_start( function ( $html ) {

			/* 关闭了缓存 */
			if ( ! nicen_cache_config( 'nicen_cache_allow' ) ) {
				return $html;
			}

			if ( is_user_logged_in() ) {
				return $html;
			}


			/* 定义缓存的保存目录 */
			$cache_dir = nicen_cache_save;

			/* 判断文章密码 */
			if ( is_single() ) {
				$post = get_post();
				if ( ! empty( $post->post_password ) ) {
					return $html;
				}
			}

			/* 判断是否是POST */
			if ( $_SERVER['REQUEST_METHOD'] !== "GET" ) {
				return $html;
			}
			/* 编码 */
			if ( strpos( $_SERVER['HTTP_ACCEPT'], "application/json" ) !== false ) {
				return $html;
			}
			/* 获取请求的路径 */
			$location = $_SERVER['REQUEST_URI']; //路径
			/* 去除参数，获取纯路径 */
			$match = preg_replace( '/(\?.*)/', "", $location );
			$query = $_SERVER['QUERY_STRING']; //查询的参数
			/*
			 * 纯目录和html文件
			 * */
			if ( ( strpos( $match, '.' ) === false ) || ( strpos( $match, '.html' ) !== false ) ) {
				/* 缓存的保存路径 */
				$dir  = $cache_dir . $match . '_' . $query;
				$file = $cache_dir . $match . '_' . $query . '/index.html';
				/* 缓存已经存在 */
				if ( ! file_exists( $file ) && ! empty( $html ) ) {
					if ( ! file_exists( $dir ) ) {
						mkdir( $dir, 0777, true );
					}
					file_put_contents( $file, $html, LOCK_EX );
				}
			}

			return $html;
		} );
	}
}
