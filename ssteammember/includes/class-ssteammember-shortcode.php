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

			$ssIO = new SSTeamMemberIO( $this->pluginName );
			if ( $args['id'] ) { //for single team member
				$detail = $ssIO->detail( $args['id'] );
				if ( ! $detail->is_error ) {
					$member_id = $detail->items['id'];
					$result    .= "<div class=\"team single\">";
					if ( $args['image'] ) {
						$img_id  = get_post_meta( $member_id, 'ssteammember_image_id', true );
						$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : plugin_dir_url( __DIR__ ) . "assets/img/sample.jpg";
						$result  .= "<div class=\"cover\" style=\"background: url($img_url) center no-repeat\"></div>";
					}

					$result .= $args['name'] ? "<h3>" . $detail->items['name'] . "</h3>" : "";
					$result .= $args['position'] ? "<p class=\"position\">" . $detail->items['position'][0] . "</p>" : "";
					if ( $args['email'] or $args['website'] ) {
						$result .= "<div class=\"footer\">";
						$result .= $args['email'] ? "<a href=\"mailto:" . $detail->items['email'][0] . "\"><i class=\"dashicons dashicons-email-alt\"></i> " . $detail->items['email'][0] . "</a>" : "";
						$result .= $args['website'] ? "<a href=\"" . $detail->items['website'][0] . "\" target=\"_blank\"><i class=\"dashicons dashicons-admin-site\"></i> " . $detail->items['website'][0] . "</a>" : "";
						$result .= "</div>";
					}
					$result .= "</div>";
				}
			} else { //multiple
				$teamMembers = $ssIO->display( $args['limit'] );
				if ( ! $teamMembers->is_error ) {
					$result .= "<div class=\"ss_row\">";
					foreach ( $teamMembers->items as $item ) {
						$member_id = $item['id'];
						$result    .= "<div class=\"column\">";
						$result    .= "<div class=\"team\">";
						if ( $args['image'] ) {
							$img_id  = get_post_meta( $member_id, 'ssteammember_image_id', true );
							$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : plugin_dir_url( __DIR__ ) . "assets/img/sample.jpg";
							$result  .= "<div class=\"cover\" style=\"background: url($img_url) center no-repeat\"></div>";
						}

						$result .= $args['name'] ? "<h3>" . $item['name'] . "</h3>" : "";
						$result .= $args['position'] ? "<p class=\"position\">" . $item['position'][0] . "</p>" : "";
						if ( $args['email'] or $args['website'] ) {
							$result .= "<div class=\"footer\">";
							$result .= $args['email'] ? "<a href=\"mailto:" . $item['email'][0] . "\"><i class=\"dashicons dashicons-email-alt\"></i> " . $item['email'][0] . "</a>" : "";
							$result .= $args['website'] ? "<a href=\"" . $item['website'][0] . "\" target=\"_blank\"><i class=\"dashicons dashicons-admin-site\"></i> " . $item['website'][0] . "</a>" : "";
							$result .= "</div>";
						}
						$result .= "</div>";
						$result .= "</div>";
					}
					$result .= "</div>";
				}
			}

			return $result;
		}
	}
}