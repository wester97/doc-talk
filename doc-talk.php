<?php
/**
 * Plugin Name: Doc Talk
 * Plugin URI:  http://westeven.com
 * Description: A handy way to manage your practice
 * Version:     0.0.0
 * Author:      WeSteven
 * Author URI:  http://westeven.com
 * Donate link: http://westeven.com
 * License:     GPLv2
 * Text Domain: doc-talk
 * Domain Path: /languages
 *
 * @link http://westeven.com
 *
 * @package Doc Talk
 * @version 0.0.0
 */

/**
 * Copyright (c) 2017 WeSteven (email : westeven@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using generator-plugin-wp
 */


// User composer autoload.
require 'vendor/autoload_52.php';

/**
 * Main initiation class
 *
 * @since  NEXT
 */
final class Doc_Talk {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  NEXT
	 */
	const VERSION = '0.0.0';

	/**
	 * URL of plugin directory
	 *
	 * @var string
	 * @since  NEXT
	 */
	protected $url = '';

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  NEXT
	 */
	protected $path = '';

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  NEXT
	 */
	protected $basename = '';

	/**
	 * Singleton instance of plugin
	 *
	 * @var Doc_Talk
	 * @since  NEXT
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  NEXT
	 * @return Doc_Talk A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin
	 *
	 * @since  NEXT
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function plugin_classes() {
		// Attach other plugin classes to the base plugin class.
		// $this->plugin_class = new DT_Plugin_Class( $this );
	} // END OF PLUGIN CLASSES FUNCTION

	/**
	 * Add hooks and filters
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function hooks() {
		// Priority needs to be:
		// < 10 for CPT_Core,
		// < 5 for Taxonomy_Core,
		// 0 Widgets because widgets_init runs at init priority 1.
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Activate the plugin
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function _activate() {
		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function _deactivate() {}

	/**
	 * Init hooks
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function init() {
		if ( $this->check_requirements() ) {
			load_plugin_textdomain( 'doc-talk', false, dirname( $this->basename ) . '/languages/' );
			$this->plugin_classes();
		}
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  NEXT
	 * @return boolean result of meets_requirements
	 */
	public function check_requirements() {
		if ( ! $this->meets_requirements() ) {

			// Add a dashboard notice.
			add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

			// Deactivate our plugin.
			add_action( 'admin_init', array( $this, 'deactivate_me' ) );

			return false;
		}

		return true;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function deactivate_me() {

		// We do a check for deactivate_plugins before calling it, to protect
		// any developers from accidentally calling it too early and breaking things.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met
	 *
	 * @since  NEXT
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {
		// Do checks for required classes / functions
		// function_exists('') & class_exists('').
		// We have met all requirements.
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function requirements_not_met_notice() {
		// Output our error.
		echo '<div id="message" class="error">';
		echo '<p>' . sprintf( __( 'Doc Talk is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'doc-talk' ), admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  NEXT
	 * @param string $field Field to get.
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
				return $this->$field;
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}

/**
 * Grab the Doc_Talk object and return it.
 * Wrapper for Doc_Talk::get_instance()
 *
 * @since  NEXT
 * @return Doc_Talk  Singleton instance of plugin class.
 */
function doc_talk() {
	return Doc_Talk::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', array( doc_talk(), 'hooks' ) );

register_activation_hook( __FILE__, array( doc_talk(), '_activate' ) );
register_deactivation_hook( __FILE__, array( doc_talk(), '_deactivate' ) );
