<?php
/**
 * Dream Winners Theme functions and definitions
 *
 * @package Dream_Winners
 */

if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

new Rmcc\DreamWinners;

// if Woo class exists, do some stuff
if ( class_exists( 'WooCommerce' ) ) {
	function timber_set_product( $post ) {
		global $product;
		$product = wc_get_product( $post->ID );
	}
	// woo functions
	require get_template_directory() . '/inc/woo-functions.php';
}