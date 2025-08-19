<?php
/**
 * Plugin Name: Popup Hint Feature
 * Description: Adds a popup hint feature for technical terms in your blog posts
 * Version: 1.0
 * Author: matin sabernezhad
 */

if (!defined('ABSPATH')) {
    exit;
}

class Popup_Hint_Feature
{

    public function __construct()
    {
        add_shortcode('popup_hint', array($this, 'popup_hint_shortcode'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));

        add_action('admin_init', array($this, 'setup_tinymce_plugin'));

        add_action('wp_ajax_create_popup_hint', array($this, 'create_popup_hint_callback'));
    }

    public function popup_hint_shortcode($atts, $content = null)
    {
        $atts = shortcode_atts(array(
            'term' => '',
            'description' => '',
        ), $atts, 'popup_hint');

        $options = get_option('explainer_pro_options', array());

        $hint_id = 'hint-' . wp_rand();
        $icon_url = $options['explainer_icon'];
        $icon_img = null;
        if($icon_url){
            $icon_img = '<img src="' . $icon_url . '">';
        }
        $output = '<span class="static-explainer popup-hint-term explainer-shortcode" data-hint-id="' . esc_attr($hint_id) . '">' . $icon_img . esc_html($atts['term']) . '</span>';
        $output .= '<span id="' . esc_attr($hint_id) . '" class="static-explainer popup-hint-description explainer-shortcode">';
        $output .= '<span class="popup-hint-content">';
        $output .= '<span class="popup-hint-close">&times;</span>';
        $output .= '<span class="popup-hint-title">' . esc_html($atts['term']) . '</span>';
        $output .= '<span class="desc">' . wp_kses_post($atts['description']) . '</span>';
        $output .= '</span></span>';

        return $output;
    }

    public function enqueue_frontend_assets()
{
        wp_enqueue_style(
            'popup-hint-style',
            plugin_dir_url(__FILE__) . '/popup-hint.css',
            array(),
            '1.0.6'
        );

        // Dynamic CSS
        $custom_css = $this->generate_dynamic_css();
        wp_add_inline_style('popup-hint-style', $custom_css);

        wp_enqueue_script(
            'popup-hint-script',
            plugin_dir_url(__FILE__) . '/popup-hint.js',
            array('jquery'),
            '1.0.2',
            true
        );

}

public function generate_dynamic_css()
{
    $options = get_option('explainer_pro_options', array());
    
    $term_font_size = $options['term_font_size'];
    $term_color = $options['term_color'];
    $term_hover = $options['term_hover_color'];
    $term_icon_size = $options['icon_size'];
    $term_gap = $options['term_gap'];

    $desc_box_position_top = $options['box_position_top'];
    $desc_box_position_bottom = $options['box_position_bottom'];
    $desc_box_position_right = $options['box_position_right'];
    $desc_box_position_left = $options['box_position_left'];
    $desc_box_border_radius = $options['box_border_radius'];
    $desc_box_padding = $options['box_padding'];
    $desc_box_background_color = $options['box_bg_color'];
    $desc_box_box_shadow = $options['box_shadow'];

    $desc_title_font_size = $options['title_font_size'];
    $desc_title_font_weight = $options['title_font_weight'];
    $desc_title_background = $options['title_bg_color'];
    $desc_title_padding = $options['title_padding'];
    $desc_title_border_radius = $options['title_border_radius'];
    $desc_title_margin = $options['title_margin'];
    $desc_title_color = $options['title_color'];

    $desc_text_font_size = $options['desc_font_size'];
    $desc_text_color = $options['desc_color'];
    $desc_text_padding = $options['desc_padding'];
    $desc_text_border_radius = $options['desc_border_radius'];
    $desc_text_background_color = $options['desc_bg_color'];
    $desc_text_align = $options['desc_text_align'];

    $explainer_custom_css = $$options['explainer_custom_css'];


    return "
    .static-explainer.popup-hint-term {
    font-size: {$term_font_size};
    color: {$term_color};
}
    .static-explainer.popup-hint-term:hover{
    color: {$term_hover};
    }
    .static-explainer.popup-hint-term img{
    width: {$term_icon_size};
    margin-left: {$term_gap};
    }
        .static-explainer.popup-hint-description {
            top: {$desc_box_position_top} !important;
            bottom: {$desc_box_position_bottom} !important;
            right: {$desc_box_position_right} !important;
            left: {$desc_box_position_left} !important;
            border-radius: {$desc_box_border_radius} !important;
            padding: {$desc_box_padding} !important;
            background-color: {$desc_box_background_color} !important;
            box-shadow: {$desc_box_box_shadow} !important;
        }
        .static-explainer .popup-hint-title {
            font-size: {$desc_title_font_size};
            font-weight: {$desc_title_font_weight};
            background: {$desc_title_background};
            padding: {$desc_title_padding};
            border-radius: {$desc_title_border_radius};
            margin: {$desc_title_margin};
            color: {$desc_title_color};
        }
        .static-explainer.popup-hint-description .desc{
            font-size:{$desc_text_font_size};
            color: {$desc_text_color};
            padding: {$desc_text_padding};
            border-radius: {$desc_text_border_radius};
            background-color: {$desc_text_background_color};
            text-align: {$desc_text_align};
        }
{$explainer_custom_css}


    ";
}

    public function setup_tinymce_plugin()
    {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        add_filter('mce_external_plugins', array($this, 'add_tinymce_plugin'));
        add_filter('mce_buttons', array($this, 'register_tinymce_button'));
        
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function add_tinymce_plugin($plugin_array)
    {
        $plugin_array['popup_hint_button'] = plugin_dir_url(__FILE__) . 'popup-hint-editor.js';
        return $plugin_array;
    }


    public function register_tinymce_button($buttons)
    {
        array_push($buttons, 'popup_hint_button');
        return $buttons;
    }


    public function enqueue_admin_assets()
    {
        wp_enqueue_style(
            'popup-hint-admin-style',
             plugin_dir_url( __FILE__ ) . '/popup-hint-admin.css',
            array(),
            '1.0'
        );

        wp_enqueue_script(
            'popup-hint-admin-script',
            plugin_dir_url( __FILE__ ) . '/popup-hint-admin.js',
            array('jquery'),
            '1.0',
            true
        );

        wp_localize_script('popup-hint-admin-script', 'popupHintData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('popup_hint_nonce')
        ));
    }


    public function create_popup_hint_callback()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'popup_hint_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        $term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
        $description = isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '';

        if (empty($term) || empty($description)) {
            wp_send_json_error('Please fill in both fields');
        }

        $shortcode = '[popup_hint term="' . esc_attr($term) . '" description="' . esc_attr($description) . '"]';

        wp_send_json_success(array('shortcode' => $shortcode));
    }
}

$popup_hint_feature = new Popup_Hint_Feature();

function popup_hint_check_directories()
{
    $child_theme_dir = plugin_dir_path(__FILE__);
    $popup_hint_dir = $child_theme_dir . '/popup-hint';

    if (!file_exists($popup_hint_dir)) {
        wp_mkdir_p($popup_hint_dir);
    }
}
register_activation_hook(__FILE__, 'popup_hint_check_directories');


require_once __DIR__ .  '/elementor/registration.php';
