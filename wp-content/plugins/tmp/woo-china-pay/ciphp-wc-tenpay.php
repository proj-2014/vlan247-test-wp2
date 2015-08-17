<?php
	/**
	 * Gateway class
	 */
	class WC_Tenpay extends WC_Payment_Gateway
	{
		public function __construct()
		{
			global $woocommerce;

			$this->id= 'tenpay';
			$this->icon= apply_filters('woocommerce_alipay_icon',CI_WC_ALI_PATH.'/images/tenpay.jpg');
			$this->has_fields= false;
			$this->method_title='Tenpay';

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user set variables
			$this->title= $this->settings['title'];
			$this->description= $this->settings['description'];
			$this->tenpayUid= $this->settings['tenpayUid'];
			$this->tenpayKey= $this->settings['tenpayKey'];

			// Actions
			add_action('woocommerce_update_options_payment_gateways_'.$this->id,array(&$this, 'process_admin_options'));
		}

		/**
		 * Admin Panel Options
		 * - Options for bits like 'title' and availability on a country-by-country basis
		 *
		 * @since 1.0.0
		 */
		public function admin_options()
		{

?>
<h3>财付通</h3>
<p>即时到账接口</p>
<table class="form-table">
<?php
			$this->generate_settings_html();
?>
</table><!--/.form-table-->
<?php
		} // End admin_options()

		/**
		 * Initialise Gateway Settings Form Fields
		 */
		function init_form_fields()
		{

			$this->form_fields= array('enabled' =>array('title' =>'是否启用', 'type' => 'checkbox', 'label' =>'是否启用财付通', 'default' => 'yes'), 
					'title' => array('title' =>'财付通即时到账', 'type' => 'text', 'description' =>'前台用户看见的名称', 'default' =>'财付通'), 
					'description' => array('title' =>'描述', 'type' => 'textarea', 'description' =>'财付通的描述', 'default' => '财付通即时到账'), 
					'tenpayUid' => array('title' =>'商户号', 'type' => 'text', 'description' => '财付通商户号', 'default' => ''),
					'tenpayKey' => array('title' =>'密钥', 'type' => 'text', 'description' => '财付通密钥', 'default' => ''),
					);

		} // End init_form_fields()

		/**
		 * There are no payment fields for paypal, but we want to show the description if set.
		 **/
		function payment_fields()
		{
			if($this->description)
				echo wpautop(wptexturize($this->description));
		}

		/**
		 * Process the payment and return the result
		 **/
		function process_payment($order_id)
		{
			global $woocommerce;
			require_once ("classes/RequestHandler.class.php");
			$order = new WC_Order( $order_id );
			if (sizeof($order->get_items())>0) : foreach ($order->get_items() as $item) :
			if ($item['qty']) $item_names[] = $item['name'] . ' x ' . $item['qty'];
			endforeach; endif;
			//////////////////////////////
			/* 商户号 */
			$partner = $this->tenpayUid;
			
			/* 密钥 */
			$key = $this->tenpayKey;
			
			//订单号，此处用时间加随机数生成，商户根据自己情况调整，只要保持全局唯一就行
			$out_trade_no =  'CIP'.$order_id;
			
			/* 创建支付请求对象 */
			$reqHandler = new RequestHandler();
			$reqHandler->init();
			$reqHandler->setKey($key);
			$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");
			
			//----------------------------------------
			//设置支付参数
			//----------------------------------------
			$reqHandler->setParameter("partner", $partner);
			$reqHandler->setParameter("out_trade_no", $out_trade_no);
			$reqHandler->setParameter("total_fee", ($order->get_order_total()-$order->get_total_discount())*100);  //总金额
			$reqHandler->setParameter("return_url", CI_WC_ALI_PATH."/payReturnUrl.php");
			$reqHandler->setParameter("notify_url", CI_WC_ALI_PATH."/payNotifyUrl.php");
			$reqHandler->setParameter("body", implode(',',$item_names));
			$reqHandler->setParameter("bank_type", "DEFAULT");  	  //银行类型，默认为财付通
			//用户ip
			$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
			$reqHandler->setParameter("fee_type", "1");               //币种
			$reqHandler->setParameter("subject",'');          //商品名称，（中介交易时必填）
			
			//系统可选参数
			$reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
			$reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
			$reqHandler->setParameter("input_charset", "UTF-8");   	  //字符集
			$reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号
			
			//业务可选参数
			$reqHandler->setParameter("attach", "");             	  //附件数据，原样返回就可以了
			$reqHandler->setParameter("product_fee", "");        	  //商品费用
			$reqHandler->setParameter("transport_fee", "0");      	  //物流费用
			$reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
			$reqHandler->setParameter("time_expire", "");             //订单失效时间
			$reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
			$reqHandler->setParameter("goods_tag", "");               //商品标记
			$reqHandler->setParameter("trade_mode","1");              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
			$reqHandler->setParameter("transport_desc","");              //物流说明
			$reqHandler->setParameter("trans_type","1");              //交易类型
			$reqHandler->setParameter("agentid","");                  //平台ID
			$reqHandler->setParameter("agent_type","");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
			$reqHandler->setParameter("seller_id","");                //卖家的商户号
			
			$reqUrl = $reqHandler->getRequestURL();
			$html_text='
	<script>window.location.href="'.$reqUrl.'"</script>';
			//param end
			$output = "
			<html>
		    <head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		        <title>正在前往财付通...</title>
		    </head>
		    <body>$html_text</body></html>"; 
		    echo $output;
			exit();
			return array('result' => 'success', 'redirect' => $output);

		}

		// Go wild in here
	}
