<?php
use QodeListing\Lib\Shortcodes;
if(!function_exists('qode_listing_banner_shortcode_helper')) {
	function qode_listing_banner_shortcode_helper($shortcodes_class_name) {

		$shortcodes = array(
			'QodeListing\Lib\Shortcodes\ListingBanner'
		);

		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

		return $shortcodes_class_name;
	}

	add_filter('qode_listing_filter_add_vc_shortcode', 'qode_listing_banner_shortcode_helper');
}


if(!function_exists('qode_listing_banner_instance')){

	function qode_listing_banner_instance(){
		return Shortcodes\ListingBanner::getInstance();
	}

}

if( !function_exists('qode_listing_set_ls_banner_icon_class_name_for_vc_shortcodes') ) {
	/**
	 * Function that set custom icon class name for button shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function qode_listing_set_ls_banner_icon_class_name_for_vc_shortcodes($shortcodes_icon_class_array) {
		$shortcodes_icon_class_array[] = '.icon-wpb-ls-banner';

		return $shortcodes_icon_class_array;
	}

	add_filter('qode_core_filter_add_vc_shortcodes_custom_icon_class', 'qode_listing_set_ls_banner_icon_class_name_for_vc_shortcodes');
}