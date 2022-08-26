<?php
/**
 * GN Publisher
 * 
 * @copyright 2020 Chris Andrews
 * 
 * Plugin Name: GN Publisher
 * Plugin URI: https://andrews.com/gn-publisher
 * Description: GN Publisher: The easy way to make Google News Publisher compatible RSS feeds.
 * Version: 1.3
 * Author: Chris Andrews
 * Author URI: https://andrews.com
 * Text Domain: gn-publisher
 * Domain Path: /languages
 * License: GPL v3 or later
 * 
 * GN Publisher is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * GN Publisher is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GN Publisher. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//gn publisher----------

function gnpub_feed_bootstrap() {
	
	if ( defined( 'GNPUB_VERSION' ) ) {
		return;
	}

	define( 'GNPUB_VERSION', '1.3' );
	define( 'GNPUB_PATH', plugin_dir_path( __FILE__ ) );
    define( 'GNPUB_URL', plugins_url( '', __FILE__) );
	define( 'GNPUB_PLUGIN_FILE', __FILE__ );

	add_action( 'plugins_loaded', 'gnpub_load_textdomain' );

	require_once GNPUB_PATH . 'utilities.php';
	require_once GNPUB_PATH . 'controllers/class-gnpub-feed.php';
	require_once GNPUB_PATH . 'controllers/class-gnpub-posts.php';
	require_once GNPUB_PATH . 'controllers/class-gnpub-websub.php';
	require_once GNPUB_PATH . 'class-gnpub-compat.php';

	new GNPUB_Feed();
	new GNPUB_Posts();
	new GNPUB_Websub();
	GNPUB_Compat::init();

	if ( is_admin() ) {
		require_once GNPUB_PATH . 'class-gnpub-installer.php';
		require_once GNPUB_PATH . 'class-gnpub-notices.php';
		require_once GNPUB_PATH . 'controllers/admin/class-gnpub-menu.php';
		require_once GNPUB_PATH . 'controllers/admin/class-gnpub-settings.php';

		register_activation_hook( __FILE__, array( 'GNPUB_Installer', 'install' ) );
		register_deactivation_hook( __FILE__, array( 'GNPUB_Installer', 'uninstall' ) );

		$admin_notices = new GNPUB_Notices();

		new GNPUB_Menu( $admin_notices );
		new GNPUB_Settings( $admin_notices );
	}

}

gnpub_feed_bootstrap();

function gnpub_load_textdomain() {
	load_plugin_textdomain( 'gn-publisher', false, basename( dirname( GNPUB_PLUGIN_FILE ) ) . '/languages/' );
}
