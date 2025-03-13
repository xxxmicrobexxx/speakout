<?php
/*
Plugin Name: SpeakOut! Email Petitions Pro
Plugin URI: https://speakoutpetitions.com/
Description: This is the fully featured Pro version of SpeakOut! Create custom email petition forms and include them on your site via shortcode or a widget. When signed, the petition is emailed to your target and signatures are saved in the database.  There are many customisable options to make this plugin very flexible.  

Author: Steve D
Author URI: https://SpeakOutPetitions.com

Text Domain: speakout
Domain Path: /languages
Requires at least: 5.0
Tested up to: 6.0
Requires PHP: 7.4
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Version: 105.4.1
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
For the full text of the GNU General Public License see {License URI}.
*/

global $wpdb, $db_petitions, $db_signatures, $dk_speakout_version, $options;

$dk_speakout_version = '105.4.1';

$db_petitions  = $wpdb->prefix . 'dk_speakout_petitions';
$db_signatures = $wpdb->prefix . 'dk_speakout_signatures';
$options  = get_option( 'dk_speakout_options' );

// enable localizations
add_action( 'init', 'dk_speakout_translate' );
function dk_speakout_translate() {
	load_plugin_textdomain( 'speakout', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// load admin functions only on admin pages
if ( is_admin() ) {
    include_once( dirname( __FILE__ ) . '/includes/install.php' );
	include_once( dirname( __FILE__ ) . '/includes/admin.php' );
	include_once( dirname( __FILE__ ) . '/includes/petitions.php' );
	include_once( dirname( __FILE__ ) . '/includes/addnew.php' );
	include_once( dirname( __FILE__ ) . '/includes/signatures.php' );
	include_once( dirname( __FILE__ ) . '/includes/settings.php' );
	include_once( dirname( __FILE__ ) . '/includes/csv.php' );
	include_once( dirname( __FILE__ ) . '/includes/ajax.php' );
    include_once( dirname( __FILE__ ) . '/includes/verify.php' );
	include_once( dirname( __FILE__ ) . '/includes/license.php' );

	if ( version_compare( get_bloginfo( 'version' ), '3.3', '>' ) == 1 ) {
		include_once( dirname( __FILE__ ) . '/includes/help.php' );
	}

	// enable plugin activation
	register_activation_hook( __FILE__, 'dk_speakout_install' );
}
// public pages
else {
	include_once( dirname( __FILE__ ) . '/includes/emailpetition.php' );
	include_once( dirname( __FILE__ ) . '/includes/signaturelist.php' );
	include_once( dirname( __FILE__ ) . '/includes/confirmations.php' );
}

add_filter( 'plugin_row_meta', 'speakout_support_and_faq_links', 10, 4 );
function speakout_support_and_faq_links( $links_array, $plugin_file_name, $plugin_data, $status ){	
	if ( strpos( $plugin_file_name, basename(__FILE__) ) ) {

        if($plugin_data['slug'] == 'speakout') { unset($links_array[2]); }
		$links_array[] = '<a href="https://speakoutpetitions.com/faq/" target="_blank">FAQ</a>';
        $links_array[] = '<a href="https://speakoutpetitions.com/contact" target="_blank">Support</a>';        
        $links_array[] = '<a href="https://speakoutpetitions.com/changelog" target="_blank">Changelog</a>';		
		$links_array[] = 'Thanks for upgrading!';
	}
	return $links_array;
}

// updater code
if( !class_exists( 'SpeakOutUpdateChecker' ) ) {

	class SpeakOutUpdateChecker{

		public $plugin_slug;
		public $version;
		public $cache_key;
		public $cache_allowed;
		

		public function __construct( $dk_speakout_version ) {
			$this->plugin_slug = plugin_basename( __DIR__ );
			$this->version = $dk_speakout_version;
			$this->cache_key = 'speakout_custom_upd';
			$this->cache_allowed = false;

			add_filter( 'plugins_api', array( $this, 'info' ), 20, 3 );
			add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
			add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );
		}

		public function request(){

			$remote = get_transient( $this->cache_key );

			if( false === $remote || ! $this->cache_allowed ) {
				$remote = wp_remote_get(
					'https://speakoutpetitions.com/updater/info.json',
					array(
						'timeout' => 10,
						'headers' => array(
							'Accept' => 'application/json'
						)
					)
				);

				if(
					is_wp_error( $remote )
					|| 200 !== wp_remote_retrieve_response_code( $remote )
					|| empty( wp_remote_retrieve_body( $remote ) )
				) {
					return false;
				}

				set_transient( $this->cache_key, $remote, DAY_IN_SECONDS );
			}

			$remote = json_decode( wp_remote_retrieve_body( $remote ) );
			return $remote;
		}


		function info( $res, $action, $args ) {

			// do nothing if you're not getting plugin information right now
			if( 'plugin_information' !== $action ) {
				return $res;
			}

			// do nothing if it is not our plugin
			if( $this->plugin_slug !== $args->slug ) {
				return $res;
			}

			// get updates
			$remote = $this->request();

			if( ! $remote ) {
				return $res;
			}

			$res = new stdClass();

			$res->name = $remote->name;
			$res->slug = $remote->slug;
			$res->version = $remote->version;
			$res->tested = $remote->tested;
			$res->requires = $remote->requires;
			$res->author = $remote->author;
			$res->author_profile = $remote->author_profile;
			$res->download_link = $remote->download_url;
			$res->trunk = $remote->download_url;
			$res->requires_php = $remote->requires_php;
			$res->last_updated = $remote->last_updated;
			$res->sections = array(
				'description' => $remote->sections->description,
				'installation' => $remote->sections->installation,
				'changelog' => $remote->sections->changelog
			);

			if( ! empty( $remote->banners ) ) {
				$res->banners = array(
					'low' => $remote->banners->low,
					'high' => $remote->banners->high
				);
			}

			return $res;
		}

		public function update( $transient ) {

			if ( empty($transient->checked ) ) {
				return $transient;
			}

			$remote = $this->request();

			if(
				$remote
				&& version_compare( $this->version, $remote->version, '<' )
				&& version_compare( $remote->requires, get_bloginfo( 'version' ), '<=' )
				&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
			) {
				$res = new stdClass();
				$res->slug = $this->plugin_slug;
				$res->plugin = plugin_basename( __FILE__ ); 
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = $remote->download_url;

				$transient->response[ $res->plugin ] = $res;
	    }

			return $transient;
		}

		public function purge( $upgrader, $options ){

			if (
				$this->cache_allowed
				&& 'update' === $options['action']
				&& 'plugin' === $options[ 'type' ]
			) {
				// just clean the cache when new plugin version is installed
				delete_transient( $this->cache_key );
			}
		}
	}

    // if updater enabled in settings check for latest version
	if($options['updater'] == "on"){
	    new SpeakOutUpdateChecker($dk_speakout_version);
	}
}


// eliminate warning - ob_end_flush(): failed to send buffer of zlib output compression 
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

//currently disabled until I have time to fix
/* $current_user = get_current_user_id();

function SpeakOut_plugin_notice() {
    $user_id = $current_user->ID;
		if (!get_user_meta($user_id, 'SpeakOut_plugin_notice_ignore')) {
		echo '<div class="updated notice"><p>The SpeakOut! petition plugin is now also integrated with Mailerlite. Please help keep SpeakOut! 100% free - <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4PPYZ8K2KLXUJ" target=_blank">Donate</a> :: <a href="?' . $_SERVER['QUERY_STRING'] . '&SpeakOut-ignore-notice">Dismiss</a></p></div>';
	}
}
add_action('admin_notices', 'SpeakOut_plugin_notice');
	
function SpeakOut_plugin_notice_ignore() {
	$user_id = $current_user->ID;
	if (isset($_GET['SpeakOut-ignore-notice'])) {
		add_user_meta($user_id, 'SpeakOut_plugin_notice_ignore', 'true', true);
	}
}
add_action('admin_init', 'SpeakOut_plugin_notice_ignore');
*/
?>