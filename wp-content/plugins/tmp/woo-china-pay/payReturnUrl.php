<?php
require_once('../../../wp-config.php');
get_header();
?>
<div id="">
			<div id="content">
<article id="alipayPage">
<header class="entry-header">
		<h1 class="entry-title">支付结果</h1>
	</header><!-- .entry-header -->
<div class="entry-content" id="content">
<?php

//---------------------------------------------------------
//财付通即时到帐支付页面回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once ("./classes/ResponseHandler.class.php");
require_once ("./classes/function.php");

//log_result("进入前台回调页面");

$plugId='woocommerce_tenpay_settings';
$info=get_option($plugId);

/* 密钥 */
$key = $info['tenpayKey]'];


/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//通知id
	$notify_id = $resHandler->getParameter("notify_id");
	//商户订单号
	$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
	$discount = $resHandler->getParameter("discount");
	//支付结果
	$trade_state = $resHandler->getParameter("trade_state");
	//交易模式,1即时到账
	$trade_mode = $resHandler->getParameter("trade_mode");
	
	
	if("1" == $trade_mode ) {
		if( "0" == $trade_state){ 
			//------------------------------
			//处理业务开始
			//------------------------------
			
			//注意交易单不要重复处理
			//注意判断返回金额
			$orderId=str_replace('CIP','', $out_trade_no);
			global $woocommerce;
			$order = new WC_Order($orderId);
			$order->payment_complete();
			$woocommerce->cart->empty_cart();
			unset($_SESSION['order_awaiting_payment']);
			//------------------------------
			//处理业务完毕
			//------------------------------	
			
			echo "<div>即时到帐支付成功</div>";
	
		} else {
			//当做不成功处理
			echo "<div>即时到帐支付失败</div>";
		}
	}elseif( "2" == $trade_mode  ) {
		if( "0" == $trade_state) {
		
			//------------------------------
			//处理业务开始
			//------------------------------
			
			//注意交易单不要重复处理
			//注意判断返回金额
			
			//------------------------------
			//处理业务完毕
			//------------------------------	
			
			echo "<br/>" . "中介担保支付成功" . "<br/>";
		
		} else {
			//当做不成功处理
			echo "<br/>" . "中介担保支付失败" . "<br/>";
		}
	}
	
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
}
//获取debug信息,建议把debug信息写入日志，方便定位问题
//echo $resHandler->getDebugInfo() . "<br>";
?>
<br/>
<a href="<?php echo get_bloginfo('url'); ?>/my-account">订单中心</a>
<br/><br/><br/>
</div>
</div></div>
<?php get_footer()?>