<?php

/**
 * wpk_border-status
 *
 * @package     border-status
 * @author      WP Kraken - Paweł M.
 * @copyright   2019 MPC
 *
 * @wordpress-plugin
 * Plugin Name: WPK - border-status
 * Plugin URI:  https://wpkraken.io/
 * Description: Plugin created as a part of job from WP Kraken platform.
 * Version:     0.0.1
 * Author:      WP Kraken - Paweł M.
 * Author URI:  https://wpkraken.io
 * Text Domain: border-status
 */

/**
 * Define version.
 *
 * DO NOT EDIT VERSION NUMBER HERE.
 * It will be auto update from package.json during build process.
 */
define('VERSION', "0.0.1");

/**
 * Define Project ID
 *
 * DO NOT EDIT PROJECT ID HERE.
 * It is auto generated by the installer.
 */
define('PROJECT_ID', 'BorderStatus');


/**
 * Define other important const
 */
define('DEV_MODE', true);
define('DIR', plugin_dir_path(__FILE__));
define('URL', plugin_dir_url(__FILE__));
define('ASSETS', plugin_dir_url(__FILE__) . 'dist/');
define('BORDER_POINTS_OPTION', 'wpk_border_points_status');

include_once 'app/bootstrap.php';
