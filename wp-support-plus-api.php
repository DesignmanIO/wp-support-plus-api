<?php
/*
 * Plugin Name:       WP Support Plus API
 * Description:       REST API Access to WP Support Plus
 * Version:           0.0.1
 * Author:            Designman
 * Author URI:        http://designman.io/
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

global $wpdb;

function wpsp_fetch_tickets( WP_REST_Request $request ) {
  global $wpdb;
	$sql="SELECT * FROM {$wpdb->prefix}wpsp_ticket";
  $tickets=$wpdb->get_results($sql);
  return $tickets;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wpsp/v1', '/tickets', array(
		'methods' => 'GET',
		'callback' => 'wpsp_fetch_tickets',
    'permission_callback' => function () {
      // TODO: check that this is the best permission
      return current_user_can( 'edit_others_posts' );
    },
	) );
} );