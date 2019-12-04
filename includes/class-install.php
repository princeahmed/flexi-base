<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class Install
 */
class Flexi_Base_Install {

	public static function activate() {
		self::update_option();
	}


	private static function update_option() {}

	private function create_tables() {}

}