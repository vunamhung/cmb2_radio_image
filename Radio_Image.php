<?php

namespace vunamhung\cmb2;

class Radio_Image {
	public function __construct() {
		add_action('admin_enqueue_scripts', [$this, 'enqueue']);
		add_action('cmb2_render_radio_image', [$this, 'callback'], 10, 5);
		add_filter('cmb2_list_input_attributes', [$this, 'attributes'], 10, 4);
	}

	public function enqueue() {
		wp_enqueue_style('cmb-tabs', $this->dir_url('css/style.css'), [], '1.0.0');
	}

	public function callback($field, $escaped_value, $object_id, $object_type, $field_type_object) {
		echo $field_type_object->radio();
	}

	public function attributes($args, $defaults, $field, $cmb) {
		if ($field->args['type'] === 'radio_image' && isset($field->args['images'])) {
			foreach ($field->args['images'] as $field_id => $image) {
				if ($field_id === $args['value']) {
					$image = trailingslashit($field->args['images_path']) . $image;
					$args['label'] = sprintf('<img src="%s" alt="%s" title="%s" />', $image, $args['value'], $args['label']);
				}
			}
		}
		return $args;
	}

	protected function dir_url($path) {
		return plugin_dir_url(__FILE__) . $path;
	}
}

new Radio_Image();
