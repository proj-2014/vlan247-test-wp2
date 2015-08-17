<?php
	if(!class_exists('WC_Payment_Gateway'))
		return;
	/**
	 * Gateway class
	 */
	class WC_Alipay_chinabank extends WC_Payment_Gateway
	{
		public function __construct()
		{
			global $woocommerce;

			$this->id= 'chinabank';
			$this->icon= apply_filters('woocommerce_alipay_icon',CI_WC_ALI_PATH.'/images/bank.gif');
			$this->has_fields= false;
			$this->method_title='chinabank';

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user set variables
			$this->title= $this->settings['title'];
			$this->description= $this->settings['description'];
			$this->bankUid= $this->settings['bankUid'];
			$this->bankKey= $this->settings['bankKey'];

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
<h3>网银在线</h3>
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

			$this->form_fields= array('enabled' =>
					array('title' =>'是否启用', 'type' => 'checkbox', 'label' =>'网银支付', 'default' => 'yes'), 
					'title' => array('title' =>'网银支付', 'type' => 'text', 'description' =>'前台用户看见的名称', 'default' =>'网银支付'), 
					'description' => array('title' =>'描述', 'type' => 'textarea', 'description' =>'描述', 'default' => '网银支付'), 
					'bankUid' => array('title' =>'商户编号', 'type' => 'text', 'description' => '商户编号', 'default' => ''),
					'bankKey' => array('title' =>'私钥值', 'type' => 'text', 'description' => '网银支付私钥', 'default' => ''),
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
			
			$order = new WC_Order( $order_id );
			if (sizeof($order->get_items())>0) : foreach ($order->get_items() as $item) :
			if ($item['qty']) $item_names[] = $item['name'] . ' x ' . $item['qty'];
			endforeach; endif;
			//
			$v_mid = $this->bankUid;								    // 商户号，这里为测试商户号1001，替换为自己的商户号(老版商户号为4位或5位,新版为8位)即可
			$v_url = CI_WC_ALI_PATH.'/chinabank/receive.php';	// 请填写返回url,地址应为绝对路径,带有http协议
			$key   = $this->bankKey;
			$v_oid='CIP'.$order_id;
			$v_amount = number_format($order->get_order_total()-$order->get_total_discount(), 2, '.', '');                   //支付金额
			$v_moneytype = "CNY";                              //币种
			
			$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;        //md5加密拼凑串,注意顺序不能变
			$v_md5info = strtoupper(md5($text));                             //md5函数加密并转化成大写字母
			
			$remark1 = '';					 //备注字段1
			$remark2 = '';                    //备注字段2
			
			$v_rcvname   = ''  ;		// 收货人
			$v_rcvaddr   = ''  ;		// 收货地址
			$v_rcvtel    = ''   ;		// 收货人电话
			$v_rcvpost   = ''  ;		// 收货人邮编
			$v_rcvemail  = '' ;		// 收货人邮件
			$v_rcvmobile = '';		// 收货人手机号
			
			$v_ordername   = ''  ;	// 订货人姓名
			$v_orderaddr   = ''  ;	// 订货人地址
			$v_ordertel    = ''   ;	// 订货人电话
			$v_orderpost   = ''  ;	// 订货人邮编
			$v_orderemail  = '' ;	// 订货人邮件
			$v_ordermobile = '';	// 订货人手机号
			$html_text='
	<form method="post" name="E_FORM" action="https://pay3.chinabank.com.cn/PayGate">
	<input type="hidden" name="v_mid"         value="'.$v_mid.'">
	<input type="hidden" name="v_oid"         value="'.$v_oid.'">
	<input type="hidden" name="v_amount"      value="'.$v_amount.'">
	<input type="hidden" name="v_moneytype"   value="'.$v_moneytype.'">
	<input type="hidden" name="v_url"         value="'.$v_url.'">
	<input type="hidden" name="v_md5info"     value="'.$v_md5info.'">
	<input type="hidden" name="remark1"       value="'.$remark1.'">
	<input type="hidden" name="remark2"       value="'.$remark2.'">
	</form>
	<script>document.E_FORM.submit();</script>';
			$output = "
			<html>
		    <head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		        <title>正在前往网银在线...</title>
		    </head>
		    <body><div  style='display:none'>$html_text</div>'</body></html>"; 
		    echo $output;
			exit();
			return array('result' => 'success', 'redirect' => $output);

		}

		// Go wild in here
	}