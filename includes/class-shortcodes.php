<?php

class Flexi_Shortcodes{
	public function __construct() {
		add_shortcode('checkout_form', [$this, 'checkout_form']);
	}

	function checkout_form(){
		ob_start();
		include FLEXI_BASE_TEMPLATES.'/checkout-form.php';

		return ob_get_clean();
	}

}

new Flexi_Shortcodes();