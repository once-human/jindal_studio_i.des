<?php

// check
if( !liquid_helper()->is_woocommerce_active() || is_admin() || !is_object( WC()->cart ) ) {
	return;
}

$order_count = WC()->cart->get_cart_contents_count();
$is_empty    = WC()->cart->is_empty();
$sub_total   = WC()->cart->get_cart_subtotal();
$cart_id     = uniqid( 'cart-' );

?>

<div class="ld-module-cart ld-module-cart-offcanvas d-flex align-items-center">
	
	<?php ld_el_module_trigger_render($data_target = $cart_id, $pf2 = 'hmt_', $settings = $atts, $type = 'cart'); ?>
	
	<div class="ld-module-dropdown ld-module-cart-offcanvas-dropdown collapse d-block pos-abs will-change-transform" id="<?php echo esc_attr( $cart_id ); ?>" aria-expanded="false">
		<div class="ld-cart-contents h-vh-100">

			<div class="header-quickcart d-flex flex-wrap">
				<?php liquid_woocommerce_header_cart() ?>
			</div>
			
			<?php if( !$is_empty && !empty( $cart_footer_text ) ) { ?>
			<div class="ld-cart-message">
				<?php echo esc_html( $cart_footer_text ); ?>
			</div>
			<?php } ?>
			
		</div>
	</div>

</div>