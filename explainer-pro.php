<?php
/*
 * Plugin Name:       Explainer Pro
 * Plugin URI:        https://matinsaber.com/explainer-pro
 * Description:       Explain technical terms with a single click.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Matin Sabernezhad
 * Author URI:        https://matinsaber.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       explainer-pro
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'popup-hint/popupHint.php';
require_once plugin_dir_path(__FILE__) . 'popup-hint/explainer-options.php';
