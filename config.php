<?php

/*
 * @author 友人a丶
 * @date 2022-08-14
 * 主题前台设置
 * 主题后台设置
 *
 * 所有表单本质都可以看做类似json的配置结构
 * */


/**
 * 已定义的表单组件
 * nicen_cache_form_input
 * nicen_cache_form_number
 * nicen_cache_form_password
 * nicen_cache_form_textarea
 * nicen_cache_form_select  @option 数组或者回调函数代表选项
 * nicen_cache_form_switch
 * nicen_cache_form_color
 * */

/*
 * 后台所有表单
 *
 * 初始化函数在admin/setting.php
 *
 * document_menu_register ,初始化菜单
 * document_config_register，表单初始化
 *
 * 初始化函数在admin/admin.php
 *
 * do_settings_sections_user ,初始化分节
 * do_settings_fields_user，初始化所有输入组件
 *
 * */


const PLUGIN_nicen_cache = [
	[
		"id"         => "nicen_cache_plugin",//主题后台设置字段
		"menu_title" => '页面静态缓存',
		'page_title' => '页面静态缓存',
		'callback'   => 'nicen_cache_setting_load',
		'capablity'  => 'manage_options',
		/*分节*/
		"sections"   => [
			[
				"id"     => "nicen_cache_param",
				'title'  => '功能设置',
				'fields' => [
					[
						'id'       => 'nicen_cache_allow',
						'title'    => '启用静态缓存',
						'callback' => 'nicen_cache_form_switch'
					]
				]
			]
		]
	]
];


/**
 * 主题所有配置
 * 键=>默认值
 * */
define( 'nicen_cache_CONFIG', [
	'nicen_cache_plugin_private' => md5( time() ), //初次安装时的接口密钥
	'nicen_cache_allow'          => 0,
] );


