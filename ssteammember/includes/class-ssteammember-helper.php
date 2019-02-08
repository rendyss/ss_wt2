<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/7/2019
 * Time: 9:34 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SSTeamMemberHelper' ) ) {
	class SSTeamMemberHelper {
		public $is_error;
		public $message;
		public $items;
		public $callback;
		public $other;

		function __construct() {
			$this->is_error = true;
			$this->message  = '';
			$this->items    = array();
			$this->callback = '';
			$this->other    = array();
		}
	}
}