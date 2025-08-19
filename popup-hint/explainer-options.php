<?php
/**
 * Lightweight Options Framework for WordPress Plugins
 */

class LightOptions
{
    private $options;
    private $page_title;
    private $menu_title;
    private $capability;
    private $menu_slug;

    public function __construct($page_title, $menu_title, $capability, $menu_slug)
    {
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->menu_slug = $menu_slug;
        $this->options = get_option($menu_slug . '_options', array());

        add_action('admin_menu', array($this, 'add_options_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function add_options_page()
    {
        add_options_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            array($this, 'render_options_page')
        );
    }

    public function register_settings()
    {
        register_setting($this->menu_slug . '_group', $this->menu_slug . '_options');
        
        
    }

    // Add to the enqueue_assets method
public function enqueue_assets($hook) {
    // Only load on our settings page
    if (strpos($hook, $this->menu_slug) === false) {
        return;
    }

    wp_enqueue_media();
    
    // Enqueue minimal CSS
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    
    // Add inline styles for better UI
    $custom_css = "
        .explainer-pro-options-wrapper {
            background: white;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin: 20px 0;
            padding: 20px;
        }
        .explainer-pro-options-header {
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .explainer-pro-options-field {
            margin-bottom: 15px;
            max-width: 600px;
        }
        .explainer-pro-options-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .explainer-pro-options-field input[type='text'],
        .explainer-pro-options-field select,
        .explainer-pro-options-field textarea {
            width: 100%;
        }
        .explainer-pro-options-field p.description {
            font-style: italic;
            color: #666;
            margin: 5px 0 0;
        }
        .explainer-pro-options-tabs {
            display: flex;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .explainer-pro-options-tab {
            padding: 10px 15px;
            cursor: pointer;
            border: 1px solid transparent;
            margin-bottom: -1px;
        }
        .explainer-pro-options-tab.active {
            border: 1px solid #ccc;
            border-bottom-color: white;
            background: white;
        }
        .explainer-pro-options-section {
            display: none;
        }
        .explainer-pro-options-section.active {
            display: block;
        }
        .explainer-pro-options-section h3 {
            margin: 1.5em 0 1em;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .explainer-pro-options-section h3:first-child {
            margin-top: 0;
        }
        .explainer-pro-options-preview {
            background: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .explainer-term-preview {
            display: inline-block;
            cursor: pointer;
            border-bottom: 1px dotted;
        }
        .explainer-box-preview {
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            max-width: 300px;
            margin-top: 10px;
        }
        .explainer-box-title-preview {
            padding: 10px 15px;
            font-weight: bold;
            background: #f7f7f7;
            border-radius: 4px 4px 0 0;
        }
        .explainer-box-desc-preview {
            padding: 10px 15px;
            background: #fff;
            border-radius: 0 0 4px 4px;
        }
    ";
    wp_add_inline_style('wp-color-picker', $custom_css);
    
    // Add minimal JS
    $custom_js = "
        jQuery(document).ready(function($) {
            // Initialize color pickers
            $('.color-picker').wpColorPicker({
                change: function(event, ui) {
                    updatePreview();
                }
            });
            
            // Tab functionality
            $('.explainer-pro-options-tab').click(function() {
                var tab = $(this).data('tab');
                $('.explainer-pro-options-tab').removeClass('active');
                $(this).addClass('active');
                $('.explainer-pro-options-section').removeClass('active');
                $('#' + tab).addClass('active');
            });
            
            // Initialize first tab
            $('.explainer-pro-options-tab:first').click();
            
            // Add preview functionality
            function updatePreview() {
                // Explainer term
                var termFontSize = $('#option_term_font_size').val();
                var termColor = $('#option_term_color').val();
                var termHoverColor = $('#option_term_hover_color').val();
                var iconSize = $('#option_icon_size').val();
                
                // Explainer box
                var boxBgColor = $('#option_box_bg_color').val();
                var boxBorderRadius = $('#option_box_border_radius').val();
                var boxShadow = $('#option_box_shadow').val();
                
                // Title
                var titleFontSize = $('#option_title_font_size').val();
                var titleFontWeight = $('#option_title_font_weight').val();
                var titleBgColor = $('#option_title_bg_color').val();
                var titlePadding = $('#option_title_padding').val();
                var titleBorderRadius = $('#option_title_border_radius').val();
                
                // Description
                var descFontSize = $('#option_desc_font_size').val();
                var descBgColor = $('#option_desc_bg_color').val();
                var descPadding = $('#option_desc_padding').val();
                var descBorderRadius = $('#option_desc_border_radius').val();
                var descColor = $('#option_desc_color').val();
                
                // Apply styles to preview
                $('.explainer-term-preview').css({
                    'font-size': termFontSize,
                    'color': termColor,
                    'cursor': 'pointer'
                });
                
                $('.explainer-term-preview').hover(
                    function() {
                        $(this).css('color', termHoverColor);
                    },
                    function() {
                        $(this).css('color', termColor);
                    }
                );
                
                $('.explainer-box-preview').css({
                    'background-color': boxBgColor,
                    'border-radius': boxBorderRadius,
                    'box-shadow': boxShadow
                });
                
                $('.explainer-box-title-preview').css({
                    'font-size': titleFontSize,
                    'font-weight': titleFontWeight,
                    'background-color': titleBgColor,
                    'padding': titlePadding,
                    'border-radius': titleBorderRadius
                });
                
                $('.explainer-box-desc-preview').css({
                    'font-size': descFontSize,
                    'background-color': descBgColor,
                    'padding': descPadding,
                    'border-radius': descBorderRadius,
                    'color': descColor
                });
            }
            
            // Update preview when any input changes
            $('input, select').on('change input', function() {
                updatePreview();
            });
            
            // Initial preview update
            updatePreview();

            $('.color-picker').wpColorPicker();
            
            $('.light-options-tab').click(function() {
                var tab = $(this).data('tab');
                $('.light-options-tab').removeClass('active');
                $(this).addClass('active');
                $('.light-options-section').removeClass('active');
                $('#' + tab).addClass('active');
            });
            
            $('.light-options-tab:first').click();
            
            // Image upload functionality
            var mediaUploader;
            
            $('.image-upload-button').click(function(e) {
                e.preventDefault();
                
                var button = $(this);
                var targetInput = button.data('target');
                
                // If the uploader object has already been created, reopen the dialog
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                // Create the media uploader
                mediaUploader = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    library: {
                        type: ['image/svg+xml', 'image/jpeg', 'image/jpg', 'image/png']
                    },
                    multiple: false
                });
                
                // When an image is selected, run a callback
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    
                    // Set the image URL in the hidden input
                    $('#' + targetInput).val(attachment.url);
                    
                    // Show the image preview
                    var previewHtml = '<img src=\"' + attachment.url + '\" style=\"max-width: 100px; max-height: 100px; margin-top: 10px;\">';
                    $('#preview_' + targetInput).html(previewHtml);
                    
                    // Show the remove button
                    button.siblings('.image-remove-button').show();
                });
                
                // Open the uploader dialog
                mediaUploader.open();
            });
            
            // Remove image functionality
            $('.image-remove-button').click(function(e) {
                e.preventDefault();
                
                var button = $(this);
                var targetInput = button.data('target');
                
                // Clear the input value
                $('#' + targetInput).val('');
                
                // Clear the preview
                $('#preview_' + targetInput).html('');
                
                // Hide the remove button
                button.hide();
            });
        });

        
    ";
    wp_add_inline_script('wp-color-picker', $custom_js);
}

    public function render_options_page()
    {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html($this->page_title); ?></h1>

            <div class="explainer-pro-options-wrapper">
                <div class="explainer-pro-options-header">
                    <h2><?php _e('Explainer Pro', 'explainer-pro-domain'); ?></h2>
                </div>

                <div class="explainer-pro-options-tabs">
                    <div class="explainer-pro-options-tab active" data-tab="shortcode-gen">
                        <?php _e('Shortcode Generator', 'explainer-pro-domain'); ?>
                    </div>
                    <div class="explainer-pro-options-tab" data-tab="appearance-settings"><?php _e('Appearance', 'explainer-pro-domain'); ?>
                    </div>
                    <div class="explainer-pro-options-tab" data-tab="advanced-settings"><?php _e('Other', 'explainer-pro-domain'); ?></div>
                </div>

                <form method="post" action="options.php">
                    <?php settings_fields($this->menu_slug . '_group'); ?>

                    <div id="shortcode-gen" class="explainer-pro-options-section active">
                        <div class="explainer-pro-options-field">
                            <label for="shortcode_term">Title</label>
                            <input type="text" id="shortcode_term" style="width: 300px;">
                        </div>
                        <div class="explainer-pro-options-field">
                            <label for="shortcode_description">Description</label>
                            <textarea id="shortcode_description" rows="4" cols="50"></textarea>
                        </div>
                        <div class="explainer-pro-options-field">
                            <!-- Output field -->
                            <label for="shortcode_preview">Shortcode</label>
                            <input type="text" id="shortcode_preview" style="width: 100%; background: #f9f9f9;" readonly>
                        </div>
                        <p>Select shortcode and place it inside your content</p>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const termInput = document.getElementById('shortcode_term');
                                const descInput = document.getElementById('shortcode_description');
                                const previewField = document.getElementById('shortcode_preview');

                                function updateShortcode() {
                                    const term = termInput.value.trim().replace(/"/g, '&quot;');
                                    const description = descInput.value.trim().replace(/"/g, '&quot;');
                                    previewField.value = `[popup_hint term="${term}" description="${description}"]`;
                                }

                                termInput.addEventListener('input', updateShortcode);
                                descInput.addEventListener('input', updateShortcode);

                                updateShortcode(); // initial call
                            });
                        </script>


                    </div>

                    <div id="appearance-settings" class="explainer-pro-options-section">
    <h3><?php _e('Button Setting', 'explainer-pro-domain'); ?></h3>
                            <!--- image -->
    <div class="light-options-field">
    <label for="option_explainer_icon"><?php _e('Icon image', 'text-domain'); ?></label>
    <div class="image-upload-wrapper">
        <input type="hidden" id="option_explainer_icon" name="<?php echo $this->menu_slug; ?>_options[explainer_icon]" 
            value="<?php echo esc_attr(isset($this->options['explainer_icon']) ? $this->options['explainer_icon'] : ''); ?>">
        <button type="button" class="button image-upload-button" data-target="option_explainer_icon">
            <?php _e('choose an image', 'text-domain'); ?>
        </button>
        <button type="button" class="button image-remove-button" data-target="option_explainer_icon" style="<?php echo empty($this->options['explainer_icon']) ? 'display:none;' : ''; ?>">
            <?php _e('remove image', 'text-domain'); ?>
        </button>
        <div class="image-preview" id="preview_option_explainer_icon">
            <?php if (!empty($this->options['explainer_icon'])): ?>
                <img src="<?php echo esc_url($this->options['explainer_icon']); ?>" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
            <?php endif; ?>
        </div>
    </div>
    <p class="description"><?php _e('SVG,PNG,JPEG', 'text-domain'); ?></p>
</div>

<!--- image -->
<div class="explainer-pro-options-field">
    <label for="option_term_font_size"><?php _e('Font size', 'explainer-pro-domain'); ?></label>
    <input type="text" id="option_term_font_size" 
           name="<?php echo $this->menu_slug; ?>_options[term_font_size]" 
           value="<?php echo esc_attr(isset($this->options['term_font_size']) ? $this->options['term_font_size'] : '16px'); ?>">
    <p class="description"><?php _e('example => 16px or 1rem', 'explainer-pro-domain'); ?></p>
</div>
    
    <div class="explainer-pro-options-field">
        <label for="option_term_color"><?php _e('Color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_term_color" name="<?php echo $this->menu_slug; ?>_options[term_color]" 
            value="<?php echo esc_attr(isset($this->options['term_color']) ? $this->options['term_color'] : '#007cba'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_term_hover_color"><?php _e('Hover color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_term_hover_color" name="<?php echo $this->menu_slug; ?>_options[term_hover_color]" 
            value="<?php echo esc_attr(isset($this->options['term_hover_color']) ? $this->options['term_hover_color'] : '#00a0d2'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_icon_size"><?php _e('Icon size', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_icon_size" name="<?php echo $this->menu_slug; ?>_options[icon_size]" 
            value="<?php echo esc_attr(isset($this->options['icon_size']) ? $this->options['icon_size'] : '14px'); ?>">
        <p class="description"><?php _e('example => 14px or 1em', 'explainer-pro-domain'); ?></p>
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_term_gap"><?php _e('Gap', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_term_gap" name="<?php echo $this->menu_slug; ?>_options[term_gap]" 
            value="<?php echo esc_attr(isset($this->options['term_gap']) ? $this->options['term_gap'] : '5px'); ?>">
        <p class="description"><?php _e('example => 5px', 'explainer-pro-domain'); ?></p>
    </div>
    
    <h3><?php _e('Explainer Box Setting', 'explainer-pro-domain'); ?></h3>
    <div class="explainer-pro-options-field">
    <label for="option_box_top"><?php _e('Top', 'explainer-pro-domain'); ?></label>
    <input type="text" id="option_box_top" name="<?php echo $this->menu_slug; ?>_options[box_position_top]" value="<?php echo isset($this->options['box_position_top']) ? esc_attr($this->options['box_position_top']) : ''; ?>" />

    <label for="option_box_bottom"><?php _e('Bottom', 'explainer-pro-domain'); ?></label>
    <input type="text" id="option_box_bottom" name="<?php echo $this->menu_slug; ?>_options[box_position_bottom]" value="<?php echo isset($this->options['box_position_bottom']) ? esc_attr($this->options['box_position_bottom']) : ''; ?>" />

    <label for="option_box_right"><?php _e('Right', 'explainer-pro-domain'); ?></label>
    <input type="text" id="option_box_right" name="<?php echo $this->menu_slug; ?>_options[box_position_right]" value="<?php echo isset($this->options['box_position_right']) ? esc_attr($this->options['box_position_right']) : ''; ?>" />

    <label for="option_box_left"><?php _e('Left', 'explainer-pro-domain'); ?></label>
    <input type="text" id="option_box_left" name="<?php echo $this->menu_slug; ?>_options[box_position_left]" value="<?php echo isset($this->options['box_position_left']) ? esc_attr($this->options['box_position_left']) : ''; ?>" />
</div>

    
    <div class="explainer-pro-options-field">
        <label for="option_box_border_radius"><?php _e('Border radius', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_box_border_radius" name="<?php echo $this->menu_slug; ?>_options[box_border_radius]" 
            value="<?php echo esc_attr(isset($this->options['box_border_radius']) ? $this->options['box_border_radius'] : '4px'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_box_padding"><?php _e('Padding', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_box_padding" name="<?php echo $this->menu_slug; ?>_options[box_padding]" 
            value="<?php echo esc_attr(isset($this->options['box_padding']) ? $this->options['box_padding'] : '15px'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_box_bg_color"><?php _e('Background color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_box_bg_color" name="<?php echo $this->menu_slug; ?>_options[box_bg_color]" 
            value="<?php echo esc_attr(isset($this->options['box_bg_color']) ? $this->options['box_bg_color'] : '#ffffff'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_box_shadow"><?php _e('Box shadow', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_box_shadow" name="<?php echo $this->menu_slug; ?>_options[box_shadow]" 
            value="<?php echo esc_attr(isset($this->options['box_shadow']) ? $this->options['box_shadow'] : '0 2px 8px rgba(0,0,0,0.15)'); ?>">
        <p class="description"><?php _e('example => 0 2px 8px rgba(0,0,0,0.15)', 'explainer-pro-domain'); ?></p>
    </div>
    
    <h3><?php _e('Explainer Box Title', 'explainer-pro-domain'); ?></h3>
    <div class="explainer-pro-options-field">
        <label for="option_title_font_size"><?php _e('Font size', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_title_font_size" name="<?php echo $this->menu_slug; ?>_options[title_font_size]" 
            value="<?php echo esc_attr(isset($this->options['title_font_size']) ? $this->options['title_font_size'] : '18px'); ?>">
    </div>

    <div class="explainer-pro-options-field">
        <label for="option_title_color"><?php _e('Color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_title_color" name="<?php echo $this->menu_slug; ?>_options[title_color]" 
            value="<?php echo esc_attr(isset($this->options['title_color']) ? $this->options['title_color'] : '#007cba'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_title_font_weight"><?php _e('Font weight', 'explainer-pro-domain'); ?></label>
        <select id="option_title_font_weight" name="<?php echo $this->menu_slug; ?>_options[title_font_weight]">
            <option value="normal" <?php selected(isset($this->options['title_font_weight']) ? $this->options['title_font_weight'] : '', 'normal'); ?>><?php _e('Normal', 'explainer-pro-domain'); ?></option>
            <option value="bold" <?php selected(isset($this->options['title_font_weight']) ? $this->options['title_font_weight'] : '', 'bold'); ?>><?php _e('Bold', 'explainer-pro-domain'); ?></option>
            <option value="500" <?php selected(isset($this->options['title_font_weight']) ? $this->options['title_font_weight'] : '', '500'); ?>><?php _e('500', 'explainer-pro-domain'); ?></option>
            <option value="600" <?php selected(isset($this->options['title_font_weight']) ? $this->options['title_font_weight'] : '', '600'); ?>><?php _e('600', 'explainer-pro-domain'); ?></option>
            <option value="700" <?php selected(isset($this->options['title_font_weight']) ? $this->options['title_font_weight'] : '', '700'); ?>><?php _e('700', 'explainer-pro-domain'); ?></option>
        </select>
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_title_bg_color"><?php _e('Background color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_title_bg_color" name="<?php echo $this->menu_slug; ?>_options[title_bg_color]" 
            value="<?php echo esc_attr(isset($this->options['title_bg_color']) ? $this->options['title_bg_color'] : '#f7f7f7'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_title_padding"><?php _e('Padding', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_title_padding" name="<?php echo $this->menu_slug; ?>_options[title_padding]" 
            value="<?php echo esc_attr(isset($this->options['title_padding']) ? $this->options['title_padding'] : '10px 15px'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_title_border_radius"><?php _e('Border radius', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_title_border_radius" name="<?php echo $this->menu_slug; ?>_options[title_border_radius]" 
            value="<?php echo esc_attr(isset($this->options['title_border_radius']) ? $this->options['title_border_radius'] : '4px 4px 0 0'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_title_margin"><?php _e('Margin', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_title_margin" name="<?php echo $this->menu_slug; ?>_options[title_margin]" 
            value="<?php echo esc_attr(isset($this->options['title_margin']) ? $this->options['title_margin'] : '0 0 10px 0'); ?>">
    </div>
    
    <h3><?php _e('Explainer Box Description', 'explainer-pro-domain'); ?></h3>
    <div class="explainer-pro-options-field">
        <label for="option_desc_font_size"><?php _e('Font size', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_desc_font_size" name="<?php echo $this->menu_slug; ?>_options[desc_font_size]" 
            value="<?php echo esc_attr(isset($this->options['desc_font_size']) ? $this->options['desc_font_size'] : '14px'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_desc_bg_color"><?php _e('Background color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_desc_bg_color" name="<?php echo $this->menu_slug; ?>_options[desc_bg_color]" 
            value="<?php echo esc_attr(isset($this->options['desc_bg_color']) ? $this->options['desc_bg_color'] : '#ffffff'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_desc_padding"><?php _e('Padding', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_desc_padding" name="<?php echo $this->menu_slug; ?>_options[desc_padding]" 
            value="<?php echo esc_attr(isset($this->options['desc_padding']) ? $this->options['desc_padding'] : '10px 15px'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_desc_border_radius"><?php _e('Border radius', 'explainer-pro-domain'); ?></label>
        <input type="text" id="option_desc_border_radius" name="<?php echo $this->menu_slug; ?>_options[desc_border_radius]" 
            value="<?php echo esc_attr(isset($this->options['desc_border_radius']) ? $this->options['desc_border_radius'] : '0 0 4px 4px'); ?>">
    </div>
    
    <div class="explainer-pro-options-field">
        <label for="option_desc_color"><?php _e('Text color', 'explainer-pro-domain'); ?></label>
        <input type="text" class="color-picker" id="option_desc_color" name="<?php echo $this->menu_slug; ?>_options[desc_color]" 
            value="<?php echo esc_attr(isset($this->options['desc_color']) ? $this->options['desc_color'] : '#333333'); ?>">
    </div>

    <div class="explainer-pro-options-field">
        <label for="option_desc_text_align"><?php _e('Alignment', 'explainer-pro-domain'); ?></label>
        <select id="option_desc_text_align" name="<?php echo $this->menu_slug; ?>_options[desc_text_align]">
            <option value="right" <?php selected(isset($this->options['desc_text_align']) ? $this->options['desc_text_align'] : '', 'right'); ?>><?php _e('right', 'explainer-pro-domain'); ?></option>
            <option value="center" <?php selected(isset($this->options['desc_text_align']) ? $this->options['desc_text_align'] : '', 'center'); ?>><?php _e('center', 'explainer-pro-domain'); ?></option>
            <option value="left" <?php selected(isset($this->options['desc_text_align']) ? $this->options['desc_text_align'] : '', 'left'); ?>><?php _e('left', 'explainer-pro-domain'); ?></option>
            <option value="justify" <?php selected(isset($this->options['desc_text_align']) ? $this->options['desc_text_align'] : '', 'justify'); ?>><?php _e('justify', 'explainer-pro-domain'); ?></option>
        </select>
    </div>
</div>

            <div id="advanced-settings" class="explainer-pro-options-section">
                <div class="explainer-pro-options-field">
                    <label for="option_custom_css"><?php _e('Additional CSS', 'explainer-pro-domain'); ?></label>
                    <textarea id="option_custom_css" name="<?php echo $this->menu_slug; ?>_options[custom_css]"
                        rows="5"><?php echo esc_textarea(isset($this->options['custom_css']) ? $this->options['custom_css'] : ''); ?></textarea>
                </div>
            </div>
            </div>

            

            <?php submit_button(); ?>
            </form>
        </div>
        </div>
        <?php
    }
}

// Usage example:
new LightOptions('Plugin Setting', 'Explainer Pro', 'manage_options', 'explainer_pro');