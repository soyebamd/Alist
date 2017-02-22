<?php
    global $woocommerce;
    if( WC()->cart->cart_contents_count == 0){
        $cart_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
    } else if(WC()->cart->cart_contents_count > 0){
        $cart_url = $woocommerce->cart->get_cart_url();
    }
?>
<ul class="social-icon">
    <li><a href="https://www.facebook.com/AListEducation" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
    <li><a href="https://twitter.com/AListEduNY" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    <li><a href="https://www.instagram.com/AListEducation/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    <li><a href="https://www.linkedin.com/company/a-list-education/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
    <li><a href="https://www.youtube.com/user/TheAListEducation" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
    <li><a href="<?php echo $cart_url; ?>" ><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
</ul>