<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/7/2019
 * Time: 8:32 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SSTeamMemberShortCode' ) ) {
	class SSTeamMemberShortCode {
		protected $pluginName;

		function __construct( $pluginName ) {
			$this->pluginName = $pluginName;
			$this->register();
		}

		function register() {
			add_shortcode( 'ss_teammember', array( $this, 'generate_shortcode' ) );
		}

		function generate_shortcode( $atts ) {
			$result = '';
			$args   = shortcode_atts( array(
				'id'       => false,
				'limit'    => 3,
				'name'     => true,
				'position' => true,
				'email'    => true,
				'website'  => true,
				'image'    => true,
			), $atts );

			//Just to make sure, it's a boolean :)
			$args['name']     = filter_var( $args['name'], FILTER_VALIDATE_BOOLEAN );
			$args['position'] = filter_var( $args['position'], FILTER_VALIDATE_BOOLEAN );
			$args['email']    = filter_var( $args['email'], FILTER_VALIDATE_BOOLEAN );
			$args['website']  = filter_var( $args['website'], FILTER_VALIDATE_BOOLEAN );
			$args['image']    = filter_var( $args['image'], FILTER_VALIDATE_BOOLEAN );

			$ssIO       = new SSTeamMemberIO( $this->pluginName );
			$ssTemplate = new SSTeamMemberTemplate( plugin_dir_path( dirname( __FILE__ ) ) . 'templates' );

			if ( $args['id'] ) { //for single team member
				$detail = $ssIO->detail( $args['id'] );
				if ( ! $detail->is_error ) {
					$member_id = $detail->items['id'];

					//set args before sending it to render template
					$renderArgs             = array(
						'is_single'   => true, //for displaying single team member
						'is_img'      => $args['image'],
						'is_name'     => $args['name'],
						'is_position' => $args['position'],
						'is_email'    => $args['email'],
						'is_website'  => $args['website'],
					);
					$renderArgs['img_url']  = $args['image'] ? ( get_post_meta( $member_id, 'ssteammember_image_id', true ) ? wp_get_attachment_image_url( get_post_meta( $member_id, 'ssteammember_image_id', true ), 'medium' ) : plugin_dir_url( __DIR__ ) . "assets/img/sample.jpg" ) : "";
					$renderArgs['name']     = $args['name'] ? get_the_title( $member_id ) : "";
					$renderArgs['position'] = $args['position'] ? get_post_meta( $member_id, 'ssteammember_position', true ) : "";
					$renderArgs['email']    = $args['email'] ? get_post_meta( $member_id, 'ssteammember_email', true ) : "";
					$renderArgs['website']  = $args['website'] ? get_post_meta( $member_id, 'ssteammember_website', true ) : "";

					//render template
					$result = $ssTemplate->render( 'teammember-profile-card', $renderArgs );
				}
			} else { //multiple
				$teamMembers = $ssIO->display( $args['limit'] );
				if ( ! $teamMembers->is_error ) {
					$result .= "<div class=\"ss_row\">";
					foreach ( $teamMembers->items as $item ) {
						$member_id = $item['id'];

						//set args before sending it to render template
						$renderArgs             = array(
							'is_single'   => false, //for displaying multiple team members
							'is_img'      => $args['image'],
							'is_name'     => $args['name'],
							'is_position' => $args['position'],
							'is_email'    => $args['email'],
							'is_website'  => $args['website'],
						);
						$renderArgs['img_url']  = $args['image'] ? ( get_post_meta( $member_id, 'ssteammember_image_id', true ) ? wp_get_attachment_image_url( get_post_meta( $member_id, 'ssteammember_image_id', true ), 'medium' ) : plugin_dir_url( __DIR__ ) . "assets/img/sample.jpg" ) : "";
						$renderArgs['name']     = $args['name'] ? get_the_title( $member_id ) : "";
						$renderArgs['position'] = $args['position'] ? get_post_meta( $member_id, 'ssteammember_position', true ) : "";
						$renderArgs['email']    = $args['email'] ? get_post_meta( $member_id, 'ssteammember_email', true ) : "";
						$renderArgs['website']  = $args['website'] ? get_post_meta( $member_id, 'ssteammember_website', true ) : "";

						$result .= "<div class=\"column\">";
						//render template
						$result .= $ssTemplate->render( 'teammember-profile-card', $renderArgs );
						$result .= "</div>";
					}
					$result .= "</div>";
				}
			}

			return $result;
		}
	}
}