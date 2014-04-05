<?php
/**
 * @package ttf-one
 */

/**
 * @param $type
 *
 * @return bool
 */
function ttf_one_builder_is_section_type( $type ) {
	global $ttf_one_section_data;

	if ( isset( $ttf_one_section_data['section-type'] ) && $type === $ttf_one_section_data['section-type'] ) {
		return true;
	}

	return false;
}

/**
 * @param $ttf_one_section_data
 *
 * @return array
 */
function ttf_one_builder_get_gallery_array( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'gallery' ) ) {
		return array();
	}

	$gallery_order = array();
	if ( isset( $ttf_one_section_data['gallery-item-order'] ) ) {
		$gallery_order = $ttf_one_section_data['gallery-item-order'];
	}

	$gallery_items = array();
	if ( isset( $ttf_one_section_data['gallery-items'] ) ) {
		$gallery_items = $ttf_one_section_data['gallery-items'];
	}

	$gallery_array = array();
	if ( ! empty( $gallery_order ) && ! empty( $gallery_items ) ) {
		foreach ( $gallery_order as $order => $key ) {
			$gallery_array[$order] = $gallery_items[$key];
		}
	}

	return $gallery_array;
}

/**
 * @param $ttf_one_section_data
 *
 * @return string
 */
function ttf_one_builder_get_gallery_class( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'gallery' ) ) {
		return '';
	}

	$gallery_class = ' ';

	// Section classes
	$gallery_class .= ttf_one_get_builder_save()->section_classes( $ttf_one_section_data );

	// Columns
	$gallery_columns = ( isset( $ttf_one_section_data['columns'] ) ) ? absint( $ttf_one_section_data['columns'] ) : 1;
	$gallery_class .= ' builder-gallery-columns-' . $gallery_columns;

	// Captions
	if ( isset( $ttf_one_section_data['captions'] ) && ! empty( $ttf_one_section_data['captions'] ) ) {
		$gallery_class .= ' builder-gallery-captions-' . $ttf_one_section_data['captions'];
	}

	return $gallery_class;
}

/**
 * @param $ttf_one_section_data
 *
 * @return string
 */
function ttf_one_builder_get_gallery_style( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'gallery' ) ) {
		return '';
	}

	$gallery_style = '';

	// Background color
	if ( isset( $ttf_one_section_data['background-color'] ) && ! empty( $ttf_one_section_data['background-color'] ) ) {
		$gallery_style .= 'background-color:' . maybe_hash_hex_color( $ttf_one_section_data['background-color'] ) . ';';
	}

	// Background image
	if ( isset( $ttf_one_section_data['background-image'] ) && 0 !== absint( $ttf_one_section_data['background-image'] ) ) {
		$image_src = wp_get_attachment_image_src( $ttf_one_section_data['background-image'], 'full' );
		if ( isset( $image_src[0] ) ) {
			$gallery_style .= 'background-image: url(\'' . addcslashes( esc_url_raw( $image_src[0] ), '"' ) . '\');';
		}
	}

	return $gallery_style;
}

/**
 * @param $ttf_one_section_data
 *
 * @return array
 */
function ttf_one_builder_get_text_array( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'text' ) ) {
		return array();
	}

	$columns_number = ( isset( $ttf_one_section_data['columns-number'] ) ) ? absint( $ttf_one_section_data['columns-number'] ) : 1;

	$columns_order = array();
	if ( isset( $ttf_one_section_data['columns-order'] ) ) {
		$columns_order = $ttf_one_section_data['columns-order'];
	}

	$columns_data = array();
	if ( isset( $ttf_one_section_data['columns'] ) ) {
		$columns_data = $ttf_one_section_data['columns'];
	}

	$columns_array = array();
	if ( ! empty( $columns_order ) && ! empty( $columns_data ) ) {
		$count = 0;
		foreach ( $columns_order as $order => $key ) {
			$columns_array[$order] = $columns_data[$key];
			$count++;
			if ( $count >= $columns_number ) {
				break;
			}
		}
	}

	return $columns_array;
}

/**
 * @param $ttf_one_section_data
 *
 * @return string
 */
