<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/7/2019
 * Time: 3:52 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SSTeamMember' ) ) {
	class SSTeamMember {
		protected $pluginName;
		protected $pluginVersion;

		function __construct() {
			$this->pluginName    = "ssteammember";
			$this->pluginVersion = "1.0.0";
			$this->register_custom_post_type();
			$this->load_front_end_assets();
		}

		function register_custom_post_type() {
			add_action( 'init', array( $this, 'custom_post_type' ) );
		}

		function load_front_end_assets() {
			wp_enqueue_script( $this->pluginName . ".js", plugin_dir_url( __FILE__ ) . 'assets/js/ssteammember.js', array( 'jquery' ), $this->pluginVersion, true );
			wp_enqueue_style( $this->pluginName . ".css", plugin_dir_url( __FILE__ ) . 'assets/ss/ssteammember.js', array(), $this->pluginVersion );
		}

		function custom_post_type() {
			//Team Member
			$labels_teamMember = array(
				'name'          => _x( 'Team Member', 'Post Type General Name' ),
				'singular_name' => _x( 'Team Member', 'Post Type Singular Name' ),
				'menu_name'     => __( 'Team Member' ),
				'all_items'     => __( 'All Team Members' ),
				'add_new_item'  => __( 'Add New Team Member' ),
				'add_new'       => __( 'Add New' ),
				'edit_item'     => __( 'Edit Team Member' ),
			);
			$args_teamMember   = array(
				'labels'              => $labels_teamMember,
				'supports'            => array(
					'title',
				),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
				'menu_icon'           => 'dashicons-groups'
			);
			register_post_type( 'team-member', $args_teamMember );
		}
	}
}