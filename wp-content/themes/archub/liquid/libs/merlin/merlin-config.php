<?php
/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

	$config = array(
		'directory'            => 'merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'liquid-setup', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'liquid', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => true, // EDD license activation step.
		'license_required'     => true, // Require the license activation step.
		'license_help_url'     => 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => home_url( '/' ), // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Setup Wizard', 'archub' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'archub' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'archub' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'archub' ),

		'btn-skip'                 => esc_html__( 'Skip', 'archub' ),
		'btn-next'                 => esc_html__( 'Next', 'archub' ),
		'btn-start'                => esc_html__( 'Start', 'archub' ),
		'btn-no'                   => esc_html__( 'Cancel', 'archub' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'archub' ),
		'btn-child-install'        => esc_html__( 'Install', 'archub' ),
		'btn-content-install'      => esc_html__( 'Install', 'archub' ),
		'btn-import'               => esc_html__( 'Import', 'archub' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'archub' ),
		'btn-license-skip'         => esc_html__( 'Later', 'archub' ),

		/* translators: Theme Name */
		'license-header'         => esc_html__( 'Activate Theme', 'archub' ),
		'license-header2'         => esc_html__( 'Activate Your Theme', 'archub' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'archub' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Please add your Envato purchase code along with your email address to confirm the purchase.', 'archub' ),
		'license-label'            => esc_html__( 'License key', 'archub' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'archub' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'archub' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'archub' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Let\'s Get You Started', 'archub' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'archub' ),
		'welcome%s'                => esc_html__( 'Thanks for purchasing ArcHub! You can now register your product in 10 seconds to install plugins, import demos and unlock exlusive features.', 'archub' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'archub' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'archub' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'archub' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'archub' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'archub' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'archub' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'archub' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'archub' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'archub' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'archub' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get you started.', 'archub' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'archub' ),
		'plugins-action-link'      => esc_html__( 'View Plugins', 'archub' ),

		'import-header'            => esc_html__( 'Import Content', 'archub' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'archub' ),
		'import-action-link'       => esc_html__( 'Advanced', 'archub' ),

		'ready-header'             => esc_html__( 'You\'re Ready!', 'archub' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'archub' ),
		'ready-action-link'        => esc_html__( 'Extras', 'archub' ),
		'ready-big-button'         => esc_html__( 'View your website', 'archub' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://docs.liquid-themes.com/', esc_html__( 'Help center', 'archub' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://liquidthemes.freshdesk.com/support/home', esc_html__( 'Get Theme Support', 'archub' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'archub' ) ),
	)
);