function ttf_one_builder_get_text_class( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'text' ) ) {
		return '';
	}

	$text_class = ' ';

	// Section classes
	$text_class .= ttf_one_get_builder_save()->section_classes( $ttf_one_section_data );

	// Columns
	$columns_number = ( isset( $ttf_one_section_data['columns-number'] ) ) ? absint( $ttf_one_section_data['columns-number'] ) : 1;
	$text_class .= ' builder-text-columns-' . $columns_number;

	return $text_class;
}

/**
 * @param $ttf_one_section_data
 *
 * @return array
 */
function ttf_one_builder_get_banner_array( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'banner' ) ) {
		return array();
	}

	$banner_order = array();
	if ( isset( $ttf_one_section_data['banner-slide-order'] ) ) {
		$banner_order = $ttf_one_section_data['banner-slide-order'];
	}

	$banner_slides = array();
	if ( isset( $ttf_one_section_data['banner-slides'] ) ) {
		$banner_slides = $ttf_one_section_data['banner-slides'];
	}

	$banner_array = array();
	if ( ! empty( $banner_order ) && ! empty( $banner_slides ) ) {
		foreach ( $banner_order as $order => $key ) {
			$banner_array[$order] = $banner_slides[$key];
		}
	}

	return $banner_array;
}

/**
 * @param array $ttf_one_section_data
 *
 * @return string
 */
function ttf_one_builder_get_banner_slider_atts( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'banner' ) ) {
		return '';
	}

	$atts = shortcode_atts( array(
		'height'     => 500,
		'autoplay'   => true,
		'transition' => 'fade',
		'delay'      => 4000
	), $ttf_one_section_data );

	// Data attributes
	$data_attributes = ' data-cycle-log="true"';
	$data_attributes .= ' data-cycle-slides="div.builder-banner-slide"';

	// Height / Aspect ratio
	$height = absint( $atts['height'] );
	if ( 0 === $height ) {
		$height = 500;
	}
	$data_attributes .= ' data-cycle-auto-height="960:' . $height . '"';

	// Autoplay
	$autoplay = (bool) $atts['autoplay'];
	if ( false === $autoplay ) {
		$data_attributes .= ' data-cycle-paused="true"';
	}

	// Delay
	$delay = absint( $atts['delay'] );
	if ( 0 === $delay ) {
		$delay = 4000;
	}
	if ( 4000 !== $delay ) {
		$data_attributes .= ' data-cycle-timeout="' . esc_attr( $delay ) . '"';
	}

	// Effect
	$effect = trim( $atts['transition'] );
	if ( ! in_array( $effect, array( 'fade', 'fadeout', 'scrollHorz', 'none' ) ) ) {
		$effect = 'fade';
	}
	if ( 'fade' !== $effect ) {
		$data_attributes .= ' data-cycle-fx="' . esc_attr( $effect ) . '"';
	}

	return $data_attributes;
}

/**
 * @param array $slide
 *
 * @return string
 */
function ttf_one_builder_banner_slide_class( $slide ) {
	$slide_class = '';

	// Content position
	if ( isset( $slide['alignment'] ) && '' !== $slide['alignment'] ) {
		$slide_class .= ' ' . sanitize_html_class( 'content-position-' . $slide['alignment'] );
	}

	return $slide_class;
}

/**
 * @param array $slide
 * @param array $ttf_one_section_data
 *
 * @return string
 */
function ttf_one_builder_banner_slide_style( $slide, $ttf_one_section_data ) {
	$slide_style = '';

	// Background color
	if ( isset( $slide['background-color'] ) && '' !== $slide['background-color'] ) {
		$slide_style .= 'background-color:' . maybe_hash_hex_color( $slide['background-color'] ) . ';';
	}

	// Background image
	if ( isset( $slide['image-id'] ) && 0 !== absint( $slide['image-id'] ) ) {
		$image_src = wp_get_attachment_image_src( $slide['image-id'], 'full' );
		if ( isset( $image_src[0] ) ) {
			$slide_style .= 'background-image: url(\'' . addcslashes( esc_url_raw( $image_src[0] ), '"' ) . '\');';
		}
	}

	// Height
	$height = absint( $ttf_one_section_data['height'] );
	if ( 0 === $height ) {
		$height = 500;
	}
	$ratio = ( $height / 960 ) * 100;
	$slide_style .= 'padding-bottom:' . $ratio . '%;';

	return esc_attr( $slide_style );
}