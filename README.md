```php
/* 如果访问的不是后台 */
if ( strpos( $_SERVER['REQUEST_URI'], "wp-admin" ) === false ) {

	ob_start( function ( $html ) {

		/* 关闭了缓存 */
		if ( ! nicen_cache_config( 'nicen_cache_allow' ) ) {
			return $html;
		}

		/* 定义缓存的保存目录 */
		$cache_dir = "/cache";

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


			$dir  = __DIR__ . $cache_dir . $match . '_' . $query;
			$file = __DIR__ . $cache_dir . $match . '_' . $query . '/index.html';


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
```