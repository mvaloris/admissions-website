<?php
if(qode_restaurant_theme_installed()) {
	if(!function_exists('qode_restaurant_meta_box_map')) {
		function qode_restaurant_meta_box_map()
		{

			$restaurant_menu_meta_box = qode_add_meta_box(
				array(
					'scope' => array('qode-restaurant-menu'),
					'title' => esc_html__('Restaurant Menu Item Settings', 'qode-restaurant'),
					'name' => 'cafe_menu_item_meta'
				)
			);


			qode_add_meta_box_field(
				array(
					'name'          => 'qode_restaurant_menu_item_price',
					'type'          => 'text',
					'default_value' => '',
					'label'         => esc_html__('Restaurant Menu Item Price', 'baristawp'),
					'description'   => esc_html__('Enter price for this restaurant menu item', 'qode-restaurant'),
					'parent'        => $restaurant_menu_meta_box,
					'args'          => array(
						'col_width' => '3'
					)
				)
			);

			qode_add_meta_box_field(
				array(
					'name'          => 'qode_restaurant_menu_item_description',
					'type'          => 'text',
					'default_value' => '',
					'label'         => esc_html__('Restaurant Menu Item Description', 'baristawp'),
					'description'   => esc_html__('Enter description for this restaurant menu item', 'qode-restaurant'),
					'parent'        => $restaurant_menu_meta_box,
				)
			);

			qode_add_meta_box_field(
				array(
					'name'          => 'qode_restaurant_menu_item_label',
					'type'          => 'text',
					'default_value' => '',
					'label'         => esc_html__('Restaurant Menu Item Label', 'baristawp'),
					'description'   => esc_html__('Enter label for this restaurant menu item', 'qode-restaurant'),
					'parent'        => $restaurant_menu_meta_box,
					'args'          => array(
						'col_width' => '3'
					)
				)
			);

		}
		add_action('qode_meta_boxes_map', 'qode_restaurant_meta_box_map');
	}
}