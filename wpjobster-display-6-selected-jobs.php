<?php 
if (!function_exists('advmi_job_listings_display_custom')) {
	function advmi_job_listings_display_custom( $atts ) {
		ob_start();
		
	$meta_querya = array( array(
			'key'     => 'active',
			'value'   => "1",
			'compare' => '='
		) );
		
	$atts = extract(shortcode_atts(array('ids' => null), $atts));    
	$post_ids = explode(",", strval($ids));	
		
	$feature_enabled = get_option('wpjobster_featured_enable');
		if ( $feature_enabled == 'yes' ) {
			$args = array(
				'post_status'    =>'publish',
				'paged'          => 1,
				'posts_per_page' => 4,
				'post__in'	 => $post_ids,
				'post_type'      => 'job',
				'meta_query'     => $meta_querya ,
				'meta_key'       => 'home_featured_now',
				'orderby' => 'post__in',
			);
		} else {
			$args = array(
				'post_status'    =>'publish',
				'paged'          => 1,
				'posts_per_page' => 4,
				'post__in'	 => $post_ids,
				'post_type'      => 'job',
				'meta_query'     => $meta_querya,
				'orderby' => 'post__in', 
			);
		}
		if ( $cols == 3 ) {
			$wpj_job = new WPJ_Load_More_Posts( $args + array ( 'function_name' => wpj_get_job_card_style(), 'container_class' => 'ui three cards ', 'load_type' => $load_type ) );
		} else {
			$wpj_job = new WPJ_Load_More_Posts( $args + array ( 'function_name' => wpj_get_job_card_style(), 'container_class' => 'ui four cards', 'load_type' => $load_type ) );
		} ?>

		<div class="cf relative popular-in-sg">
			<?php echo listing_buttons_jobs(); ?>

			<div class="cf relative" style="width:100%">
				<?php if ( $wpj_job->have_rows() ) {
					$wpj_job->show_posts_list_func();
				} else {
					echo '<div class="no-results">' . __( "Sorry, there are no posted jobs yet.", "wpjobster" ) . '</div>';
				} ?>
			</div>
		</div>
<?php	
		
	$output = ob_get_contents();
	ob_end_clean();

		return $output;
	}
}
add_shortcode( 'advmi_job_display', 'advmi_job_listings_display_custom' );
