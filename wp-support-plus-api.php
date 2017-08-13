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
$WCE_PLUGIN_DIR = plugin_dir_path( __DIR__ ).'wp-support-plus-responsive-ticket-system/';
include( $WCE_PLUGIN_DIR.'includes/admin/ajax.php' );
include( $WCE_PLUGIN_DIR.'includes/admin/validations/create_ticket.php' );

function wpsp_fetch_tickets( WP_REST_Request $request ) {
  global $wpdb;
	$sql="SELECT * FROM {$wpdb->prefix}wpsp_ticket";
  $tickets=$wpdb->get_results($sql);
  return $tickets;
}

function wpsp_post_ticket( WP_REST_Request $request ) {
  global $wpdb;
  // return class_exists('WPSPTicketCreate');
  $_POST['user_id'] = 0;
  $ticket=new WPSPTicketCreate();
  return $ticket;
  // include( plugin_dir_path( __DIR__ ).'wp-support-plus-responsive-ticket-system/includes/admin/actions/load_wpsp_actions.php' );
  // $actions=new SupportPlusAjax();
  // $actions.createNewTicket();
  // return $GLOBALS['SupportPlusAjax'];
  // $ticket = wp_ajax_createNewTicket();
  // return $ticket;
	// $ticket = new WPSPTicketCreate();
  // array(
  //   'subject' => 'subject',
  //   'default_assign_id' => '1'
  // ));
  // $ticket->user_id = '1';
  // $ticket->guest_name = 'guest_name';
  // $ticket->guest_email = 'guest_email';
  // $ticket->user_type = 'user_type';
  // $ticket->status = 'status';
  // $ticket->category = 'category';
  // $ticket->time_created = 'time_created';
  // $ticket->priority = 'priority';
  // $ticket->ticket_type = 'ticket_type';
  // $ticket->agentCreated = 'agentCreated';
  // $ticket->extension_meta = 'extension_meta';
  // $id = $ticket.createTicket();
  // return $ticket;
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
  register_rest_route('wpsp/v1', '/tickets/create', array(
    'methods' => 'POST',
    'callback' => 'wpsp_post_ticket',
    'permission_callback' => function () {
      // TODO: check that this is the best permission
      return current_user_can( 'edit_others_posts' );
    },
  ));
} );