<?php
/*
Plugin Name: SS-WT2 (Team Member)
Description: Super simple plugins to display teammember
Version: 1.0.0
Author: Rendi Dwi Pristianto
*/

//Trigger when the plugins is being activated
function activate_ssteammember() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ssteammember-activator.php';
	SSTeamMemberActivator::activate();
}

//Trigger when the plugins is being deactivated
function deactivate_ssteammember() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ssteammember-deactivator.php';
	SSTeamMemberDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ssteammember' );
register_deactivation_hook( __FILE__, 'deactivate_ssteammember' );

//Include the main functions
require plugin_dir_path( __FILE__ ) . 'includes/class-teammember.php';

$ssTeamMember = new SSTeamMember();