<?php
namespace CT_Elementor_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * CT Six Item Grid
 *
 * Elementor widget for listings minimal grid style.
 *
 * @since 1.0.0
 */
class CT_Modern_Item_Grid extends Widget_Base {

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
		return 'ct-modern-item-grid';
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
		return __( 'CT Modern 6 Item Grid', 'contempo' );
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
		return 'eicon-gallery-grid';
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
			'item_1',
			[
				'label' => __( 'Item 1', 'contempo' ),
			]
		);

		$this->add_control(
			'title_one',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'contempo' ),
				'placeholder' => __( 'Type your title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link_one',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'desciption_one',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->add_control(
			'image_one',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_2',
			[
				'label' => __( 'Item 2', 'contempo' ),
			]
		);

		$this->add_control(
			'title_two',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'contempo' ),
				'placeholder' => __( 'Type your title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link_two',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'desciption_two',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->add_control(
			'image_two',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_3',
			[
				'label' => __( 'Item 3', 'contempo' ),
			]
		);

		$this->add_control(
			'title_three',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'contempo' ),
				'placeholder' => __( 'Type your title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link_three',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'desciption_three',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->add_control(
			'image_three',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_four',
			[
				'label' => __( 'Item 4', 'contempo' ),
			]
		);

		$this->add_control(
			'title_four',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'contempo' ),
				'placeholder' => __( 'Type your title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link_four',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'desciption_four',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->add_control(
			'image_four',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_five',
			[
				'label' => __( 'Item 5', 'contempo' ),
			]
		);

		$this->add_control(
			'title_five',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'contempo' ),
				'placeholder' => __( 'Type your title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link_five',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'desciption_five',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->add_control(
			'image_five',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_six',
			[
				'label' => __( 'Item 6', 'contempo' ),
			]
		);

		$this->add_control(
			'title_six',
			[
				'label' => __( 'Title', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'contempo' ),
				'placeholder' => __( 'Type your title here', 'contempo' ),
			]
		);

		$this->add_control(
			'link_six',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'contempo' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'desciption_six',
			[
				'label' => __( 'Description', 'contempo' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'contempo' ),
				'placeholder' => __( 'Type your description here', 'contempo' ),
			]
		);

		$this->add_control(
			'image_six',
			[
				'label' => __( 'Choose Image', 'contempo' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
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

		// Item One Link
		$target_one = $settings['link_one']['is_external'] ? ' target="_blank"' : '	';
		$nofollow_one = $settings['link_one']['nofollow'] ? ' rel="nofollow"' : '';

		// Item Two Link
		$target_two = $settings['link_two']['is_external'] ? ' target="_blank"' : '	';
		$nofollow_two = $settings['link_two']['nofollow'] ? ' rel="nofollow"' : '';

		// Item Three Link
		$target_three = $settings['link_three']['is_external'] ? ' target="_blank"' : '	';
		$nofollow_three = $settings['link_three']['nofollow'] ? ' rel="nofollow"' : '';

		// Item Four Link
		$target_four = $settings['link_four']['is_external'] ? ' target="_blank"' : '	';
		$nofollow_four = $settings['link_four']['nofollow'] ? ' rel="nofollow"' : '';

		// Item Five Link
		$target_five = $settings['link_five']['is_external'] ? ' target="_blank"' : '	';
		$nofollow_five = $settings['link_five']['nofollow'] ? ' rel="nofollow"' : '';

		// Item Six Link
		$target_six = $settings['link_six']['is_external'] ? ' target="_blank"' : '	';
		$nofollow_six = $settings['link_six']['nofollow'] ? ' rel="nofollow"' : '';

		echo '<ul class="item-grid modern-item-grid">';
			if(!empty($settings['link_one']['url'])) {
			echo '<li class="grid-item col span_4" style="background-image: url(' . $settings['image_one']['url'] . '); background-size: cover;">';			
					echo '<a href="' . $settings['link_one']['url'] . '"' . $target_one . $nofollow_one . '>';
				} else {
					echo '<li class="grid-item col span_4 no-link" style="background-image: url(' . $settings['image_one']['url'] . '); background-size: cover;">';
				}
					//echo '<figure>';
					//	echo '<img src="' . $settings['image_one']['url'] . '" / >';
					//echo '</figure>';
					echo '<div class="grid-item-info">';
						echo '<h4>' . $settings['title_one'] . '</h4>';
						echo '<p>' . $settings['desciption_one'] . '</p>';
					echo '</div>';
				if(!empty($settings['link_one']['url'])) {
					echo '</a>';
				}
			echo '</li>';
			if(!empty($settings['link_two']['url'])) {
			echo '<li class="grid-item col span_4" style="background-image: url(' . $settings['image_two']['url'] . '); background-size: cover;">';
					echo '<a href="' . $settings['link_two']['url'] . '"' . $target_two . $nofollow_two . '>';
				} else {
					echo '<li class="grid-item col span_4 no-link" style="background-image: url(' . $settings['image_two']['url'] . '); background-size: cover;">';
				}
					//echo '<figure>';
					//	echo '<img src="' . $settings['image_two']['url'] . '" / >';
					//echo '</figure>';
					echo '<div class="grid-item-info">';
						echo '<h4>' . $settings['title_two'] . '</h4>';
						echo '<p>' . $settings['desciption_two'] . '</p>';
					echo '</div>';
				if(!empty($settings['link_two']['url'])) {
					echo '</a>';
				}
			echo '</li>';
			if(!empty($settings['link_three']['url'])) {
			echo '<li class="grid-item col span_4" style="background-image: url(' . $settings['image_three']['url'] . '); background-size: cover;">';
					echo '<a href="' . $settings['link_three']['url'] . '"' . $target_three . $nofollow_three . '>';
				} else {
					echo '<li class="grid-item col span_4 no-link" style="background-image: url(' . $settings['image_three']['url'] . '); background-size: cover;">';
				}
					//echo '<figure>';
					//	echo '<img src="' . $settings['image_three']['url'] . '" / >';
					//echo '</figure>';
					echo '<div class="grid-item-info">';
						echo '<h4>' . $settings['title_three'] . '</h4>';
						echo '<p>' . $settings['desciption_three'] . '</p>';
					echo '</div>';
				if(!empty($settings['link_three']['url'])) {
					echo '</a>';
				}
			echo '</li>';
			if(!empty($settings['link_four']['url'])) {
			echo '<li class="grid-item col span_4" style="background-image: url(' . $settings['image_four']['url'] . '); background-size: cover;">';
					echo '<a href="' . $settings['link_four']['url'] . '"' . $target_four . $nofollow_four. '>';
				} else {
					echo '<li class="grid-item col span_4 no-link" style="background-image: url(' . $settings['image_four']['url'] . '); background-size: cover;">';
				}
					//echo '<figure>';
					//	echo '<img src="' . $settings['image_four']['url'] . '" / >';
					//echo '</figure>';
					echo '<div class="grid-item-info">';
						echo '<h4>' . $settings['title_four'] . '</h4>';
						echo '<p>' . $settings['desciption_four'] . '</p>';
					echo '</div>';
				if(!empty($settings['link_four']['url'])) {
					echo '</a>';
				}
			echo '</li>';
			if(!empty($settings['link_five']['url'])) {
			echo '<li class="grid-item col span_4" style="background-image: url(' . $settings['image_five']['url'] . '); background-size: cover;">';
					echo '<a href="' . $settings['link_five']['url'] . '"' . $target_five . $nofollow_five . '>';
				} else {
					echo '<li class="grid-item col span_4 no-link" style="background-image: url(' . $settings['image_five']['url'] . '); background-size: cover;">';
				}
					//echo '<figure>';
					//	echo '<img src="' . $settings['image_five']['url'] . '" / >';
					//echo '</figure>';
					echo '<div class="grid-item-info">';
						echo '<h4>' . $settings['title_five'] . '</h4>';
						echo '<p>' . $settings['desciption_five'] . '</p>';
					echo '</div>';
				if(!empty($settings['link_five']['url'])) {
					echo '</a>';
				}
			echo '</li>';
			if(!empty($settings['link_six']['url'])) {
			echo '<li class="grid-item col span_4" style="background-image: url(' . $settings['image_six']['url'] . '); background-size: cover;">';
					echo '<a href="' . $settings['link_six']['url'] . '"' . $target_six . $nofollow_six . '>';
				} else {
					echo '<li class="grid-item col span_4 no-link" style="background-image: url(' . $settings['image_six']['url'] . '); background-size: cover;">';
				}
					//echo '<figure>';
					//	echo '<img src="' . $settings['image_six']['url'] . '" / >';
					//echo '</figure>';
					echo '<div class="grid-item-info">';
						echo '<h4>' . $settings['title_six'] . '</h4>';
						echo '<p>' . $settings['desciption_six'] . '</p>';
					echo '</div>';
				if(!empty($settings['link_six']['url'])) {
					echo '</a>';
				}
			echo '</li>';
				echo '<div class="clear"></div>';
		echo '</ul>';	

	}

}
