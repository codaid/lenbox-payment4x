<?php

/**
 * Plugin Name: Lenbox Paiement 4x
 * Plugin URI: https://github.com/codaid
 * Description: Offrez le paiement en 4x grace a Lenbox.
 * Author: Codaid
 * Version: 1.0.0
 * Author URI: http://codaid.com/
 * Text-domain: codaid-lenbox-woo
 *
 * Class WC_Gateway_Lenbox_4x file.
 *
 * @package WooCommerce\Lenbox
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	return;
}

add_action('plugins_loaded', 'lenbox_payment_4x_init', 11);
add_filter('woocommerce_payment_gateways', 'add_to_woo_lenbox_payment_4x_gateway');

function lenbox_payment_4x_init()
{
	if (class_exists('WC_Payment_Gateway')) {
		require_once plugin_dir_path(__FILE__) . '/includes/class-wc-payment-4x-gateway-lenbox.php';
		require_once plugin_dir_path(__FILE__) . '/includes/lenbox-order-statuses.php';
		require_once plugin_dir_path(__FILE__) . '/includes/lenbox-4x-add-description-price.php';
		require_once plugin_dir_path(__FILE__) . '/includes/codaid-lenbox-webhook.php';
	}
}

function add_to_woo_lenbox_payment_4x_gateway($gateways)
{
	$gateways[] = 'WC_Gateway_Lenbox_4x';
	return $gateways;
}
