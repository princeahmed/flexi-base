<?php

function flexi_base_filter_template( $template ) {

	if ( is_page( 'checkout' ) ) {
		remove_action( 'in_admin_header', 'wp_admin_bar_render', 0 );
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );

		//wp_radio_get_template( 'player/popup' );
		include FLEXI_BASE_TEMPLATES . '/checkout-form.php';

		exit();
	}

	return $template;
}

//add_filter( 'template_include', 'flexi_base_filter_template' );
