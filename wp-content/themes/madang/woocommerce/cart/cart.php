<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<main> 
	<!-- main content starts -->
    <!-- ============== cart page starts ============== -->

    <!-- steps -->
    <div class="block cart-steps">
        <div class="container">
          <div class="row">
              <div class="col-xs-12 col-sm-12">                            
                  <ul class="text-center steps">
                    <li class="wow fadeInUp step1 current animated" ><a href="#" class="hvr-wobble-top"><span>1</span> <?php echo esc_html__("Shopping Cart", "madang");?></a></li>
                    <li class="wow fadeInUp step2 animated" ><a href="#"  class="hvr-wobble-top"><span>2</span> <?php echo esc_html__("Checkout","madang");?></a></li>
                    <li class="wow fadeInUp step3 animated" ><a href="#" class="hvr-wobble-top"><span>3</span> <?php echo esc_html__("Order Complete","madang");?></a></li>
                </ul>                        
              </div>
          </div>
        </div>
    </div>
    <!--steps ends-->

	<div class="container">
           
        <div class="row block">
            <!--shop table-->
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 shop-list">
             <?php wc_print_notices(); ?> 

<?php
do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart shop_table_products" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name" colspan="2"><?php esc_html_e( 'Product', 'madang' ); ?></th>
			<th class="product-price"><?php esc_html_e( 'Price', 'madang' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'madang' ); ?></th>
			<th class="product-subtotal"><?php esc_html_e( 'Total', 'madang' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php

		global $madang_calories_total;
		global $madang_proteins_total;
		global $madang_fats_total;
		global $madang_carbohydrates_total;
		$madang_calories_total = $madang_proteins_total = $madang_fats_total = $madang_carbohydrates_total = 0;
		$metering = get_theme_mod( 'madang_metering', 'g' );
		$metering_cal = get_theme_mod( 'madang_calories', 'kcal' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-remove" data-title="<?php esc_html_e( 'Action', 'madang' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove this item', 'madang' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>

					<td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'madang-thumb', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo '<figure class="product-thumb">'.$thumbnail.'</figure>';
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
					</td>

					<td class="product-name" data-title="<?php esc_html_e( 'Product', 'madang' ); ?>" colspan="2">
						<div class="prod-disc clear">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<h6 class="text-sp"><a href="%s">%s</a></h6>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

				            $madang_title = get_post_meta( $product_id, 'madang_title', '');
                            if( sizeof($madang_title)==0 ) $madang_title[0] = '';

                            $madang_calories = get_post_meta( $product_id, 'madang_calories', '');
                            if( sizeof($madang_calories)==0 ) { $madang_calories[0] = ''; }else{ $madang_calories_total += (intval($madang_calories[0]) * $cart_item['quantity']); }

                            $madang_proteins = get_post_meta( $product_id, 'madang_proteins', '');
                            if( sizeof($madang_proteins)==0 ) { $madang_proteins[0] = ''; }else{ $madang_proteins_total += (intval($madang_proteins[0]) * $cart_item['quantity']); }

                            $madang_fats = get_post_meta( $product_id, 'madang_fats', '');
                            if( sizeof($madang_fats)==0 ) { $madang_fats[0] = ''; }else{ $madang_fats_total += (intval($madang_fats[0]) * $cart_item['quantity']); }

                            $madang_carbohydrates = get_post_meta( $product_id, 'madang_carbohydrates', '');
                            if( sizeof($madang_carbohydrates)==0 ) { $madang_carbohydrates[0] = ''; }else{ $madang_carbohydrates_total += (intval($madang_carbohydrates[0]) * $cart_item['quantity']); }


							echo '<span class="text-lt text-sp">'.esc_attr($madang_title[0]).'</span>'; ?>
								<?php if ( 1 != get_theme_mod( 'madang_cart_nutrition' ) ) : ?>
								    <div class="facts-table">
	                                    <table>
	                                        <tbody>
	                                            <?php if( $madang_calories[0]!='' ) :?>
	                                            <tr>
	                                                <td><span><?php echo esc_html__('Calories', 'madang'); ?></span></td>
	                                                <td><span><?php echo esc_attr($madang_calories[0].$metering_cal); ?></span></td>
	                                            </tr>
	                                            <?php endif;?>
	                                            <?php if( $madang_proteins[0]!='' ) :?>
	                                            <tr>
	                                                <td><span><?php echo esc_html__('Proteins', 'madang'); ?></span></td>
	                                                <td><span><?php echo esc_attr($madang_proteins[0].$metering); ?></span></td>
	                                            </tr>
	                                            <?php endif;?>
	                                            <?php if( $madang_fats[0]!='' ) :?>
	                                            <tr>
	                                                <td><span><?php echo esc_html__('Fats', 'madang'); ?></span></td>
	                                                <td><span><?php echo esc_attr($madang_fats[0].$metering); ?></span></td>
	                                            </tr>
	                                            <?php endif;?>
	                                            <?php if( $madang_carbohydrates[0]!='' ) :?>
	                                            <tr>
	                                                <td><span><?php echo esc_html__('Carbohydrates', 'madang'); ?></span>  </td>
	                                                <td><span><?php echo esc_attr($madang_carbohydrates[0].$metering); ?></span></td>
	                                            </tr>
	                                            <?php endif;?>
	                                        </tbody>
	                                    </table>
	                                </div>
                            	<?php endif;?>
							<?php
							// Meta data
							echo wc_get_formatted_cart_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'madang' ) . '</p>';
							}
						?>
						</div>
					</td>

					<td class="product-price" data-title="<?php esc_html_e( 'Price', 'madang' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_html_e( 'Quantity', 'madang' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal" data-title="<?php esc_html_e( 'Total', 'madang' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'madang' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'madang' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'madang' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'madang' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

			</div>
		</div>

        <!-- help block -->
		<?php 
		$banner = get_theme_mod( 'madang_help_banner', '1' );
		if ( $banner == '1' ){
			$banner_background = (get_theme_mod( 'madang_banner_background', '' ));
				if(empty($banner_background) || '' == $banner_background){

					$banner_background = get_template_directory_uri() . '/images/help-image.jpg';
			} ?>
			<div class="box-soft-gray help-box" style="background-image: url(<?php echo esc_url($banner_background);?>);" >
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-sm-offset-1 wow left fadeInLeft">
						<div class="wrap">
							<h3><?php echo esc_html( get_theme_mod( 'madang_banner_title', 'NEED HELP?' ) ); ?></h3>
							<h5><?php echo madang_output_html( get_theme_mod( 'madang_banner_text', 'Got to Customizer > E-commerce > Support to customize this section.' ) ); ?></h5>
							<?php $help_link = get_theme_mod( 'madang_banner_link', '' ); ?>
							<?php if ( $help_link != '' ){ ?>
								<a href="<?php echo esc_url( $help_link ); ?>" class="btn hvr-wobble-top"><?php echo esc_html( get_theme_mod( 'madang_banner_cta', 'HELP' ) ); ?></a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<!-- help block ends-->
		<?php } ?>

	</div>
</main>