<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/7/2019
 * Time: 9:19 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SSTeamMemberIO' ) ) {
	class SSTeamMemberIO {
		protected $pluginName;
		public $name;
		public $position;
		public $email;
		public $website;
		public $image;

		function __construct( $pluginName ) {
			$this->pluginName = $pluginName;
		}

		function display( $limit ) {
			$result      = new SSTeamMemberHelper();
			$qTeamMember = new WP_Query( array(
				'post_type'      => 'team-member',
				'orderby'        => 'title',
				'order'          => 'asc',
				'posts_per_page' => $limit
			) );
			if ( $qTeamMember->have_posts() ) {
				while ( $qTeamMember->have_posts() ) :
					$qTeamMember->the_post();
					$team_id         = get_the_ID();
					$result->items[] = array(
						'id'       => $team_id,
						'name'     => get_the_title( $team_id ),
						'position' => get_post_meta( $team_id, $this->pluginName . "_position" ),
						'email'    => get_post_meta( $team_id, $this->pluginName . "_email" ),
						'website'  => get_post_meta( $team_id, $this->pluginName . "_website" ),
						'image'    => get_post_meta( $team_id, $this->pluginName . "_image" ),
					);
				endwhile;
				$result->is_error = false;
			} else {
				$result->message = "No team member found";
			}
			wp_reset_query();

			return $result;
		}

		function detail( $team_id ) {
			$result = new SSTeamMemberHelper();
			$post   = get_post( $team_id );
			if ( $post && $post->post_type == 'team-member' ) {
				$result->items    = array(
					'id'       => $team_id,
					'name'     => get_the_title( $team_id ),
					'position' => get_post_meta( $team_id, $this->pluginName . "_position" ),
					'email'    => get_post_meta( $team_id, $this->pluginName . "_email" ),
					'website'  => get_post_meta( $team_id, $this->pluginName . "_website" ),
					'image'    => get_post_meta( $team_id, $this->pluginName . "_image" ),
				);
				$result->is_error = false;
			} else {
				$result->message = "Team member not found";
			}

			return $result;
		}
	}
}