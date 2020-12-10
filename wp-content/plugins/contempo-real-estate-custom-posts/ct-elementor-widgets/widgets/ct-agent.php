<?php
namespace CT_Elementor_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * CT Three Item Grid
 *
 * Elementor widget for listings minimal grid style.
 *
 * @since 1.0.0
 */
class CT_Agent extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ct-agent';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'CT Agent', 'contempo' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-person';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ct-real-estate-7' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'details',
			[
				'label' => __( 'Details', 'contempo' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'name',
			[
				'label' => __( 'Name', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Bill Harwick', 'contempo' ),
				'placeholder' => __( 'Add the agents name here', 'contempo' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Agent', 'contempo' ),
				'placeholder' => __( 'Add the agents title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => 'https://your-link.com',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'View Profile', 'contempo' ),
				'placeholder' => __( 'Add the button text here', 'contempo' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Link
		$target = $settings['link']['is_external'] ? ' target="_blank"' : '	';
		$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';

		echo '<div class="vc-agent">';
			if(!empty($settings['image']['url'])) {
				if(!empty($settings['link']['url'])) {
					echo '<a href="' . $settings['link']['url'] . '"' . $target . $nofollow . '>';
				}
					echo '<figure>';
						echo '<img src="' . $settings['image']['url'] . '" / >';
					echo '</figure>';
				if(!empty($settings['link']['url'])) {
					echo '</a>';
				}
			}
				echo '<div class="vc-agent-info">';

					echo '<header>';
						if(!empty($settings['name'])) {
							if(!empty($settings['link']['url'])) {
								echo '<a href="' . $settings['link']['url'] . '"' . $target . $nofollow . '>';
							}
								echo '<h4>' . $settings['name'] . '</h4>';
							if(!empty($settings['link']['url'])) {
								echo '</a>';
							}
						}
						if(!empty($settings['title'])) {
							echo '<h6 class="muted">' . $settings['title'] . '</h6>';
						}
					echo '</header>';

					if(!empty($settings['description'])) {
						echo '<p>' . $settings['description'] . '</p>';
					}

					if(!empty($settings['link']['url'])) {
						echo '<a class="btn" href="' . $settings['link']['url'] . '"' . $target . $nofollow . '>';
							if(!empty($settings['button_text'])) {
								echo $settings['button_text'];
							} else {
								echo __('View Profile', 'contempo');
							}
						echo '</a>';
					}

				echo '</div>';
			echo '</a>';
		echo '</div>';

	}

}
