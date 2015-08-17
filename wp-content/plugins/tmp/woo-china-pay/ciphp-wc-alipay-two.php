<?php
	if(!class_exists('WC_Payment_Gateway'))
		return;
	/**
	 * Gateway class
	 */
	class WC_Alipay_two extends WC_Payment_Gateway
	{
		public function __construct()
		{
			global $woocommerce;

			$this->id= 'alipay_shuang';
			$this->icon= apply_filters('woocommerce_alipay_icon',CI_WC_ALI_PATH.'/images/alipay.png');
			$this->has_fields= false;
			$this->method_title='alipay_shuang';

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user set variables
			$this->title= $this->settings['title'];
			$this->description= $this->settings['description'];
			$this->email= $this->settings['two_email'];
			$this->alipayUid= $this->settings['two_alipayUid'];
			$this->alipayKey= $this->settings['two_alipayKey'];

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
<h3>支付宝</h3>
<p>双功能接口</p>
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

			$this->form_fields= array('enabled' =>array('title' =>'是否启用', 'type' => 'checkbox', 'label' =>'是否启用支付宝双功能接口', 'default' => 'yes'), 
					'title' => array('title' =>'支付宝双功能接口', 'type' => 'text', 'description' =>'前台用户看见的名称', 'default' =>'支付宝'), 
					'description' => array('title' =>'描述', 'type' => 'textarea', 'description' =>'支付方式的描述', 'default' => '支付宝付款'), 
					'two_email' => array('title' =>'卖家支付宝帐号', 'type' => 'text', 'description' => '卖家支付宝帐号', 'default' => ''), 
					'two_alipayUid' => array('title' =>'支付宝合作ID', 'type' => 'text', 'description' => '支付宝合作ID', 'default' => ''),
					'two_alipayKey' => array('title' =>'支付宝合作key', 'type' => 'text', 'description' => '支付宝合作key', 'default' => ''),
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
			require_once(CI_WC_PATH."/lib/alipay.config.php");
			require_once(CI_WC_PATH."/lib/alipay_service.class.php");
			$order = new WC_Order( $order_id );
			if (sizeof($order->get_items())>0) : foreach ($order->get_items() as $item) :
			if ($item['qty']) $item_names[] = $item['name'] . ' x ' . $item['qty'];
			endforeach; endif;
			//////////////////////////////////////
			/**************************请求参数**************************/
			
			//必填参数//
			
			$out_trade_no		= 'CIP'.$order_id;	//请与贵网站订单系统中的唯一订单号匹配
			$subject			= implode(',',$item_names);	//订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
			$body				= implode(',',$item_names);	//订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
			$price				= number_format($order->get_order_total()-$order->get_total_discount(), 2, '.', '');	//订单总金额，显示在支付宝收银台里的“应付总额”里
			$logistics_fee		= "0.00";				//物流费用，即运费。
			$logistics_type		= "EXPRESS";			//物流类型，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
			$logistics_payment	= "SELLER_PAY";			//物流支付方式，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
			$quantity			= "1";					//商品数量，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品。
			
			$receive_name		= "";			//收货人姓名，如：张三
			$receive_address	= "";			//收货人地址，如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
			$receive_zip		= "";				//收货人邮编，如：123456
			$receive_phone		= "";		//收货人电话号码，如：0571-81234567
			$receive_mobile		= "";		//收货人手机号码，如：13312341234
			//网站商品的展示地址，不允许加?id=123这类自定义参数
			$show_url			= get_bloginfo('url');
			
			/************************************************************/
			
			//构造要请求的参数数组
			$parameter = array(
					"service"		=> "trade_create_by_buyer",
					"payment_type"	=> "1",
			
					"partner"		=> trim($aliapy_config['partner']),
					"_input_charset"=> trim(strtolower($aliapy_config['input_charset'])),
					"seller_email"	=> trim($aliapy_config['seller_email']),
					"return_url"	=> trim($aliapy_config['return_url']),
					"notify_url"	=> trim($aliapy_config['notify_url']),
			
					"out_trade_no"	=> $out_trade_no,
					"subject"		=> $subject,
					"body"			=> $body,
					"price"			=> $price,
					"quantity"		=> $quantity,
			
					"logistics_fee"		=> $logistics_fee,
					"logistics_type"	=> $logistics_type,
					"logistics_payment"	=> $logistics_payment,
			
					"receive_name"		=> $receive_name,
					"receive_address"	=> $receive_address,
					"receive_zip"		=> $receive_zip,
					"receive_phone"		=> $receive_phone,
					"receive_mobile"	=> $receive_mobile,
			
					"show_url"		=> $show_url
			);
			
			//构造标准双接口
			$alipayService = new AlipayService($aliapy_config);
			$html_text = $alipayService->trade_create_by_buyer($parameter);
			//param end
			$output = "
			<html>
		    <head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		        <title>正在前往支付宝...</title>
		    </head>
		    <body><div  style='display:none'>$html_text</div>'</body></html>"; 
		    echo $output;
			exit();
			return array('result' => 'success', 'redirect' => $output);

		}

		// Go wild in here
	}