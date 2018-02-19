<?php
use QodeListing\Lib\Core;
if(!function_exists('qode_listing_comment_additional_fields')) {

	function qode_listing_comment_additional_fields() {

		if (is_singular('job_listing')) {
			$html = '<div class="qode-rating-form-title-holder">'; //Form title begin
			$html .= '<div class="qode-rating-form-title">';
			$html .= '<h5>' . esc_html__('Write a Review','qode-listing') . '</h5>';
			$html .= '</div>';
			$html .= '<div class="qode-comment-form-rating">
						<label>' . esc_html__('Rate Here', 'qode-listing') . '<span class="required">*</span></label>
						<span class="qode-comment-rating-box">';
			for ($i = 1; $i <= 5; $i++) {
				$html .= '<span class="qode-star-rating" data-value="' . $i . '"></span>';
			}
			$html .= '<input type="hidden" name="qode_rating" id="qode-rating" value="3">';
			$html .= '</span></div>';
			$html .= '</div>'; //Form title end

			$html .= '<div class="qode-comment-input-title">';
			$html .= '<input id="title" name="qode_comment_title" class="qode-input-field" type="text" placeholder="' . esc_html__('Title of your Review', 'qode-listing') . '"/>';
			$html .= '</div>';

			print $html;
		}
	}

	add_action( 'comment_form_top', 'qode_listing_comment_additional_fields' );

}

if(!function_exists('qode_listing_extend_comment_edit_metafields')) {

	function qode_listing_extend_comment_edit_metafields($comment_id) {

		$comment = get_comment( $comment_id );
		$old_value = get_comment_meta($comment_id, 'qode_rating', true);
		$post_id = $comment->comment_post_ID ;

		if ((!isset($_POST['extend_comment_update']) || !wp_verify_nonce($_POST['extend_comment_update'], 'extend_comment_update')) && !is_singular('job_listing')) return;

		if ((isset($_POST['qode_comment_title'])) && ($_POST['qode_comment_title'] != '')):
			$title = wp_filter_nohtml_kses($_POST['qode_comment_title']);
			update_comment_meta($comment_id, 'qode_comment_title', $title);
		else :
			delete_comment_meta($comment_id, 'qode_comment_title');
		endif;

		if ((isset($_POST['qode_rating'])) && ($_POST['qode_rating'] != '')){
			$new_rating = wp_filter_nohtml_kses($_POST['qode_rating']);
			update_comment_meta($comment_id, 'qode_rating', $new_rating);

			$rating_obj = new Core\ListingRating($post_id, $new_rating, 'edit_rating', $old_value);
			$rating_obj->editRating();
		}
		else {
			delete_comment_meta($comment_id, 'qode_rating');
		}
	}

	add_action('edit_comment', 'qode_listing_extend_comment_edit_metafields');
}

if(!function_exists('qode_listing_extend_comment_add_meta_box')) {

	function qode_listing_extend_comment_add_meta_box() {
		add_meta_box('title', esc_html__('Comment - Reviews', 'qode-listing'), 'qode_listing_extend_comment_meta_box', 'comment', 'normal', 'high');
	}

	add_action('add_meta_boxes_comment', 'qode_listing_extend_comment_add_meta_box');

}

if(!function_exists('qode_listing_extend_comment_meta_box')) {

	function qode_listing_extend_comment_meta_box($comment) {

		if ($comment->post_type == 'job_listing') {
			$title = get_comment_meta($comment->comment_ID, 'qode_comment_title', true);
			$rating = get_comment_meta($comment->comment_ID, 'qode_rating', true);
			wp_nonce_field('extend_comment_update', 'extend_comment_update', false);
			?>
			<p>
				<label for="title"><?php esc_html_e('Comment Title', 'qode-listing'); ?></label>
				<input type="text" name="qode_comment_title" value="<?php echo esc_attr($title); ?>" class="widefat"/>
			</p>
			<p>
				<label for="rating"><?php esc_html_e('Rating', 'qode-listing'); ?>: </label>
				<span class="commentratingbox">
					<?php
					for ($i = 1; $i <= 5; $i++) {
						echo '<span class="commentrating"><input type="radio" name="qode_rating" id="rating" value="' . $i . '"';
						if ($rating == $i) echo ' checked="checked"';
						echo ' />' . $i . ' </span>';
					}
					?>
				</span>
			</p>
			<?php
		}
	}
}

