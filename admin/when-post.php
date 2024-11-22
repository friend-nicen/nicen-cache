<?php


/**
 * @param $dir
 * 级联删除非空目录
 *
 * @return bool|void
 */
function nicen_remove_all( $dir ) {
	/* 判断目录是否存在 */
	if ( ! file_exists( $dir ) ) {
		return false;
	}
	/* 如果是文件 */
	if ( is_file( $dir ) ) {
		unlink( $dir );
	} else {
		/* 打开目录 */
		if ( $handle = opendir( $dir ) ) {
			/*遍历目录内的文件和目录*/
			while ( false !== ( $item = readdir( $handle ) ) ) {
				/*排除当前目录和上级目录链接*/
				if ( $item != "." && $item != ".." ) {
					/* 如果是目录，递归删除目录 */
					if ( is_dir( $dir . '/' . $item ) ) {
						if ( ! nicen_remove_all( $dir . '/' . $item ) ) {
							return false;
						}
					} else {
						/*文件直接删除*/
						if ( is_writable( $dir . '/' . $item ) ) {
							unlink( $dir . '/' . $item );
						} else {
							return false;
						}
					}
				}
			}
			/* 释放资源句柄 */
			closedir( $handle );
			/* 目录内部被清空，删除当前目录 */
			if ( is_writable( $dir ) ) {
				rmdir( $dir );

				return true;
			} else {
				return false;
			}
		}
	}
}


/**
 * 保存文章时触发的钩子
 *
 * @param $post_id integer 文章ID
 * @param bool $flag 是否需要记录日志
 *
 * */
function nicen_cache_when_save_post( $post_id ) {

	$post = get_post( $post_id );

	/* 评论时触发 */
	if ( ! isset( $_POST['action'] ) || ( isset( $_POST['action'] ) && $_POST['action'] !== 'editpost' ) ) {
		return $post_id;
	}

	if ( ! isset( $post ) ) {
		return $post_id;
	}


	if ( $post->post_status != 'publish' ) {
		return $post_id;
	}


	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	/* 编辑文章的权限 */
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}


	/* 所有分类和标签 */
	$terms = [
		'category' => wp_get_post_terms( $post_id, 'category' ),
		'tag'      => wp_get_post_terms( $post_id )
	];

	/* 匹配的文件 */
	$files = []; //

	/* 匹配缓存 */
	foreach ( $terms as $key => $arr ) {
		/* 清理所有分类和标签的缓存 */
		if ( count( $arr ) > 0 ) {
			/* 遍历分类 */
			foreach ( $arr as $term ) {
				$slug    = $term->slug;
				$pattern = nicen_cache_save . "/{$key}/*{$slug}*"; //匹配规则
				$files   = array_merge( $files, glob( $pattern ) ); //获取结果
			}
		}
	}

	/* 匹配分页 */
	$pattern = nicen_cache_save . "/page"; //匹配规则
	$files   = array_merge( $files, glob( $pattern ) ); //获取结果

	/* 匹配文章 */
	$pattern = nicen_cache_save . "/*{$post_id}*"; //匹配规则
	$files   = array_merge( $files, glob( $pattern ) ); //获取结果

	/* 首页 */
	$files[] = nicen_cache_save . '/_';

	foreach ( $files as $file ) {
		nicen_remove_all( $file );
	}

	return $post_id;

}


add_action( 'edit_post', 'nicen_cache_when_save_post' );


/**
 * @param $comment_id
 * @param $comment_status
 * 评论时粗发
 *
 * @return void
 */
function nicen_cache_when_comment( $comment, $comment_status = "" ) {
	$comment = is_numeric( $comment ) ? get_comment( $comment ) : $comment;
	$post_id = $comment->comment_post_ID;
	$post    = get_post( $post_id );
	$pattern = nicen_cache_save . "/*{$post->ID}*"; //匹配规则
	$files   = glob( $pattern ); //获取结果
	foreach ( $files as $file ) {
		nicen_remove_all( $file );
	}
}

add_action( 'comment_post', 'nicen_cache_when_comment' );
add_action( 'comment_unapproved_to_approved', 'nicen_cache_when_comment' );
