<?php

namespace greenshiftaddon\Blocks;

defined('ABSPATH') or exit;


class GspbMap
{

	public function __construct()
	{
		add_action('init', array($this, 'init_handler'));
	}

	public function init_handler()
	{
		register_block_type(
			__DIR__,
			array(
				'render_callback' => array($this, 'render_block'),
				'attributes'      => $this->attributes
			)
		);
	}

	public $attributes = array(
		'id' => array(
			'type'    => 'string',
			'default' => null,
		),
		'inlineCssStyles' => array(
			'type'    => 'string',
			'default' => '',
		),
		'animation' => array(
			'type' => 'object',
			'default' => array(),
		),
		'maptype' => array(
			'type' => 'string',
			'default' => 'osmap',
		),
		'zoomlevel' => array(
			'type'    => 'number',
			'default' => 12,
		),
		'googleapikey' => array(
			'type'    => 'string',
			'default' => '',
		),
		'markers' => array(
			'type' => 'array',
			'default' => array(
				array(
					'lat' => 51.487397,
					'lang' => -0.0304748,
					'title' => "",
					'description' => "",
					'icon' => "",
					'iconwidth' => 32,
					'iconheight' => 32,
					'icontype' => 'font',
					'isCustomIcon' => false,
					'iconBox_icon' => array(),
					'dynamicEnable' => false,
					'dynamicField' => ''
				)
			)
		),
		'center_index' => array(
			'type' => 'number',
			'default' => 0
		),
		'mapstyleJSON' => array(
			'type' => 'string',
			'default' => ''
		),
	);

	public function render_block($settings = array(), $inner_content = '')
	{
		extract($settings);

		$blockId = 'gspb_id-' . esc_attr($id);
		$blockClassName = $blockId;
		$blockMapId = 'gspb_map-' . esc_attr($id).'';

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => $blockClassName,
			)
		);

		$markers = !empty($settings['markers']) ? $settings['markers'] : array();

		if (!empty($markers)) {
			global $post;
			$postid = '';
			if (is_object($post)) {
				$postid = $post->ID;
			}
			foreach ($markers as $key => $marker) {
				if (!empty($marker['dynamicEnable']) && !empty($marker['dynamicField']) && $postid) {
					$field = esc_attr($marker['dynamicField']);
					$result = GSPB_get_custom_field_value($postid, $field, 'flatarray');
					if(is_string($result) && is_array(json_decode($result, true))){
						$result = json_decode($result, true);
					}
					if (is_array($result)) {
						if (isset($result['location']) && isset($result['location']['lat']) && isset($result['location']['lng'])) {
							$markers[$key]['lat'] = esc_attr($result['location']['lat']);
							$markers[$key]['lng'] = esc_attr($result['location']['lng']);
							$markers[$key]['lang'] = esc_attr($result['location']['lng']);
							$markers[$key]['title'] = !empty($result['title']) ? esc_attr($result['title']) : '';
							$description = !empty($result['description']) ? wp_strip_all_tags($result['description']) : '';
							$address = !empty($result['address']) ? wp_strip_all_tags($result['address']) : '';
							$markers[$key]['description'] = $description ? $description : $address;
						} else if (isset($result['lat']) && isset($result['lng'])) {
							$markers[$key]['lat'] = esc_attr($result['lat']);
							$markers[$key]['lng'] = esc_attr($result['lng']);
							$markers[$key]['lang'] = esc_attr($result['lng']);
							$description = !empty($result['description']) ? wp_strip_all_tags($result['description']) : '';
							$address = !empty($result['address']) ? wp_strip_all_tags($result['address']) : '';
							$markers[$key]['description'] = $description ? $description : $address;
						} else if (isset($result['latitude']) && isset($result['longitude'])) {
							$markers[$key]['lat'] = esc_attr($result['latitude']);
							$markers[$key]['lng'] = esc_attr($result['longitude']);
							$markers[$key]['lang'] = esc_attr($result['longitude']);
							$description = !empty($result['description']) ? wp_strip_all_tags($result['description']) : '';
							$address = !empty($result['address']) ? wp_strip_all_tags($result['address']) : '';
							$markers[$key]['description'] = $description ? $description : $address;
						}
					}
				}
			}
		}

		$localizeArray = array(
			'zoomlevel' => $settings['zoomlevel'],
			'markers' => $markers,
			'center_index' => $settings['center_index'],
		);

		if(!empty($settings['mapstyleJSON'])){
			$localizeArray['styles'] = json_decode($settings['mapstyleJSON']);
		}

		$maptype = esc_attr($settings['maptype']);

		wp_localize_script('gspb_map', str_replace('-', '_', $blockId), $localizeArray);

		$out = '<div ' . $wrapper_attributes . '' . gspb_AnimationRenderProps($animation) . '>';
		$out .= '<div data-key="' . str_replace('-', '_', $blockId) . '" class="gspb_map-wrapper gspb_' . $maptype . '" id="' . $blockMapId . '"></div>';
		$out .= '</div>';

		return $out;
	}
}

new GspbMap;
