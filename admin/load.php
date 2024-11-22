<?php


/*
 * 后台主题设置页面，外部文件加载
 * */
function nicen_cache_admin_load_source() {

	wp_enqueue_script( 'vuejs', nicen_cache_url . 'assets/vue.min.js', [ 'jquery' ] );

	wp_enqueue_script( 'moments', 'https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/moment.js/2.29.1/moment.min.js' );

	wp_enqueue_script( 'antd', nicen_cache_url . 'assets/antd.min.js', [ 'jquery', 'vuejs' ] );

	wp_enqueue_style( 'antdcss', 'https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/ant-design-vue/1.7.8/antd.min.css' );

	wp_enqueue_style( 'admincss', nicen_cache_url . 'assets/admin.css', array(), filemtime( nicen_cache_path . 'assets/admin.css' ) );
	wp_enqueue_script( 'adminjs', nicen_cache_url . 'assets/admin.js', array(), filemtime( nicen_cache_path . 'assets/admin.js' ) );
	wp_enqueue_script( 'loadjs', nicen_cache_url . 'assets/load.js', array(), filemtime( nicen_cache_path . 'assets/load.js' ) );

	wp_enqueue_script( 'axios', 'https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/axios/0.26.0/axios.min.js' );
	wp_enqueue_media(); //加载媒体选择器
	/*
	 * 内联的js代码
	 * */
	wp_add_inline_script( "adminjs", vsprintf( "const PLUGIN_CONFIG=%s;", [
		json_encode( nicen_cache_config() )
	] ), 'before' );


}


/*
 * 后台加载样式和脚本
 * */
if ( strpos( $_SERVER['QUERY_STRING'] ?? "", 'nicen_cache_plugin' ) !== false ) {
	add_action( 'admin_enqueue_scripts', 'nicen_cache_admin_load_source' ); //加载前台资源文件
}


