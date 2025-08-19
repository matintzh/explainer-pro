<?php

function register_explainer_widget( $widgets_manager ) {

	require_once( __DIR__ . '/explainer-widget1.php' );

	$widgets_manager->register( new \Elementor_Explainer_Widget_1() );

}
add_action( 'elementor/widgets/register', 'register_explainer_widget' );