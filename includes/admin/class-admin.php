<?php

defined( 'ABSPATH' ) || exit();

class FLEXI_BASE_ADMIN {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu' ], 21 );
		//add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}

	public function add_menu() {

		$this->menu_slug = add_menu_page(
			__( 'Flexi Base Dashboard', '' ),
			__( 'Flexi Base', '' ),
			'manage_options',
			'flexi-base',
			[ $this, 'render_dashboard' ],
			'',
			59
		);

	}


}

new FLEXI_BASE_ADMIN();