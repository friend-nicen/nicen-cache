<?php

/*
 * 公共数据和方法
 * */

global $nicen_cache_CONFIGS; //声明全局变量

$nicen_cache_CONFIGS = []; //保存所有插件配置


/*
 * 遍历整个配置
 * */
foreach ( nicen_cache_CONFIG as $key => $value ) {
	$nicen_cache_CONFIGS[ $key ] = get_option( $key );
}

/*
 * 返回指定配置
 * */
function nicen_cache_config( $key = '' ) {
	global $nicen_cache_CONFIGS;
	if ( empty( $key ) ) {
		return $nicen_cache_CONFIGS;
	} else {
		return $nicen_cache_CONFIGS[ $key ];
	}
}


