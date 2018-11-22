<?php

add_action( 'wp_enqueue_scripts', 'stm_enqueue_parent_styles' );

function stm_enqueue_parent_styles() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('stm-theme-style') );


}

add_action( 'wp_enqueue_scripts', 'asian_enqueue_side_nav_styles' );

function asian_enqueue_side_nav_styles() {

    wp_enqueue_style( 'side-nav-style', get_stylesheet_directory_uri() . '/assets/css/side-nav.css', array('stm-theme-style'),'1.0.0' );


}

// Before VC Init
add_action( 'vc_before_init', 'vc_before_init_actions' );
 
function vc_before_init_actions() {
     
    //.. Code from other Tutorials ..//
 
    // Require new custom Element
    require_once( get_stylesheet_directory().'/vc-elements/vc-custom-car-elements.php' ); 
     
}
function finance_button_smooth_scroll(){

	?>
	<script type="text/javascript">
jQuery(document).ready(function($) {
    $("a").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();

            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function() {


                window.location.hash = hash;
            });
        } // End if
    });
});
	</script>
	<?php
}

add_action('wp_footer','finance_button_smooth_scroll');

// Function to change email address
 
function ail_sender_email( $original_email_address ) {
    return 'sales@asianimportsltd.com';
}
 
// Function to change sender name
function ail_sender_name( $original_email_from ) {
    return 'Asian Imports Limited';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'ail_sender_email' );
add_filter( 'wp_mail_from_name', 'ail_sender_name' );



function car_carousel_styles() {

wp_register_style('owl-custom-carousel', get_stylesheet_directory_uri() .'/css/owl-custom-style.css', array(), null, 'all' );
wp_enqueue_style( 'owl-custom-carousel' );

}
add_action( 'wp_enqueue_scripts', 'car_carousel_styles' );



// function car_carousel_scripts(){
// wp_enqueue_script('owl-carousel-js-child', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '1.0.0', true );
// wp_enqueue_script('car-carousel-settings', get_stylesheet_directory_uri() . '/js/car-carousel-settings.js', array(), '1.0.0', true );

// }
 // add_action( 'wp_enqueue_scripts', 'car_carousel_scripts');