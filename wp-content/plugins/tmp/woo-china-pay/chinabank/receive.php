<?php
require_once('../../../../wp-config.php');
get_header();
?>
<div id="primary">
			<div id="content" role="main">
<header class="entry-header">
		<h1 class="entry-title">支付结果</h1>
	</header><!-- .entry-header -->
<div class="entry-content" id="content">
<?
$plugId='woocommerce_chinabank_settings';
$info=get_option($plugId);
//****************************************	//MD5密钥要跟订单提交页相同，如Send.asp里的 key = "test" ,修改""号内 test 为您的密钥
											//如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/
	$key=$info['bankKey'];							//登陆后在上面的导航栏里可能找到“资料管理”，在资料管理的二级导航栏里有“MD5密钥设置” 
												//建议您设置一个16位以上的密钥或更高，密钥最多64位，但设置16位已经足够了
//****************************************
	
$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   
$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）   
$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）； 
$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种    
$remark1   =trim($_POST['remark1' ]);      //备注字段1
$remark2   =trim($_POST['remark2' ]);     //备注字段2
$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值  

/**
 * 重新计算md5的值
 */
                           
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

/**
 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
 */


if ($v_md5str==$md5string)
{
	if($v_pstatus=="20")
	{
		$orderId=str_replace('CIP','', $v_oid);
		global $woocommerce;
		$order = new WC_Order($orderId);
		$order->payment_complete();
		$woocommerce->cart->empty_cart();
		unset($_SESSION['order_awaiting_payment']);
		echo "<div>付款成功!</div>";
		//支付成功，可进行逻辑处理！
		//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......

	}else{
		echo "<div>付款未完成!</div>";
		echo "trade_status=".$v_pstatus;
	}

}else{
	echo "<div>错误的请求！如果您已经完成付款，请联系管理员!</div>";
}
?>
<br/>
<a href="<?php echo get_bloginfo('url'); ?>/my-account">订单中心</a>
<br/><br/><br/>
</div>
</div></div>
<?php get_footer()?>
</html>