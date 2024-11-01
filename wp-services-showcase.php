<?php
/**
 * Plugin Name: Wp Services Showcase
 * Plugin URI: http://demo.radiustheme.com/wordpress/plugins/the-post-grid/
 * Description: Fully Responsive and Mobile Friendly way to showcase your services or products on your website.
 * Author: RadiusTheme
 * Version: 1.0
 * Text Domain: wp-services-showcase
 * Domain Path: /languages
 * Author URI: https://radiustheme.com/
 */
if ( ! defined( 'ABSPATH' ) )  exit;

define('RT_WPS_PLUGIN_PATH', dirname(__FILE__));
define('RT_WPS_PLUGIN_ACTIVE_FILE_NAME', __FILE__);
define('RT_WPS_PLUGIN_URL', plugins_url('', __FILE__));
define('RT_WPS_PLUGIN_SLUG', basename( dirname( __FILE__ ) ));
define('RT_WPS_PLUGIN_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages');

require ('lib/init.php');

