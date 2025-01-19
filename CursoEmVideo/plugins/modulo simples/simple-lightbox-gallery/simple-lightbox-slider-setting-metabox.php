<?php
/**
 * Load Saved Lightbox Slider Pro Settings
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$PostId                = $post->ID;
$SLGF_Gallery_Settings = "SLGF_Gallery_Settings_" . $PostId;
$SLGF_Settings         = unserialize( get_post_meta( $PostId, $SLGF_Gallery_Settings, true ) );
if ( is_array($SLGF_Settings) && $SLGF_Settings['SLGF_Hover_Animation'] && $SLGF_Settings['SLGF_Gallery_Layout'] ) {

	$SLGF_Show_Gallery_Title  = $SLGF_Settings['SLGF_Show_Gallery_Title'];
	$SLGF_Show_Image_Label    = $SLGF_Settings['SLGF_Show_Image_Label'];
	$SLGF_Hover_Animation     = $SLGF_Settings['SLGF_Hover_Animation'];
	$SLGF_Gallery_Layout      = $SLGF_Settings['SLGF_Gallery_Layout'];
	$SLGF_Thumbnail_Layout    = $SLGF_Settings['SLGF_Thumbnail_Layout'];
	$SLGF_Hover_Color         = $SLGF_Settings['SLGF_Hover_Color'];
	$SLGF_Text_BG_Color       = $SLGF_Settings['SLGF_Text_BG_Color'];
	$SLGF_Text_Color          = $SLGF_Settings['SLGF_Text_Color'];
	$lk_show_img_desc         = $SLGF_Settings['lk_show_img_desc'];
	$SLGF_Hover_Color_Opacity = $SLGF_Settings['SLGF_Hover_Color_Opacity'];
	$SLGF_Font_Style          = $SLGF_Settings['SLGF_Font_Style'];
	$SLGF_Box_Shadow          = $SLGF_Settings['SLGF_Box_Shadow'];
	$SLGF_Custom_CSS          = $SLGF_Settings['SLGF_Custom_CSS'];
    $SLGF_open_link           = $SLGF_Settings['SLGF_open_link'];
    $SLGF_label_Color         = $SLGF_Settings['SLGF_label_Color'];
    $SLGF_desc_font_Color     = $SLGF_Settings['SLGF_desc_font_Color'];
    $SLGF_btn_Color           = $SLGF_Settings['SLGF_btn_Color'];
    $SLGF_btn_font_Color      = $SLGF_Settings['SLGF_btn_font_Color'];
    $SLGF_button_title        = $SLGF_Settings['SLGF_button_title'];
    $SLGF_Light_Box           = $SLGF_Settings['SLGF_Light_Box'];
    $SLGF_title_Color         = (array_key_exists("SLGF_title_Color",$SLGF_Settings)) ? $SLGF_Settings['SLGF_title_Color'] : '#2271b1';
} else { 
	$SLGF_Show_Gallery_Title  = "yes";
	$SLGF_Show_Image_Label    = "yes";
	$SLGF_Hover_Animation     = "stripe";
	$SLGF_Gallery_Layout      = "col-md-6";
	$SLGF_Thumbnail_Layout    = "same-size";
	$SLGF_Hover_Color         = "#0AC2D2";
	$SLGF_Text_BG_Color       = "#FFFFFF";
	$lk_show_img_desc         = "Yes";
	$SLGF_Text_Color          = "#000000";
	$SLGF_Hover_Color_Opacity = "yes";
	$SLGF_Font_Style          = "font-name";
	$SLGF_Box_Shadow          = "yes";
	$SLGF_Custom_CSS          = "";
    $SLGF_open_link           = "_blank";
    $SLGF_label_Color         = "#000000";
    $SLGF_desc_font_Color     = "#000000";
    $SLGF_btn_Color           = "#31a3dd";
    $SLGF_btn_font_Color      = "#FFFFFF";
    $SLGF_button_title        = "Zoom";
    $SLGF_Light_Box           = "lightbox3";
    $SLGF_title_Color         = "#2271b1";
}
?>
<?php
wp_register_script( 'slg_slider_settings_script', false );
wp_enqueue_script( 'slg_slider_settings_script' );
$js = " ";
ob_start(); ?>
    jQuery(document).ready(function () {
        slgf_icon_settings();
        codemirror();
    });

    function slgf_icon_settings() {
        if (jQuery('#wl-view-lightbox').is(":checked")) {
            jQuery('.slgf-icon-settings').show();
        } else {
            jQuery('.slgf-icon-settings').hide();
        }
    }

    function codemirror() {
        var editor = CodeMirror.fromTextArea(document.getElementById("wl-custom-css"), {
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            hint: true,
            theme: 'blackboard',
            lineWrapping: true,
            extraKeys: {"Ctrl-Space": "autocomplete"},
        });
    }
<?php
$js .= ob_get_clean();
wp_add_inline_script( 'slg_slider_settings_script', $js ); ?>

<?php
wp_register_style( 'slg_slider_settings_style', false );
wp_enqueue_style( 'slg_slider_settings_style' );
$css = " ";
ob_start(); ?>
    .custnote {
        background-color: rgba(23, 31, 22, 0.64);
        color: #fff;
        width: 325px;
        border-radius: 5px;
        padding-right: 5px;
        padding-left: 5px;
        padding-top: 2px;
        padding-bottom: 2px;
    }
<?php
$css .= ob_get_clean();
wp_add_inline_style( 'slg_slider_settings_style', $css ); ?>

<div class="lbs_setting"><?php esc_html_e( "Lightbox Slider Settings", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></div>
<?php $nonce = wp_create_nonce( 'nonce_save_settings_option' ); ?>
<input type="hidden" name="security" value="<?php echo esc_attr( $nonce ); ?>">
<input type="hidden" id="slgf_save_action" name="slgf_save_action" value="slgf-save-settings">
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row"><label><?php esc_html_e( "Show Gallery Title", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Show_Gallery_Title == "" ) {
				$SLGF_Show_Gallery_Title = "yes";
			} ?>
            <input type="radio" name="wl-show-gallery-title" id="wl-show-gallery-title"
                   value="yes" <?php if ( $SLGF_Show_Gallery_Title == 'yes' ) {
				echo "checked";
			} ?>> <i class="fa fa-check fa-2x"></i>
            <input type="radio" name="wl-show-gallery-title" id="wl-show-gallery-title"
                   value="no" <?php if ( $SLGF_Show_Gallery_Title == 'no' ) {
				echo "checked";
			} ?>> <i class="fa fa-times fa-2x"></i>
            <p class="description"><?php esc_html_e( "Select Yes/No option to hide or show gallery title", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                . </p>
        </td>     
    </tr>
    <tr>
         <th scope="row"><label><?php esc_html_e( 'Galler Title Color', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="text" name="SLGF_title_Color" id="SLGF_title_Color" value="<?php esc_html_e($SLGF_title_Color); ?>" class="my-color-field" data-default-color="#2271b1" />
            </p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label><?php esc_html_e( "Show Image Label", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Show_Image_Label == "" ) {
				$SLGF_Show_Image_Label = "yes";
			} ?>
            <input type="radio" name="wl-show-image-label" id="wl-show-image-label"
                   value="yes" <?php if ( $SLGF_Show_Image_Label == 'yes' ) {
				echo "checked";
			} ?>> <i class="fa fa-check fa-2x"></i>
            <input type="radio" name="wl-show-image-label" id="wl-show-image-label"
                   value="no" <?php if ( $SLGF_Show_Image_Label == 'no' ) {
				echo "checked";
			} ?>> <i class="fa fa-times fa-2x"></i>
            <p class="description"><?php esc_html_e( "Select Yes/No option to hide or show label on image", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                .</p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( 'Open Link', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="radio" name="SLGF_open_link" id="SLGF_open_link" value="_self" <?php if ( $SLGF_open_link == '_self' ) {
                echo "checked";
            } ?>> <?php esc_html_e( 'In Same Tab', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
            <input type="radio" name="SLGF_open_link" id="SLGF_open_link" value="_blank" <?php if ( $SLGF_open_link == '_blank' ) {
                echo "checked";
            } ?>> <?php esc_html_e( 'In New Tab', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
            <p class="description">
                <?php esc_html_e( 'Select option to open link in save tab or in new tab', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>.
            </p>
        </td>
    </tr>

    <tr>
        <th><label><?php esc_html_e( 'Image Label Color', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="text" name="SLGF_label_Color" id="SLGF_label_Color" value="<?php esc_html_e($SLGF_label_Color); ?>" class="my-color-field" data-default-color="#000000" />
            </p>
        </td>
    </tr>
    <tr>
        <th><label><?php esc_html_e( 'Description Font Color', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="text" name="SLGF_desc_font_Color" id="SLGF_desc_font_Color" value="<?php esc_html_e($SLGF_desc_font_Color); ?>" class="my-color-field" data-default-color="#000000" />
        </td>
    </tr>
    <tr>
        <th><label><?php esc_html_e( 'Image Link Background Color', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="text" name="SLGF_btn_Color" id="SLGF_btn_Color"  value="<?php esc_html_e( $SLGF_btn_Color); ?>" class="my-color-field" data-default-color="#31a3dd" />
        </td>
    </tr>
    <tr>
        <th><label><?php esc_html_e( 'Image Link Font Color', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="text" name="SLGF_btn_font_Color" id="SLGF_btn_font_Color"  value="<?php esc_html_e( $SLGF_btn_font_Color); ?>" class="my-color-field" data-default-color="#31a3dd" />
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( 'Image Link Title', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>

            <input type="text" name="SLGF_button_title" id="SLGF_button_title" value="<?php echo esc_attr( $SLGF_button_title ); ?>"/>
            <p class="description">
                <?php esc_html_e( 'Write button title', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>.
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( 'Light Box Styles', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <select name="SLGF_Light_Box" id="SLGF_Light_Box">
                <optgroup label="Select Light Box Styles">
                    <option value="lightbox3" <?php if ( $SLGF_Light_Box == 'lightbox3' ) {
                        echo "selected=selected";
                    } ?>><?php esc_html_e( 'light Gallery', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                </optgroup>
            </select>
            <p class="description">
                <?php esc_html_e( 'Choose an image Title style.', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                <a href="https://weblizar.com/plugins/gallery-pro/" target="_new">(<?php esc_html_e( 'Get More Lightbox', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>)</a>
            </p>
            <p class="description" style="color:red;">
                <?php esc_html_e( 'Swipe box lib. No longer Supported Wordpress 5.6 so we changed it to Light Gallery ', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Image Hover Animation", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Hover_Animation == "" ) {
				$SLGF_Hover_Animation = "fade";
			} ?>
            <select name="wl-hover-animation" id="wl-hover-animation">
                <optgroup label="Select Animation">
                    <option value="stroke" <?php if ( $SLGF_Hover_Animation == 'stroke' ) {
						echo "selected=selected";
					} ?>><?php esc_html_e( 'Stroke', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                </optgroup>
            </select>
            <p class="description"><?php esc_html_e( "Choose an animation effect apply on images after mouse hover.", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                <a href="https://weblizar.com/lightbox-slider-pro/"
                   target="_new"><?php esc_html_e( "Get More Hover Animation", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></a></p>
        </td>
    </tr>
	<tr>
        <th><label><?php esc_html_e( 'Show Image Description', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <input type="radio" name="lk_show_img_desc" id="lk_show_img_desc"
                   value="Yes" <?php if ( $lk_show_img_desc == "Yes" ) {
				echo "checked";
			} ?>><i class="fa fa-check fa-2x"></i>
            <input type="radio" name="lk_show_img_desc" id="lk_show_img_desc"
                   value="no" <?php if ( $lk_show_img_desc == "no" ) {
				echo "checked";
			} ?>>
            <i class="fa fa-times fa-2x"></i>
            <p><?php esc_html_e( 'Select Yes/No option to hide or show gallery description', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label><?php esc_html_e( "Gallery Layout", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Gallery_Layout == "" ) {
				$SLGF_Gallery_Layout = "col-md-6";
			} ?>
            <select name="wl-gallery-layout" id="wl-gallery-layout">
                <optgroup label="Select Gallery Layout">
                    <option value="col-md-6" <?php if ( $SLGF_Gallery_Layout == 'col-md-6' ) {
						echo "selected=selected";
					} ?>><?php esc_html_e( "Two Column", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="col-md-4" <?php if ( $SLGF_Gallery_Layout == 'col-md-4' ) {
						echo "selected=selected";
					} ?>><?php esc_html_e( "Three Column", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                </optgroup>
            </select>
            <p class="description"><?php esc_html_e( "Choose a column layout for image gallery", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                . <a href="https://weblizar.com/lightbox-slider-pro/"
                     target="_new"><?php esc_html_e( "Get More Gallery Layout", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></a></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label><?php esc_html_e( "Thumbnail Layout", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( ! isset( $SLGF_Thumbnail_Layout ) ) {
				$SLGF_Thumbnail_Layout = "same-size";
			} ?>
            <input type="radio" name="wl-thumbnail-layout" id="wl-thumbnail-layout"
                   value="same-size" <?php if ( $SLGF_Thumbnail_Layout == 'same-size' ) {
				echo esc_attr("checked");
			} ?>> Show Same Size Thumbnails
            <input type="radio" name="wl-thumbnail-layout" id="wl-thumbnail-layout"
                   value="masonry" <?php if ( $SLGF_Thumbnail_Layout == 'masonry' ) {
				echo esc_attr("checked");
			} ?>> Show Masonry Style Thumbnails
            <input type="radio" name="wl-thumbnail-layout" id="wl-thumbnail-layout"
                   value="original" <?php if ( $SLGF_Thumbnail_Layout == 'original' ) {
				echo esc_attr("checked");
			} ?>> <?php esc_html_e( "Show Original Image As Thumbnails", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
            <p class="description"><?php esc_html_e( "Select an option for thumbnail layout setting", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                .</p>
            <p class="description"><?php esc_html_e( "If Same Size Thumbnail option selected than minimum image size required in following layouts", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                :</p>
            <p class="description"><?php esc_html_e( "Minimum image size required in 2 Column Gallery Layout", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                <?php esc_html_e( ': 500x500px', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></p>
            <p class="description"><?php esc_html_e( "Minimum image size required in 3 Column Gallery Layout", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                <?php esc_html_e( ': 400x400px', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Hover Color", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Hover_Color == "" ) {
				$SLGF_Hover_Color = "#0AC2D2";
			} ?>
            <input type="text" class="my-color-field" name="wl-hover-color" id="wl-text-color2"
                   value="<?php esc_html_e( $SLGF_Hover_Color); ?>" >
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Text Background Color", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Text_BG_Color == "" ) {
				$SLGF_Text_BG_Color = "#FFFFFF";
			} ?>
             <input type="text" class="my-color-field" name="wl-text-bg-color" id="wl-text-color3"
                   value="<?php esc_html_e( $SLGF_Text_BG_Color); ?>" >
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Text Color", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Text_Color == "" ) {
				$SLGF_Text_Color = "#000000";
			} ?>
            <input type="text" class="my-color-field" name="wl-text-color" id="wl-text-color1"
                   value="<?php esc_html_e( $SLGF_Text_Color); ?>" >
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Hover Color Opacity", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( ! isset( $SLGF_Hover_Color_Opacity ) ) {
				$SLGF_Hover_Color_Opacity = "yes";
			} ?>
            <input type="radio" name="wl-hover-color-opacity" id="wl-hover-color-opacity"
                   value="yes" <?php if ( $SLGF_Hover_Color_Opacity == 'yes' ) {
				echo "checked";
			} ?>> <i class="fa fa-check fa-2x"></i>
            <input type="radio" name="wl-hover-color-opacity" id="wl-hover-color-opacity"
                   value="no" <?php if ( $SLGF_Hover_Color_Opacity == 'no' ) {
				echo "checked";
			} ?>> <i class="fa fa-times fa-2x"></i>
            <p class="description"><?php esc_html_e( "Select Yes/No option for hover color opacity on images", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                .</p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Caption Font Style", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
            <select name="wl-font-style" class="standard-dropdown" id="wl-font-style">
                <optgroup label="Default Fonts">
                    <option value="Arial" <?php selected( $SLGF_Font_Style, 'Arial' ); ?>><?php esc_html_e( 'Arial', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Arial Black" <?php selected( $SLGF_Font_Style, 'Arial Black' ); ?>><?php esc_html_e( 'Arial Black', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                    <option value="Courier New" <?php selected( $SLGF_Font_Style, 'Courier New' ); ?>><?php esc_html_e( 'Courier New', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                    <option value="cursive" <?php selected( $SLGF_Font_Style, 'cursive' ); ?>><?php esc_html_e( 'Cursive', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="fantasy" <?php selected( $SLGF_Font_Style, 'fantasy' ); ?>><?php esc_html_e( 'Fantasy', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Georgia" <?php selected( $SLGF_Font_Style, 'Georgia' ); ?>><?php esc_html_e( 'Georgia', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Grande"<?php selected( $SLGF_Font_Style, 'Grande' ); ?>><?php esc_html_e( 'Grande', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Helvetica Neue" <?php selected( $SLGF_Font_Style, 'Helvetica Neue' ); ?>><?php esc_html_e( 'Helvetica
                        Neue', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                    <option value="Impact" <?php selected( $SLGF_Font_Style, 'Impact' ); ?>><?php esc_html_e( 'Impact', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Lucida" <?php selected( $SLGF_Font_Style, 'Lucida' ); ?>><?php esc_html_e( 'Lucida', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Lucida Console"<?php selected( $SLGF_Font_Style, 'Lucida Console' ); ?>><?php esc_html_e( 'Lucida
                        Console', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                    <option value="monospace" <?php selected( $SLGF_Font_Style, 'monospace' ); ?>><?php esc_html_e( 'Monospace', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Open Sans" <?php selected( $SLGF_Font_Style, 'Open Sans' ); ?>><?php esc_html_e( 'Open Sans', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Palatino" <?php selected( $SLGF_Font_Style, 'Palatino' ); ?>><?php esc_html_e( 'Palatino', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="sans" <?php selected( $SLGF_Font_Style, 'sans' ); ?>><?php esc_html_e( 'Sans', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="sans-serif" <?php selected( $SLGF_Font_Style, 'sans-serif' ); ?>><?php esc_html_e( 'Sans-Serif', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Tahoma" <?php selected( $SLGF_Font_Style, 'Tahoma' ); ?>><?php esc_html_e( 'Tahoma', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                    <option value="Times New Roman"<?php selected( $SLGF_Font_Style, 'Times New Roman' ); ?>><?php esc_html_e( 'Times New
                        Roman', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                    <option value="Trebuchet MS" <?php selected( $SLGF_Font_Style, 'Trebuchet MS' ); ?>><?php esc_html_e( 'Trebuchet MS', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    </option>
                    <option value="Verdana" <?php selected( $SLGF_Font_Style, 'Verdana' ); ?>><?php esc_html_e( 'Verdana', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                </optgroup>
            </select>
            <p class="description"><?php esc_html_e( "Choose a caption font style", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>. <a
                        href="https://weblizar.com/lightbox-slider-pro/"
                        target="_new"><?php esc_html_e( "Get", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                    <?php esc_html_e( '500+', WEBLIZAR_SLGF_TEXT_DOMAIN ); ?><?php esc_html_e( "Google Fonts", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></a></p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( "Image Box Shadow", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
        <td>
			<?php if ( $SLGF_Box_Shadow == "" ) {
				$SLGF_Box_Shadow = "yes";
			} ?>
            <input type="radio" name="wl-box-Shadow" id="wl-box-Shadow"
                   value="yes" <?php if ( $SLGF_Box_Shadow == 'yes' ) {
				echo "checked";
			} ?>> <i class="fa fa-check fa-2x"></i>
            <input type="radio" name="wl-box-Shadow" id="wl-box-Shadow"
                   value="no" <?php if ( $SLGF_Box_Shadow == 'no' ) {
				echo "checked";
			} ?>> <i class="fa fa-times fa-2x"></i>
            <p class="description"><?php esc_html_e( "Select Yes/No option to hide or show Image Box Shadow", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                .</p>
        </td>
    </tr>

    <tr>
        <th scope="row"><label><?php esc_html_e( 'Custom CSS', WEBLIZAR_SLGF_TEXT_DOMAIN ) ?></label></th>
        <td>
			<?php if ( ! isset( $SLGF_Custom_CSS ) ) {
				$SLGF_Custom_CSS = "";
			} ?>
            <textarea id="wl-custom-css" name="wl-custom-css" type="text" class=""
                      style="width:80%"><?php echo esc_html($SLGF_Custom_CSS); ?></textarea>
            <p class="description">
				<?php esc_html_e( 'Enter any custom css you want to apply on this gallery.', WEBLIZAR_SLGF_TEXT_DOMAIN ) ?><br>
            </p>
            <p class="custnote"><?php esc_html_e( "Note", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                : <?php esc_html_e( "Please Do Not Use", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
                <b><?php esc_html_e( "Style", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></b> <?php esc_html_e( "Tag With Custom CSS", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>
            </p>
        </td>
    </tr>

    </tbody>
</table>