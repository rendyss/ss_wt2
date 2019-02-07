<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/7/2019
 * Time: 4:42 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SSTeamMemberMetabox' ) ) {
	class SSTeamMemberMetaBox {
		static function load_3rd_party() {
			require_once plugin_dir_path( __FILE__ ) . 'cmb2/loader.php';
		}
	}
}