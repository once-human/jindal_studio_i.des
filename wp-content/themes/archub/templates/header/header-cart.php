<?php

// check
if( !liquid_helper()->is_woocommerce_active() || is_admin() || !is_object( WC()->cart ) ) {
	return;
}

$order_count = WC()->cart->get_cart_contents_count();
$is_empty    = WC()->cart->is_empty();
$sub_total   = WC()->cart->get_cart_subtotal();
$cart_id     = uniqid( 'cart-' );

$cart_text =  $atts['cart_text'];

?>

<div class="ld-module-cart ld-module-cart-dropdown d-flex align-items-center">
	
	<?php ld_el_module_trigger_render($data_target = $cart_id, $pf2 = 'hmt_', $settings = $atts, $type = 'cart'); ?>
	
	<div class="ld-module-dropdown collapse pos-abs" id="<?php echo esc_attr( $cart_id ) ?>" aria-expanded="false">
		<div class="ld-cart-contents">
			<div class="header-quickcart">
				<?php liquid_woocommerce_header_cart() ?>
			</div>
			
			<?php if( !$is_empty && !empty( $cart_text ) ) { ?>
			<div class="ld-cart-message">
				<?php echo wp_kses( do_shortcode( $cart_text ), 'lqd_post' ); ?>
			</div>
			<?php } ?>
			
		</div>
	</div>

</div>