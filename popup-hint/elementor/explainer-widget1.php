<?php
class Elementor_Explainer_Widget_1 extends \Elementor\Widget_Base
{

    public function get_name(): string
    {
        return 'explainer_widget_1';
    }

    public function get_title(): string
    {
        return esc_html__('Explainer Pro', 'elementor-addon');
    }

    public function get_icon(): string
    {
        return 'eicon-code';
    }

    public function get_categories(): array
    {
        return ['basic'];
    }

    public function get_keywords(): array
    {
        return ['popup', 'explainer', 'word'];
    }

    protected function register_controls(): void
    {
        $this->start_controls_section(
            'main_text',
            [
                'label' => esc_html__('Main Text', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'main_word',
            [
                'label' => esc_html__('Main Word', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Technical Word', 'textdomain'),
                'placeholder' => esc_html__('Type your text here', 'textdomain'),
            ]
        );

        $this->add_control(
            'main_icon',
            [
                'label' => esc_html__('Main Icon', 'textdomain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'popup_section',
            [
                'label' => esc_html__('Popup Section', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'popup_title',
            [
                'label' => esc_html__('Popup title', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('popup title', 'textdomain'),
                'placeholder' => esc_html__('Type your title here', 'textdomain'),
            ]
        );

        $this->add_control(
            'popup_description',
            [
                'label' => esc_html__('Popup Description', 'textdomain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Egestas purus viverra accumsan in nisl nisi', 'textdomain'),
                'placeholder' => esc_html__('Type your description here', 'textdomain'),
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label' => esc_html__('Close Icon', 'textdomain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'main_word_style',
            [
                'label' => esc_html__('main word', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'main_word_typography',
				'selector' => '{{WRAPPER}} .popup-hint-term',
			]
		);

        $this->add_control(
			'main_word_color',
			[
				'label' => esc_html__( 'Text Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .popup-hint-term' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'main_word_color_hover',
			[
				'label' => esc_html__( 'Text Color Hover', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .popup-hint-term:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'main_word_box_style',
            [
                'label' => esc_html__('main word box', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'main_word_box_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-term' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'main_word_box_gap',
			[
				'label' => esc_html__( 'Gap', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-term' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'main_word_box_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .popup-hint-term',
			]
		);

        $this->add_control(
			'main_word_box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-term' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'main_word_box_border',
				'selector' => '{{WRAPPER}} .popup-hint-term',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'main_word_box_shadow',
				'selector' => '{{WRAPPER}} .popup-hint-term',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'main_word_icon_style',
            [
                'label' => esc_html__('main word icon', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'main_word_icon_size',
			[
				'label' => esc_html__( 'Width', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-term svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'popup_box_style',
            [
                'label' => esc_html__('Popup Box', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'popup_box_position',
			[
				'label' => esc_html__( 'Position', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 'auto',
					'right' => 'auto',
					'bottom' => 'auto',
					'left' => 'auto',
					'unit' => 'custom',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-description' => 'top: {{TOP}}{{UNIT}} !important; right: {{RIGHT}}{{UNIT}} !important; bottom: {{BOTTOM}}{{UNIT}} !important; left: {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

        $this->add_control(
			'popup_box_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'popup_box_border',
				'selector' => '{{WRAPPER}} .popup-hint-description',
			]
		);

        $this->add_control(
			'popup_box_border_radius',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'popup_box_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .popup-hint-description',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'popup_box_shadow',
				'selector' => '{{WRAPPER}} .popup-hint-description',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'popup_box_title_style',
            [
                'label' => esc_html__('Popup Box Title', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .popup-hint-title',
			]
		);

        $this->add_control(
			'popup_box_title_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'popup_box_title_border',
				'selector' => '{{WRAPPER}} .popup-hint-title',
			]
		);

        $this->add_control(
			'popup_box_title_border_radius',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'popup_box_title_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .popup-hint-title',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'popup_box_title_shadow',
				'selector' => '{{WRAPPER}} .popup-hint-title',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'popup_box_desc_style',
            [
                'label' => esc_html__('Popup Box Description', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_desc_typography',
				'selector' => '{{WRAPPER}} .popup-hint-desc-text',
			]
		);

        $this->add_control(
			'popup_box_desc_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-desc-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'popup_box_desc_border',
				'selector' => '{{WRAPPER}} .popup-hint-desc-text',
			]
		);

        $this->add_control(
			'popup_box_desc_border_radius',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 0,
					'bottom' => 2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-hint-desc-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'popup_box_desc_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .popup-hint-desc-text',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'popup_box_title_shadow',
				'selector' => '{{WRAPPER}} .popup-hint-title',
			]
		);

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $hint_id = 'hint-' . wp_rand();
        $settings = $this->get_settings_for_display();
        ?>
        <span class="elementor-explainer popup-hint-term explainer-shortcode" data-hint-id="<?php echo $hint_id ?>">
            <?php \Elementor\Icons_Manager::render_icon($settings['main_icon'], ['aria-hidden' => 'true']);
            echo $settings['main_word']; ?>
        </span>
        <span id="<?php echo $hint_id ?>" class="elementor-explainer popup-hint-description explainer-shortcode">
            <span class="popup-hint-content">
                <span class="popup-hint-close">
                    <?php \Elementor\Icons_Manager::render_icon($settings['close_icon'], ['aria-hidden' => 'true']); ?>
                </span>
                <span class="popup-hint-title">
                    <?php echo $settings['popup_title']; ?>
                </span>
                <span class="popup-hint-desc-text">
                    <?php echo $settings['popup_description']; ?>
                </span>
            </span>
        </span>
        <?php
    }
}