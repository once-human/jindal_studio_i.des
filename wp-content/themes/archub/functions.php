<?php

/**
 * The Liquid Themes ArcHub Theme
 *
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Text Domain: archub
 * Domain Path: /languages/
 */

// Starting The Engine / Load the Liquid Framework ----------------
update_option( 'archub_purchase_code', '**********' );
update_option( 'archub_purchase_code_status', 'valid' );
update_option( 'archub_register_email', '**********@mail.com' );
update_option( '_license_key_status', 'valid' );

include_once( get_template_directory() . '/liquid/liquid-init.php' );