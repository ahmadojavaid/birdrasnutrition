<?php
//add woocommerce support
add_theme_support('woocommerce');

// //Store the custom field
// function myticket_add_cart_item_custom_data( $cart_item_meta, $product_id ) {
//   global $woocommerce;

//     $myticket_time = get_post_meta( $product_id, 'myticket_datetime', '');
//     $myticket_venue = get_post_meta( $product_id, 'myticket_title', '');
//     $myticket_address = get_post_meta( $product_id, 'myticket_address', '');
//     if(sizeof($myticket_time)>0){

//         $myticket_time = date_i18n(  get_option( 'date_format' )." | ".get_option( 'time_format' ), intval( $myticket_time[0] ) );
//         $cart_item_meta['myticket_time'] = (isset($_POST['myticket_time'])) ? esc_attr( $_POST['myticket_time'] ): $myticket_time;
//     }

//     if(sizeof($myticket_venue)>0)
//     $cart_item_meta['myticket_venue'] = (isset($_POST['myticket_venue'])) ? esc_attr( $_POST['myticket_venue'] ): $myticket_venue[0];

//     if(sizeof($myticket_address)>0)
//     $cart_item_meta['myticket_address'] = (isset($_POST['myticket_address'])) ? esc_attr( $_POST['myticket_address'] ): $myticket_address[0];

//     return $cart_item_meta; 
// }
// add_filter( 'woocommerce_add_cart_item_data', 'myticket_add_cart_item_custom_data', 10, 2 );

// //Get it from the session and add it to the cart variable
// function myticket_get_cart_items_from_session( $item, $values, $key ) {

//     if ( array_key_exists( 'myticket_time', $values ) )
//       $item[ 'myticket_time' ] = $values['myticket_time'];
//     if ( array_key_exists( 'myticket_venue', $values ) )
//       $item[ 'myticket_venue' ] = $values['myticket_venue'];
//     if ( array_key_exists( 'myticket_address', $values ) )
//       $item[ 'myticket_address' ] = $values['myticket_address'];
//     return $item;
// }
// add_filter( 'woocommerce_get_cart_item_from_session', 'myticket_get_cart_items_from_session', 1, 3 );

// //pass custom cart field to checkout
// function myticket_add_order_item_meta($itemID, $values) {

//     $myticket_time = $values['myticket_time'];
//     if (!empty($myticket_time)) {
//         wc_add_order_item_meta($itemID, esc_html__( 'time', 'myticket' ), $myticket_time);
//     }

//     $myticket_venue = $values['myticket_venue'];
//     if (!empty($myticket_venue)) {
//         wc_add_order_item_meta($itemID, esc_html__( 'venue', 'myticket' ), $myticket_venue);
//     }

//     $myticket_address = $values['myticket_address'];
//     if (!empty($myticket_address)) {
//         wc_add_order_item_meta($itemID, esc_html__( 'address', 'myticket' ), $myticket_address);
//     }
// }
// add_action('woocommerce_new_order_item','myticket_add_order_item_meta', 1, 2);

