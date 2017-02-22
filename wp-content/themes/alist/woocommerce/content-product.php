<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>




                <li class="bookstore__shop-list-item flex flex-dir-col flex-align-cent">
                  <div class="bookstore__shop-img-overlay-wrap">
                    <div class="bookstore__shop-list-initial-item">
                    <a href="<?php the_permalink(); ?>" class="">
                        <!-- need to add img-full-width to class -->
                        <!-- product img -->
                        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
                      </a>

                    </div>
                    <div class="bookstore__shop-list-overlay-item" style="display:none;">
                      <div class="bookstore__shop-list-overlay-item-inner-wrap">
                        <p class="white"><?php do_action('woocommerce_single_product_excerpt'); ?></p>
                        <a href="<?php the_permalink();?>" class="red">Learn More</a>
                      </div>
                    </div>
                  </div>
                  <div class="bookstore__price-meta-wrap">
                    <p class="red bookstore__shop-list-title">
                    <a href="<?php the_permalink(); ?>" class="">
                            <?php echo $product->get_title(); ?>
                        </a>
                    </p>
                    <p class="strong bookstore__shop-list-price">
                    <a href="<?php the_permalink(); ?>" class="">
                            <?php echo $product->get_price(); ?>
                        </a>
                    </p>
                    <a rel="nofollow" href="/shop/?add-to-cart=<?php echo $product->get_id(); ?>" data-quantity="1" data-product_id="<?php echo $product->get_id(); ?>" data-product_sku="" class="default-btn product_type_simple add_to_cart_button ajax_add_to_cart">Add to cart</a>
                  </div>
  
<br><?php edit_post_link(sprintf(('Edit')));?>
 </li>



