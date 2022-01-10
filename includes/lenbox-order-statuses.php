<?php

/**
 * Plugin Name: Codaid Wait Lenbox Order Status
 * Plugin URI: https://github.com/codaid
 * Description: Status attente lenbox pour woocommerce.
 * Author: Codaid
 * Version: 1.0.0
 * Author URI: http://codaid.com/
 * Text-domain: codaid-woo
 */

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts()
{
	echo '<style>
		.status-lenbox-complete {
			background: #589951;
			color: #eee;
		}

		.status-lenbox-error {
			background: #b92222;
			color: #eee;
		}

		.status-lenbox-processing {
			background: #f8dda7;
			color: #94660c;
		}

		.status-lenbox-reject {
			background: #f8a7a7;
			color: #a12020;
		}
  </style>';
}

function register_lenbox_en_cours_status()
{
	register_post_status(
		'wc-lenbox-processing',
		array(
			'label' => _x('Lenbox en cours', 'Order Status', 'codaid-woo'),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_all_admin_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => __('Lenbox en cours', 'Lenbox en cours', 'codaid-woo')
		)
	);
}

function register_lenbox_error_status()
{
	register_post_status(
		'wc-lenbox-error',
		array(
			'label' => _x('Lenbox erreur', 'Order Status', 'codaid-woo'),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_all_admin_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => _n_noop('Lenbox erreur <span class="count">(%s)</span>', 'Lenbox erreur <span class="count">(%s)</span>', 'codaid-woo')
		)
	);
}

function register_lenbox_complete_status()
{
	register_post_status(
		'wc-lenbox-complete',
		array(
			'label' => _x('Lenbox complete', 'Order Status', 'codaid-woo'),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_all_admin_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => __('Paiement Lenbox validé', 'Paiement Lenbox validé', 'codaid-woo')
		)
	);
}

function register_lenbox_reject_status()
{
	register_post_status(
		'wc-lenbox-reject',
		array(
			'label' => _x('Lenbox rejeté', 'Order Status', 'codaid-woo'),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_all_admin_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => __('Paiement Lenbox rejeté', 'Paiement Lenbox rejeté', 'codaid-woo')
		)
	);
}

add_action('init', 'register_lenbox_en_cours_status');
add_action('init', 'register_lenbox_error_status');
add_action('init', 'register_lenbox_complete_status');
add_action('init', 'register_lenbox_reject_status');

function lenbox_en_cours_status($order_statuses)
{
	$order_statuses['wc-lenbox-processing'] = _x('Lenbox en cours', 'Order Status', 'codaid-woo');
	return $order_statuses;
}

function lenbox_error_status($order_statuses)
{
	$order_statuses['wc-lenbox-error'] = _x('Lenbox erreur', 'Order Status', 'codaid-woo');
	return $order_statuses;
}

function lenbox_complete_status($order_statuses)
{
	$order_statuses['wc-lenbox-complete'] = _x('Lenbox validé', 'Order Status', 'codaid-woo');
	return $order_statuses;
}

function lenbox_reject_status($order_statuses)
{
	$order_statuses['wc-lenbox-reject'] = _x('Lenbox rejeté', 'Order Status', 'codaid-woo');
	return $order_statuses;
}

add_filter('wc_order_statuses', 'lenbox_en_cours_status');
add_filter('wc_order_statuses', 'lenbox_error_status');
add_filter('wc_order_statuses', 'lenbox_complete_status');
add_filter('wc_order_statuses', 'lenbox_reject_status');

function add_to_bulk_actions_lenbox_processing()
{
	global $post_type;

	if ('shop_order' == $post_type)
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('<option>').val('marquer_lenbox_en_cours').text('<?php _e('Marquer Lenbox en cours', 'codaid-woo'); ?>').appendTo("select[name='action']");
			jQuery('<option>').val('marquer_lenbox_en_cours').text('<?php _e('Marquer Lenbox en cours', 'codaid-woo'); ?>').appendTo("select[name='action2']");
		});
	</script>
<?php
}

/*
function add_to_bulk_actions_lenbox_error()
{
	global $post_type;

	if ('shop_order' == $post_type)
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('<option>').val('marquer_lenbox_erreur').text('<?php _e('Marquer Lenbox erreur', 'codaid-woo'); ?>').appendTo("select[name='action']");
			jQuery('<option>').val('marquer_lenbox_erreur').text('<?php _e('Marquer Lenbox erreur', 'codaid-woo'); ?>').appendTo("select[name='action2']");
		});
	</script>
<?php
}
*/

function add_to_bulk_actions_lenbox_complete()
{
	global $post_type;

	if ('shop_order' == $post_type)
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('<option>').val('marquer_lenbox_valide').text('<?php _e('Marquer Lenbox validé', 'codaid-woo'); ?>').appendTo("select[name='action']");
			jQuery('<option>').val('marquer_lenbox_valide').text('<?php _e('Marquer Lenbox validé', 'codaid-woo'); ?>').appendTo("select[name='action2']");
		});
	</script>
<?php
}

function add_to_bulk_actions_lenbox_reject()
{
	global $post_type;

	if ('shop_order' == $post_type)
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('<option>').val('marquer_lenbox_reject').text('<?php _e('Marquer Lenbox rejecté', 'codaid-woo'); ?>').appendTo("select[name='action']");
			jQuery('<option>').val('marquer_lenbox_reject').text('<?php _e('Marquer Lenbox rejecté', 'codaid-woo'); ?>').appendTo("select[name='action2']");
		});
	</script>
<?php
}

add_action('admin_footer', 'add_to_bulk_actions_lenbox_processing');
// add_action('admin_footer', 'add_to_bulk_actions_lenbox_error');
add_action('admin_footer', 'add_to_bulk_actions_lenbox_complete');
add_action('admin_footer', 'add_to_bulk_actions_lenbox_reject');
