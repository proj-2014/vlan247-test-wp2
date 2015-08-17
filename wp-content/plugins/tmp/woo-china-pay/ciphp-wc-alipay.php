<?php
/**
 * Plugin Name: woocommerce 国内支付插件
 * Plugin URI: http://jspok.com/woocommerce-china-pay/
 * Description: 基于 2.0.5 版开发 支持支付宝即时到帐，担保交易，双功能接口，网银在线，财付通即时到帐
 * Version: 2.2
 * Author: logiz
 * Author URI: http://jspok.com/woocommerce-china-pay/
 **/

define("CI_WC_ALI_PATH",plugins_url( '', __FILE__ ));
define("CI_WC_PATH",plugin_dir_path(__FILE__));

add_action('plugins_loaded','woocommerce_gateway_alipay_init',0);

function woocommerce_gateway_alipay_init()
{

	if(!class_exists('WC_Payment_Gateway'))
		return;
	require_once CI_WC_PATH.'./ciphp-wc-alipay-db.php';
	require_once CI_WC_PATH.'./ciphp-wc-tenpay.php';
	require_once CI_WC_PATH.'./ciphp-wc-alipay-two.php';
	require_once CI_WC_PATH.'./ciphp-wc-chinabank.php';
	/**
	 * Localisation
	 */
	load_plugin_textdomain('wc-gateway-name',false,dirname(plugin_basename(__FILE__)).'/languages');

	/**
	 * Gateway class
	 */
	class WC_Alipay extends WC_Payment_Gateway
	{
		public function __construct()
		{
			global $woocommerce;

			$this->id= 'alipay';
			$this->icon= apply_filters('woocommerce_alipay_icon',CI_WC_ALI_PATH.'/images/alipay.png');
			$this->has_fields= false;
			$this->method_title='Alipay';

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user set variables
			$this->title= $this->settings['title'];
			$this->description= $this->settings['description'];
			$this->email= $this->settings['email'];
			$this->alipayUid= $this->settings['alipayUid'];
			$this->alipayKey= $this->settings['alipayKey'];

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

			$this->form_fields= array('enabled' =>array('title' =>'是否启用', 'type' => 'checkbox', 'label' =>'是否启用支付宝', 'default' => 'yes'), 
					'title' => array('title' =>'支付宝即时到账', 'type' => 'text', 'description' =>'前台用户看见的名称', 'default' =>'支付宝'), 
					'description' => array('title' =>'描述', 'type' => 'textarea', 'description' =>'支付方式的描述', 'default' => '支付宝即时到账'), 
					'email' => array('title' =>'卖家支付宝帐号', 'type' => 'text', 'description' => '卖家支付宝帐号', 'default' => ''), 
					'alipayUid' => array('title' =>'支付宝合作ID', 'type' => 'text', 'description' => '支付宝合作ID', 'default' => ''),
					'alipayKey' => array('title' =>'支付宝合作key', 'type' => 'text', 'description' => '支付宝合作key', 'default' => ''),
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
			require_once("alipay_config.php");
			require_once("class/alipay_service.php");
			$order = new WC_Order( $order_id );
			if (sizeof($order->get_items())>0) : foreach ($order->get_items() as $item) :
			if ($item['qty']) $item_names[] = $item['name'] . ' x ' . $item['qty'];
			endforeach; endif;
			//扩展功能参数——默认支付方式
			$paymethod    = "directPay";	//默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
			$defaultbank  = "";
			
			//扩展功能参数——防钓鱼
			//请慎重选择是否开启防钓鱼功能
			//exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
			//开启防钓鱼功能后，服务器、本机电脑必须支持远程XML解析，请配置好该环境。
			//若要使用防钓鱼功能，请打开class文件夹中alipay_function.php文件，找到该文件最下方的query_timestamp函数，根据注释对该函数进行修改
			//建议使用POST方式请求数据
			$anti_phishing_key  = '';			//防钓鱼时间戳
			$exter_invoke_ip = '';				//获取客户端的IP地址，建议：编写获取客户端IP地址的程序
			//如：
			//$exter_invoke_ip = '202.1.1.1';
			//$anti_phishing_key = query_timestamp($partner);		//获取防钓鱼时间戳函数
			
			//扩展功能参数——其他
			$extra_common_param = '';			//自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上
			$buyer_email		= '';			//默认买家支付宝账号
			
			//扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
			$royalty_type		= "";			//提成类型，该值为固定值：10，不需要修改
			$royalty_parameters	= "";
			//提成信息集，与需要结合商户网站自身情况动态获取每笔交易的各分润收款账号、各分润金额、各分润说明。最多只能设置10条
			//各分润金额的总和须小于等于total_fee
			//提成信息集格式为：收款方Email_1^金额1^备注1|收款方Email_2^金额2^备注2
			//如：
			//royalty_type = "10"
			//royalty_parameters	= "111@126.com^0.01^分润备注一|222@126.com^0.01^分润备注二"
			
			/////////////////////////////////////////////////
			
			//构造要请求的参数数组，无需改动
			$parameter = array(
					"service"			=> "create_direct_pay_by_user",	//接口名称，不需要修改
					"payment_type"		=> "1",               			//交易类型，不需要修改
			
					//获取配置文件(alipay_config.php)中的值
					"partner"			=> $partner,
					"seller_email"		=> $seller_email,
					"return_url"		=> $return_url,
					"notify_url"		=> $notify_url,
					"_input_charset"	=> $_input_charset,
					"show_url"			=> get_bloginfo('wpurl'),
			
					//从订单数据中动态获取到的必填参数
					"out_trade_no"		=> 'CIP'.$order_id,
					"subject"			=> implode(',',$item_names),
					"body"				=> implode(',',$item_names),
					"total_fee"			=> number_format($order->get_order_total()-$order->get_total_discount(), 2, '.', ''),
			
					//扩展功能参数——网银提前
					"paymethod"			=> $paymethod,
					"defaultbank"		=> $defaultbank,
			
					//扩展功能参数——防钓鱼
					"anti_phishing_key"	=> $anti_phishing_key,
					"exter_invoke_ip"	=> $exter_invoke_ip,
			
					//扩展功能参数——自定义参数
					"buyer_email"		=> $buyer_email,
					"extra_common_param"=> $extra_common_param,
			
					//扩展功能参数——分润
					"royalty_type"		=> $royalty_type,
					"royalty_parameters"=> $royalty_parameters
			);
			//构造请求函数
			$alipay = new alipay_service($parameter,$key,$sign_type);
			$sHtmlText = $alipay->build_form();
			$html="<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
				<title>正在前往支付宝...</title>
			</head>
			<body><div  style='display:none'>$sHtmlText</div";
			echo $html;exit;
			return array('result' => 'success', 'redirect' => $sHtmlText);

		}

		// Go wild in here
	}

	/**
	 * Add the Gateway to WooCommerce
	 **/
	function woocommerce_add_gateway_ciphp_gateway($methods)
	{
		$methods[]= 'WC_Alipay';
		$methods[]= 'WC_Alipay_db';
		$methods[]= 'WC_Tenpay';
		$methods[]= 'WC_Alipay_two';
		$methods[]= 'WC_Alipay_chinabank';
		return $methods;
	}

	add_filter('woocommerce_payment_gateways','woocommerce_add_gateway_ciphp_gateway');
}

