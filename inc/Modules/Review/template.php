<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** @var \GTheme_Child\Modules\Review\Review $model */

$total_rating = $model->total_rating;
$reviews = $model->person_review;
$btn_text = $model->review_btn_text;
$form_id = $model->review_form_id;

?>
<div class="gc-review-stats-wrapper">
	<div class="gc-review-stats">
		<?php if ( ! empty( $total_rating ) ) : ?>
			<div class="gc-review-stars">
				<?php for ( $i = 0; $i < $total_rating; $i++ ) : ?>
					<i role="img" class="fa-solid fa-star"></i>
				<?php endfor; ?>
			</div>
		<?php endif; ?>
		<div class="gc-review-desc"><?php echo esc_html( $model->total_rating_desc ); ?></div>
	</div>
	<?php if ( ! empty( $btn_text ) and ! empty( $form_id ) ) : ?>
		<div class="gc-review-btn">
			<button class="btn"><?php echo esc_html( $btn_text ); ?></button>
		</div>
		<?php if ( ! empty( $form_id ) ) : ?>
			<div class="gc-review-form-wrapper">
				<div class="gc-review-form-inner">
					<h4 class="gc-review-form-title"><?php echo esc_html__( 'Leave a review for Cordon Negro Gran Seleción', 'g-theme-child' ); ?></h4>
					[gravityform id="<?php echo esc_attr( $form_id ); ?>" title="false" description="false" ajax="true"]
				</div>
			</div>
			<?php
		endif;
	endif;
	?>
</div>

<?php if ( ! empty( $reviews ) ) : ?>
	<div class="gc-review-single-wrapper">
		<?php foreach ( $reviews as $review ) : ?>
			<div class="gc-review-card">
				<?php if ( ! empty( $review['name'] ) ) : ?>
					<div class="gc-review-name"><?php echo esc_html( $review['name'] . ' ' . esc_html__( 'wrote:', 'g-theme-child' ) ); ?></div>
					<?php
				endif;
				if ( ! empty( $review['content'] ) ) :
					?>
					<div class="gc-review-content">
						<?php echo wp_kses_post( $review['content'] ); ?>
					</div>
					<?php
				endif;
				if ( ! empty( $review['rating'] ) ) :
					?>
					<div class="gc-review-stars">
						<?php for ( $i = 0; $i < $review['rating']; $i++ ) : ?>
							<i role="img" class="fa-solid fa-star"></i>
						<?php endfor; ?>
					</div>
					<?php
				endif;
				if ( ! empty( $review['date'] ) ) :
					?>
					<div class="gc-review-date">
						<?php echo esc_html( $review['date'] ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
endif;