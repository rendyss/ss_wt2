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
		protected $pluginName;

		function __construct( $pluginName ) {
			$this->pluginName = $pluginName;
			$this->load_3rd_party();
		}

		function load_3rd_party() {
			require_once plugin_dir_path( __FILE__ ) . 'cmb2/loader.php';
		}

		function assign_metabox() {
			add_action( 'cmb2_admin_init', array( $this, 'teammember_metabox' ) );
		}

		function teammember_metabox() {
			$cmb_teammember = new_cmb2_box( array(
				'id'           => $this->pluginName . "_metabox",
				'title'        => esc_html__( 'Personal Detail' ),
				'object_types' => array( 'team-member' ), // Post type
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true, // Show field names on the left
			) );
			$cmb_teammember->add_field( array(
				'name'       => __( 'Position' ),
				'id'         => $this->pluginName . "_position",
				'type'       => 'text',
				'attributes' => array(
					'required' => 'required',
				),
			) );
			$cmb_teammember->add_field( array(
				'name'       => __( 'Email' ),
				'id'         => $this->pluginName . "_email",
				'type'       => 'text_email',
				'attributes' => array(
					'required' => 'required',
				),
			) );
			$cmb_teammember->add_field( array(
				'name'       => __( 'Website' ),
				'id'         => $this->pluginName . "_website",
				'type'       => 'text_url',
				'protocols'  => array( 'http', 'https' ),
				'attributes' => array(
					'required' => 'required'
				)
			) );
			$cmb_teammember->add_field( array(
				'name'         => __( 'Image' ),
				'id'           => $this->pluginName . "_image",
				'type'         => 'file',
				'options'      => array(
					'url' => false,
				),
				'text'         => array(
					'add_upload_file_text' => __( 'Add Image' )
				),
				'query_args'   => array(
					'type' => array( 'image/gif', 'image/jpeg', 'image/png' ),
				),
				'preview_size' => 'medium',
			) );
		}
	}
}