<?php
// shortcodes
add_shortcode( 'simply_add_to_cart_ajax', 'simply_add_to_cart_html' );

function simply_add_to_cart_html(){
	$nonce = wp_create_nonce("simply_add_to_cart_nonce");
	$link = admin_url('admin-ajax.php?action=simply_add_to_cart&nonce='.$nonce);
	$button =  '<a id="simply-add-to-cart" class="" data-nonce="' . $nonce . '"  href="' . $link . '">הוספה לעגלה את הוריאציות</a>';
	include( PLUGIN_PATH . 'templates/matrix.php');
	return $button;
}
function simply_add_to_cart() {

	$nonce = $_POST['simplyNonce'];
	if ( ! wp_verify_nonce( $nonce, 'simply-nonce' ) ) {
		die ( 'Busted!' );
	}
	$matrix_example = [
		'product_id'=>'38',
		['quantity'=>4,'variation_id'=>151],
		['quantity'=>5,'variation_id'=>150]
	];
	$matrix = $_POST['data'];
	simply_add_to_cart_matrix($matrix);
	header("Location: ".$_SERVER["HTTP_REFERER"]);
	//echo  'Added to cart successfully';
	echo $_POST['data'];
	wp_die();
}
function simply_add_to_cart_matrix($matrix = []){
	foreach ($matrix[variations] as $variation){
		WC()->cart->add_to_cart( $matrix['product_id'], $variation['quantity'], $variation['variation_id'] );
	}
}
// ajax
if ( is_admin() ) {
	add_action( 'wp_ajax_simply_add_to_cart', 'simply_add_to_cart' );
	add_action( 'wp_ajax_nopriv_simply_add_to_cart', 'simply_add_to_cart' );
	// Add other back-end action hooks here
} else {
	// Add non-Ajax front-end action hooks here
}
// add custom cart item meta
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 25, 2 );
function add_cart_item_data( $cart_item_meta, $product_id ) {
	if(isset($_POST['simplyNonce'])){
		$cart_item_data['unique_key'] = $_POST ['simplyNonce'];
		$cart_item_meta ['names'] = 'the name' ;  // how to get the name from Ajax ?
	}
	return $cart_item_meta;
}