<?php 
if ( !function_exists( 'advmi_wpj_latest_jobs' ) ) {
	function advmi_wpj_latest_jobs( $cols = 3, $load_type = 'load_more' ) {
		$meta_querya = array( array(
			'key'     => 'active',
			'value'   => "1",
			'compare' => '='
		) );
		
		#extract(shortcode_atts(array('id' => null), $atts, 'fsgrid'));    
		#$post_ids = explode(",", strval($id));
		
		$feature_enabled = get_option('wpjobster_featured_enable');
		if ( $feature_enabled == 'yes' ) {
			$args = array(
				'post_status'    =>'publish',
				'paged'          => 1,
				'posts_per_page' => 1,
				'post__in'	 => array(2663,2653),
				'post_type'      => 'job',
				'meta_query'     => $meta_querya ,
				'meta_key'       => 'home_featured_now',
				'orderby' => 'post__in',
			);
		} else {
			$args = array(
				'post_status'    =>'publish',
				'paged'          => 1,
				'posts_per_page' => 1,
				'post__in'	 => array(2663,2653),
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
	<?php }
}

// Job Listing Shortcode for Popular in SG [job_listings_3]
if (!function_exists('advmi_job_listings_3_s')) {
	function advmi_job_listings_3_s() {
		ob_start();

		advmi_wpj_latest_jobs( 3 );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
wpj_add_shortcode( 'advmi_sg', 'advmi_job_listings_3_s' );
