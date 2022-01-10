<?php

/**
 * Plugin Name: Codaid Lenbox Webhook
 */

add_action('rest_api_init', 'codaid_lenbox_webhook');

function codaid_lenbox_webhook()
{
	register_rest_route(
		'codaid/lenbox/v1/',
		'receive-callback',
		array(
			'methods' => 'POST',
			'callback'	=> 'codaid_lenbox_receive_callback'
		)
	);
}

function codaid_lenbox_receive_callback($request_data)
{
	$data = array();

	$parameters = $request_data->get_params();

	$status = $parameters['status'];
	if (isset($status)) {
		$order =  wc_get_order($parameters['response']['productid']);
		if ($status === "success" && $parameters['response']['accepted'] === true) {
			$order->payment_complete($parameters['response']['orderID']);
			$order->update_status(apply_filters('woocommerce_lenbox_process_payment_order_status', 'wc-lenbox-complete', $order), __('Lenbox VALIDÉ.', 'codaid-lenbox-woo'));
			$data['status'] = 'OK';
			$data['message'] = 'Order updated';
		} else {
			$order->update_status(apply_filters('woocommerce_lenbox_process_payment_order_status', 'wc-lenbox-reject', $order), __('Lenbox REJETÉ.', 'codaid-lenbox-woo'));
			$data['message'] = $parameters['response']['message'];
		}
	}

	return $data;
}
