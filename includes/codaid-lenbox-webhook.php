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
			$order->update_status(apply_filters('woocommerce_lenbox4x_process_payment_order_status', 'processing', $order), __('Paiement validé par Lenbox', 'codaid-lenbox-woo'));
		} else {
			$order->update_status(apply_filters('woocommerce_lenbox4x_process_payment_order_status', 'cancelled', $order), __('Reponse Lenbox : ' . $parameters['response']['message'], 'codaid-lenbox-woo'));
		}
		$data['status'] = 'OK';
		$data['message'] = 'Order updated';
	}

	return $data;
}
