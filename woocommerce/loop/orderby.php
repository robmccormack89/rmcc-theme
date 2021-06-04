<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cats_args = array(
  'taxonomy' => 'product_cat',
  'hide_empty' => true,
  'orderby' => 'slug',
  'parent' => 0,
);
$cats = get_terms($cats_args);

?>

<form class="uk-form-stacked uk-margin-medium-bottom woocommerce-ordering uk-position-relative" method="get">
	
	<div class="uk-child-width-1-2 uk-child-width-auto@s uk-grid-small" uk-grid>
		<?php if($cats): ?>
			<div class="filtering-category">
				<label class="uk-form-label uk-text-bold uk-text-emphasis uk-text-uppercase" for="form-stacked-select">Filter</label>
				<div class="uk-form-controls uk-position-relative">
					<select name="product_cat" class="uk-select uk-form-width-medium product_cats" id="form-stacked-select" aria-label="<?php esc_attr_e( 'Shop filter', 'cautious_octo_fiesta' ); ?>">
						<?php if(!($_GET['product_cat'])): ?>
							<option selected disabled hidden>Select a category</option>
						<?php endif; ?>
						<?php foreach ($cats as $cat) { ?>
							<option value="<?php echo $cat->slug?>" <?php if($_GET['product_cat'] === $cat->slug): echo 'selected'; endif; ?>>
								<?php echo $cat->name ?>
							</option>
						<?php } ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<div class="filtering-sorting">
			<label class="uk-form-label uk-text-bold uk-text-emphasis uk-text-uppercase" for="form-stacked-select">Sorting</label>
			<div class="uk-form-controls">
				<select name="orderby" class="uk-select uk-form-width-medium orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
					<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	
	<div class="filtering-reset" style="position: absolute;top: -2rem;">
		<?php if($_GET['product_cat'] || $_GET['orderby']): ?>
			<a class="" href="<?php echo(remove_query_arg(array_keys($_GET))); ?>" style="font-size: 0.9rem;"><i class="far fa-times-circle"></i> Reset Filters</a>
		<?php endif; ?>
	</div>

	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page', 'product_cat' ) ); ?>
	
</form>

<script>
	jQuery(function($) {
	  $(".woocommerce-ordering").on("change", "select.product_cats", function() {
      $(this).closest("form").trigger("submit")
	  });
	});
</script>