<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>
	

	<?php echo do_shortcode('[metaslider id="5041"]'); ?>

<div class="cats-home">

<a href="/category/kucheta/">
<div class="cat"><i class="fas fa-dog"></i> Кучета</div>
</a>
<a href="/category/kotki/">
<div class="cat"><i class="fas fa-cat"></i> Котки</div>
</a>
<a href="category/ptici/">
<div class="cat"><i class="fas fa-dove"></i> Птици</div>
</a>
<a href="/category/akvaristika/">
<div class="cat"><i class="fas fa-fish"></i> Акваристика</div>
</a>
<a href="/category/grizachi/">
<div class="cat"><i class="fas fa-rabbit"></i> Гризачи</div>
</a>

<a href="/category/teraristika/">
<div class="cat"><i class="fas fa-frog"></i> Тераристика</div>
</a>

<!-- <a href="/category/grooming/">
<div class="cat"><i class="fas fa-cut"></i> Груминг</div>
</a> -->

<a href="/category/apteka/">
<div class="cat"><i class="fas fa-briefcase-medical"></i> Аптека</div>
</a>

</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			do_action( 'homepage' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
