<?php
/****************Remove storefront breadcrumbs */
/*add_action( 'init', 'storefront_remove_storefront_breadcrumbs' );

function storefront_remove_storefront_breadcrumbs() {
   remove_action( 'storefront_before_content', 'woocommerce_breadcrumb', 10 );
}*/
/**
 * Prints the Breadcrumb in Storefront using the function by Yoast SEO.
 */
/*function storefront_yoast_breadcrumb() {
	if ( function_exists( 'yoast_breadcrumb' ) && ! is_home() ) {
		yoast_breadcrumb( '<nav class="breadcrumbs">','</nav>' );
	}
}
add_action( 'storefront_content_top', 'storefront_yoast_breadcrumb' );
*/
/************** remove user and date */
function remove_storefront_post_meta() {
	remove_action('storefront_post_header_before', 'storefront_post_meta', 10);
	
};

add_action( 'init', 'remove_storefront_post_meta');

/************* */
/**
 * Hide category product count in product archives
 */
add_filter( 'woocommerce_subcategory_count_html', '__return_false' );
/******* remove copyright */
add_action( 'init', 'custom_remove_footer_credit', 10 );

function custom_remove_footer_credit () {
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
    add_action( 'storefront_footer', 'custom_storefront_credit', 20 );
} 

function custom_storefront_credit() {
	?>
	<div class="site-info">
		&copy; <?php echo get_bloginfo( 'name' ) . ' ' . get_the_date( 'Y' ) . ' - ' . date("Y")
		; ?>
	</div><!-- .site-info -->
	<?php
}

/**** remove category images ***/
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

/*********/ 

// remove the subcategories from the product loop
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

// add subcategories before the product loop (yet after catalog_ordering and result_count -> see priority 40)
add_action( 'woocommerce_cats', 'wp56123_show_product_subcategories', 40 );

function wp56123_show_product_subcategories() {
    $subcategories = woocommerce_maybe_show_product_subcategories();
        if ($subcategories) {
          echo '<ul class="subcategories">',$subcategories,'</ul>';
    }
}
/********************************* */
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
