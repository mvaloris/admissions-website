<?php

if (!function_exists('qode_news_reaction_fields')) {
	function qode_news_reaction_fields() {

		$news_fields = qode_add_taxonomy_fields(
            array(
			    'scope' => 'news-reaction',
				'name'  => 'news_reaction'
		    )
        );

		qode_add_taxonomy_field(
			array(
				'name'        => 'reaction_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Reaction Image', 'qode-news' ),
				'description' => '',
				'parent'      => $news_fields
			)
		);
	}
	add_action('qode_custom_taxonomy_fields', 'qode_news_reaction_fields');
}