if(!function_exists('qode_listing_save_comment_meta_data')) {

	function qode_listing_save_comment_meta_data($comment_id) {

		$comment = get_comment( $comment_id );
		$post_id = $comment->comment_post_ID;

		if ((isset($_POST['qode_comment_title'])) && ($_POST['qode_comment_title'] != '')) {
			$title = wp_filter_nohtml_kses($_POST['qode_comment_title']);
			add_comment_meta($comment_id, 'qode_comment_title', $title);
		}

		if ((isset($_POST['qode_rating'])) && ($_POST['qode_rating'] != '')) {
			$rating = wp_filter_nohtml_kses($_POST['qode_rating']);
			add_comment_meta($comment_id, 'qode_rating', $rating);

			$rating_obj = new Core\ListingRating($post_id, $rating);
			$rating_obj->increaseRating();

		}

	}

	add_action('comment_post', 'qode_listing_save_comment_meta_data');

}

if(!function_exists('qode_listing_verify_comment_meta_data')) {

	function qode_listing_verify_comment_meta_data($commentdata) {

		if ( is_singular('job_listing') ) {
			if (!isset($_POST['qode_rating'])) {
				wp_die(esc_html__('Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.', 'qode-listing'));
			}
		}
		return $commentdata;
	}

	add_filter('preprocess_comment', 'qode_listing_verify_comment_meta_data');

}


if(!function_exists('qode_listing_get_current_post_comments')){

	function qode_listing_get_current_post_comments($post_id, $order_by = 'comment_date_gmt' , $order = 'desc'){

		$meta_key  = '';
		if($order_by === 'rating'){
			$order_by = 'meta_value';
			$meta_key  = 'qode_rating';
		}elseif($order_by === 'date'){
			$order_by = 'comment_date_gmt';
		};

		$comment_args = array(
			'post_id' => $post_id,
			'status' => 'approve',
			'orderby' => $order_by,
			'meta_key'  => $meta_key,
			'order' => $order
		);
		if ( is_user_logged_in() ) {
			$comment_args['include_unapproved'] = get_current_user_id();
		} else {
			$commenter = wp_get_current_commenter();
			if ( $commenter['comment_author_email'] ) {
				$comment_args['include_unapproved'] = $commenter['comment_author_email'];
			}
		}

		$comments  = get_comments($comment_args);
		return $comments;

	}
}

if ( ! function_exists( 'qode_listing_post_reviews_html' ) ) {

	function qode_listing_post_reviews_html($reviews = array(), $post_id) {

		$post = get_post($post_id);
		$html = '';

		if(count($reviews)){

			foreach ($reviews as $comment){

				$is_pingback_comment = $comment->comment_type == 'pingback';
				$is_author_comment  = $post->post_author == $comment->user_id;

				$comment_class = 'qode-comment clearfix';

				if($is_author_comment) {
					$comment_class .= ' qode-post-author-comment';
				}

				if($is_pingback_comment) {
					$comment_class .= ' qode-pingback-comment';
				}
				$review_rating = get_comment_meta( $comment->comment_ID, 'qode_rating', true );
				$review_rating_style  = 'width: '.esc_attr($review_rating*20).'%';
				$review_title = get_comment_meta( $comment->comment_ID, 'qode_comment_title', true );

				$comment_params = array(
					'comment'   => $comment,
					'is_pingback_comment' => $is_pingback_comment,
					'is_author_comment' => $is_author_comment,
					'comment_class' => $comment_class,
					'review_rating_style' => $review_rating_style,
					'review_title' => $review_title,
				);
				$html .= qode_listing_single_template_part('review/review', '', $comment_params);

			}
		}
		return $html;
	}
}

if(!function_exists('qode_listing_get_post_reviews_ajax')){

	function qode_listing_get_post_reviews_ajax(){

		if(isset($_POST)) {
			$html = '';

			foreach($_POST as $key => $value) {
				if($key !== '') {
					$addUnderscoreBeforeCapitalLetter  = preg_replace('/([A-Z])/', '_$1', $key);
					$setAllLettersToLowercase          = strtolower($addUnderscoreBeforeCapitalLetter);
					$params[$setAllLettersToLowercase] = $value;
				}
			}
			extract($params);
			if(isset($order) && $order !== '' && isset($order_by) && $order_by !== '' && isset($post_id) && $post_id !== ''){
				$post_comments = qode_listing_get_current_post_comments($post_id, $order_by, $order );
				ob_start();
				qode_listing_post_reviews_html($post_comments, $post_id);
				$html = ob_get_clean();
			}

			$return_obj = array(
				'html' => $html
			);
			echo json_encode($return_obj); exit;
		}

	}

	add_action('wp_ajax_nopriv_qode_listing_get_post_reviews_ajax', 'qode_listing_get_post_reviews_ajax');
	add_action( 'wp_ajax_qode_listing_get_post_reviews_ajax', 'qode_listing_get_post_reviews_ajax' );
}