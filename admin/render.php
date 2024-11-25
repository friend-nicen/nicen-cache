<?php

/**
 * @author 友人a丶
 * @date 2022/8/27
 * 表单自定义的渲染函数
 */


/**
 * 插件升级
 */
function nicen_cache_update() {

	echo '
		<a-form-item :label-col="labelCol" label="版本信息">
		  		当前版本（1.0.0）/ 最新版本（{{version}}）
	    </a-form-item>
	    <a-form-item :label-col="labelCol" label="BUG反馈">
		  		微信号good7341、Github提交issue、博客nicen.cn下方留言均可
	    </a-form-item>
	    <a-form-item :label-col="labelCol" label="仓库地址">
		  		Github：<a target="_blank" href="https://github.com/friend-nicen/nicen-cache">https://github.com/friend-nicen/nicen-cache</a>
				<br />
				Gitee：<a target="_blank" href="https://gitee.com/friend-nicen/nicen-cache">https://gitee.com/friend-nicen/nicen-cache</a>
				<br />
				博客：<a target="_blank" href="https://nicen.cn/7759.html">https://nicen.cn/7759.html</a>
				<br />
				仓库内的版本永远是最新版本，如您觉得插件给你带来了帮助，欢迎star！祝您早日达成自己的目标！
	    </a-form-item>
	     <a-form-item :label-col="labelCol" label="礼轻情意重">
	     
	      <a-popover placement="top" trigger="hover">
		    <template slot="content">
		      <img style="max-width:300px" :src="donate[0]"/>
		    </template>
		    
		    <a-button type="link">
		      微信支持
		    </a-button>
		    
		  </a-popover>
		  <a-popover placement="top" trigger="hover"> 
		  
		    <template slot="content">
		      <img style="max-width:300px" :src="donate[1]"/>
		    </template>
		    
		    <a-button type="link">
		      支付宝支持
		    </a-button>
		    
		  </a-popover>
		  <a-popover placement="top" trigger="hover">
		  
		    <template slot="content">
		     <img style="max-width:300px" :src="donate[2]"/>
		    </template>
		    
		    <a-button type="link">
		      QQ支持
		    </a-button>
		    
		  </a-popover>
	     		
	     		
	     		
	    </a-form-item>
	';

}
