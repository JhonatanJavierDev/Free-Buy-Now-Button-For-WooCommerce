<?php
/*
Plugin Name: Free Buy Now Button For WooCommerce
Description: Add a "Buy Now" button on the WooCommerce product page.
Version: 1.0
Author: Author: <a href="https://github.com/jhonatanjavierdev">TioJhon07</a>

*/


add_action( 'woocommerce_after_add_to_cart_button', 'add_buy_now_button' );
function add_buy_now_button() {
    global $product;
    if ( $product->is_purchasable() && $product->is_in_stock() ) {
        echo '<button type="submit" class="single_add_to_cart_button button alt buy-now">Comprar ahora</button>';
    }
}

add_action( 'wp_footer', 'redirect_to_checkout_on_buy_now_click' );
function redirect_to_checkout_on_buy_now_click() {
    if ( ! is_product() ) {
        return;
    }
    ?>
    <script>
        jQuery('.buy-now').click(function (e) {
            e.preventDefault();

            // Check if product has options
            var has_options = jQuery('form.cart').find('[name^="attribute"]').length;
            if (has_options) {
                // Trigger add to cart button if product has options
                jQuery('button[name="add-to-cart"]').trigger('click');
            } else {
                // Add product to cart and redirect to checkout if product has no options
                var form = jQuery('form.cart');
                form.submit();
            }

            // Check if product is added to cart
            var check_interval = setInterval(function() {
                if (jQuery('.woocommerce-message').length) {
                    window.location.href = "<?php echo esc_url( wc_get_checkout_url() ); ?>";
                    clearInterval(check_interval);
                }
            }, 100);
        });
    </script>
    <?php
}
