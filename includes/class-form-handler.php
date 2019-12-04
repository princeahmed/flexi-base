<?php

class Flexi_Base_Form_Handler{
	public function __construct() {
		add_action('admin_post_checkout', [$this, 'checkout']);
		add_action('admin_post_nopriv_checkout', [$this, 'checkout']);
	}

	public function checkout(){

		// Check whether token is not empty
		if(!empty($_REQUEST['token'])){

			// Token info
			$token  = $_REQUEST['token'];

			// Card info
			$card_num = $_REQUEST['card_num'];
			$card_cvv = $_REQUEST['cvv'];
			$card_exp_month = $_REQUEST['exp_month'];
			$card_exp_year = $_REQUEST['exp_year'];

			// Buyer info
			$name = $_REQUEST['name'];
			$email = $_REQUEST['email'];
			$zipCode = '43123';

			// Item info
			$itemPrice = '25.00';
			$currency = 'USD';
			$orderID = 'SKA92712382139';


			// Include 2Checkout PHP library
			include FLEXI_BASE_LIBS.'/Twocheckout.php';

			// Set API key
			Twocheckout::privateKey('FD878C27-A272-4AF3-8C1C-63DAEA11A46C');
			Twocheckout::sellerId('901416663');
			Twocheckout::verifySSL(false);
			Twocheckout::sandbox(true);

			try {
				// Charge a credit card
				$charge = Twocheckout_Charge::auth(array(
					"merchantOrderId" => $orderID,
					"token"      => $token,
					"currency"   => $currency,
					"total"      => $itemPrice,
					"billingAddr" => array(
						"name" => $name,
						"zipCode" => $zipCode,
						"email" => $email,
					)
				));


				// Check whether the charge is successful
				if ($charge['response']['responseCode'] == 'APPROVED') {

				}
			} catch (Twocheckout_Error $e) {
				$statusMsg = '<h2>Transaction failed!</h2>';
				$statusMsg .= '<p>'.$e->getMessage().'</p>';
			}

		}else{
			$statusMsg = "<p>Form submission error...</p>";
		}

		echo $statusMsg;

	}

}

new Flexi_Base_Form_Handler();