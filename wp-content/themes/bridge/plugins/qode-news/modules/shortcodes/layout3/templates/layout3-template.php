<div class="qode-news-item qode-layout3-item">
	<div class="qode-news-item-image-holder">
		<?php echo qode_news_get_shortcode_inner_template_part('image','',$params);?>
        <div class="qode-news-image-info-holder-left">
			<?php echo qode_news_get_shortcode_inner_template_part('post-info/hot-trending','',$params);?>
        </div>
        <div class="qode-news-image-info-holder-right">
			<?php echo qode_news_get_shortcode_inner_template_part('post-info/share','',$params);?>
		</div>			
		<div class="qode-ni-content">
            <?php echo qode_news_get_shortcode_inner_template_part('post-info/category','',$params);?>
			<?php echo qode_news_get_shortcode_inner_template_part('title','',$params);?>
			<?php if ($display_button == 'yes') {
					echo qode_get_button_v2_html(array(
						'text' => 'Read More',
						'link' => get_the_permalink()
					));

            } ?>
			<?php echo qode_news_get_shortcode_inner_template_part('excerpt','',$params);?>
            <?php echo qode_news_get_shortcode_inner_template_part('post-info/author','',$params);?>
            <?php echo qode_news_get_shortcode_inner_template_part('post-info/review','',$params);?>

		</div>
	</div>
</div>