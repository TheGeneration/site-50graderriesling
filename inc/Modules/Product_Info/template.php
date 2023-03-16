<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** @var \GTheme_Child\Modules\Product_Info\Product_Info $model */

?>

<div class="gc-product-info-wrapper">
	<div class="gc-product-price">
		<?php echo esc_html( $model->price ); ?>
	</div>
	<div class="gc-product-country">
		<?php echo gt_image( $model->flag ); ?>
		<?php echo esc_html( $model->country ); ?>
	</div>
</div>
<div class="gc-product-info-description">
	<?php echo wp_kses_post( $model->description ); ?>
</div>

<?php