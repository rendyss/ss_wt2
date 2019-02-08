<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/8/2019
 * Time: 9:33 AM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}; ?>
<div class="team <?php echo $is_single ? "single" : ""; ?>">
	<?php echo $is_img ? "<div class=\"cover\" style=\"background: url(" . $img_url . ") center no-repeat; background-size: cover\"></div>" : "";
	echo $is_name ? "<h3>" . $name . "</h3>" : "";
	echo $is_position ? "<p class=\"position\">" . $position . "</p>" : "";

	if ( $is_email or $is_website ) { ?>
        <div class="footer">
			<?php echo $is_email ? "<a href=\"mailto:" . $email . "\"><i class=\"dashicons dashicons-email-alt\"></i> " . $email . "</a>" : "";
			echo $is_website ? "<a href=\"" . $website . "\" target=\"_blank\"><i class=\"dashicons dashicons-admin-site\"></i> " . $website . "</a>" : ""; ?>
        </div>
	<?php } ?>
</div>
