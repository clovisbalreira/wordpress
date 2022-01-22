<?php

/**
* The admin-specific functionality of the plugin.
*
* @link       sonaar.io
* @since      1.0.0
*
* @package    Sonaar_Music
* @subpackage Sonaar_Music/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    Sonaar_Music
* @subpackage Sonaar_Music/admin
* @author     Edouard Duplessis <eduplessis@gmail.com>
*/

class Sonaar_Music_Admin {

    /**
    * The ID of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $plugin_name    The ID of this plugin.
    */
    private $plugin_name;
    
    /**
    * The version of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $version    The current version of this plugin.
    */
    private $version;
    
    /**
    * Initialize the class and set its properties.
    *
    * @since    1.0.0
    * @param      string    $plugin_name       The name of this plugin.
    * @param      string    $version    The version of this plugin.
    */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
        
    }
    
    
    /**
    * Load the required dependencies for the admin area.
    *
    * Include the following files that make up the plugin:
    *
    * @since		1.0.0
    */
    public function load_dependencies(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2/init.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-calltoaction/cmb2-calltoaction.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-conditionals/cmb2-conditionals.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-image-select-field-type/image_select_metafield.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-post-search-field/cmb2_post_search_field.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-store-list/song-store-field-type.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-typography/typography-field-type.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-multiselect/cmb2-multiselect.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/cmb2-switch-button-metafield/switch_metafield.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sonaar-music-widget.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sonaar-music-block.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/library/Shortcode_Button/shortcode-button.php';    
    }

    /**
    * Register the stylesheets for the admin area.
    *
    * @since    1.0.0
    */
    public function editor_scripts() {
        wp_enqueue_style( 'sonaar-elementor-editor', plugin_dir_url(dirname(__FILE__)) . 'admin/css/elementor-editor.css', array(), $this->version, 'all' );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'sonaar-music-admin', plugin_dir_url( __FILE__ ) . 'css/sonaar-music-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'cmb2_switch-css', plugin_dir_url( __FILE__ ) . 'library/cmb2-switch-button-metafield/switch_metafield.css', false, $this->version ); //CMB2 Switch Styling
        wp_enqueue_script( 'cmb2_switch-js', plugin_dir_url( __FILE__ ) . 'library/cmb2-switch-button-metafield/switch_metafield.js' , '', '1.0.0', true );  // CMB2 Switch Event
    
    }

    /**
    * Register the JavaScript for the admin area.
    *
    * @since    1.0.0
    */
    public function enqueue_scripts( $hook ) {
        if ($hook == SR_PLAYLIST_CPT . '_page_iron_music_player' || $hook == SR_PLAYLIST_CPT . '_page_sonaar_music_promo' || $hook == SR_PLAYLIST_CPT . '_page_sonaar_music_promo') { // (RetroCompatibility)'_page_iron_music_player' is the hook for the old plugin settings page. 
            wp_enqueue_script( 'vuejs', plugin_dir_url( __DIR__ ) . 'public/js/vue.min.js' , array(), '2.6.14', false );
            wp_enqueue_script( 'polyfill', plugin_dir_url( __DIR__ ) . 'public/js/polyfill.min.js' , array(), '6.26.0', false );
            wp_enqueue_script( 'bootstrap-vue', plugin_dir_url( __DIR__ ) . 'public/js/bootstrap-vue.min.js' , array(), '2.21.2', false );
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sonaar-music-admin.js', array( 'jquery','vuejs','polyfill','bootstrap-vue' ), $this->version, true );
            wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), '5.1.3', 'all' );
            wp_enqueue_style( 'bootstrapvue-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap-vue.min.css', array(), $this->version, 'all' );
        }

        if ($hook == 'term.php' || $hook == SR_PLAYLIST_CPT . '_page_iron_music_player' || $hook == SR_PLAYLIST_CPT . '_page_sonaar_music_promo' || $hook == SR_PLAYLIST_CPT . '_page_sonaar_music_promo' || strpos($hook, SR_PLAYLIST_CPT . '_page_srmp3_settings_') === 0) {
                wp_enqueue_script( 'cmb2_conditionallogic-js', plugin_dir_url( __FILE__ ) . 'library/cmb2-conditional-logic/cmb2-conditional-logic.min.js' , '', '1.0.0', true );  // Used for plugin settings page only. it does not work on group repeater fields
        }
        if (strpos($hook, SR_PLAYLIST_CPT . '_page_srmp3_settings_') === 0) {
            wp_enqueue_script( 'cmb2_image_select_metafield-js', plugin_dir_url( __FILE__ ) . 'library/cmb2-image-select-field-type/image_select_metafield.js' , '', '1.0.0', true );  // Used for plugin settings page only. it does not work on group repeater fields
        }
        
    }

    public function init_options() {

        function defaultWaveform(){
            if( Sonaar_Music::get_option('music_player_coverSize', 'srmp3_settings_widget_player') != null && Sonaar_Music::get_option('waveformType', 'srmp3_settings_general') == null ){
                return 'wavesurfer';
            }else{
                return 'mediaElement';
            }
        }
        function get_the_cpt(){
                $post_types = get_post_types(['public'   => true, 'show_ui' => true], 'objects');
                $posts = array();
                foreach ($post_types as $post_type) {
                    if ($post_type->name == 'attachment' || $post_type->name == 'elementor_library' )
                        continue; 

                    $posts[$post_type->name] = $post_type->labels->singular_name;
                }
                return $posts;
        }
        function music_player_coverSize(){
            $music_player_coverSize = array();
            $imageSizes = get_intermediate_image_sizes();
            foreach ($imageSizes as $value) {
                $music_player_coverSize[$value] = $value;
            }
            return $music_player_coverSize;
        }
        function promo_ad_cb( $field_args, $field ) {
            if ( !function_exists('run_sonaar_music_pro') || $field->id('promo_music_player_sticky_title') && get_site_option('SRMP3_ecommerce') != '1' ){
                $textpromo = ( $field->options('textpromo')) ? $field->options('textpromo') : esc_html__('Premium Feature | Upgrade to Pro', 'sonaar-music');
                echo '<div class="prolabel"><a href="https://sonaar.io/free-mp3-music-player-plugin-for-wordpress/?utm_source=Sonaar+Music+Free+Plugin&utm_medium=plugin" target="_blank"><i class="sricon-Sonaar-symbol"></i> ' . esc_html($textpromo) . ' </a></div>';
            }
        }
        function remove_pro_label_if_pro( $field_args, $field ) {
            $classes = array(
                'srmp3-pro-feature',
                'prolabel--nomargin',
            );
            if ( function_exists('run_sonaar_music_pro')){
                array_push($classes, 'prolabel--nohide');
            }
                return $classes;
        }
        function srmp3_add_tooltip_to_label( $field_args, $field ) {
            $escapedVar = array(
                
                'div' => array(
                    'class' => array(),
                ),
                'em' => array(),
                'strong' => array(),
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'img' => array(
                    'src' => array(),
                ),
                'br' => array(),
                'i' => array(
                    'class' => array(),
                ),
            );
            // Get default label
            $value = '';
            $pro_badge = ( $field->tooltip( 'pro' ) ) ? '<div class="srmp3_pro_badge"><i class="sricon-Sonaar-symbol">&nbsp;</i>Pro Feature</div>' : '';
            $field_label = '<label style="display:inline-block;margin-right:4px;">' . esc_html( $field->name() ) . '</label>';
            $field_title = ( !$field->tooltip( 'title' ) ) ? $field->name() : $field->tooltip( 'title' );
            

            if ( $field->tooltip( 'text' ) ) {
                $imgSrc = ($field->tooltip( 'image' )) ?  '<img src="' . esc_url( plugin_dir_url( __FILE__ ) . 'img/tip/' . esc_html($field->tooltip( 'image' ))) . '">' : '';
                $value .= '
                <div class="srmp3_tooltip"><i class="sricon-info"></i>
                    <div class="srmp3_tooltiptext srmp3_tooltip-right">
                        ' . wp_kses($imgSrc, $escapedVar) . '
                        <div class="srmp3_tooltip_title">' . esc_html( $field_title ) . wp_kses($pro_badge, $escapedVar) . '</div>

                        <div class="srmp3_tooltip_desc">' . wp_kses($field->tooltip( 'text' ), $escapedVar) . '</div>
                    </div>
                </div>
                ';
            
            }
            if($field->label_cb() === 'srmp3_add_tooltip_to_label')
                $value = $field_label . $value;

            return $value;
        }
        /**
         * Hook in and register a metabox to handle a theme options page and adds a menu item.
         */
        $escapedVar = array(
                
            'div' => array(
                'class' => array(),
            ),
            'em' => array(),
            'strong' => array(),
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array()
            ),
            'img' => array(
                'src' => array(),
            ),
            'br' => array(),
            'i' => array(
                'class' => array(),
            ),
        );
        $options_name = array();

            /**
             * Registers main options page menu item and form.
             */
            $args = array(
                'id'           => 'sonaar_music_network_option_metabox',
                'title'        => esc_html__( 'Settings', 'sonaar-music' ),
                'object_types' => array( 'options-page' ),
                'option_key'   => 'srmp3_settings_general', // The option key and admin menu page slug. 'yourprefix_main_options',
                'tab_group'    => 'yourprefix_main_options',
                'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. // 'yourprefix_main_options',
                'tab_title'    => esc_html__( 'General', 'sonaar-music' ),
            );

            // 'tab_group' property is supported in > 2.4.0.
            if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                $args['display_cb'] = 'yourprefix_options_display_with_tabs';
            }

            $general_options = new_cmb2_box( $args );
            array_push($options_name, $general_options);

            /**
             * Options fields ids only need
             * to be unique within this box.
             * Prefix is not needed.
             */

            $general_options->add_field( array(
                'name'          => esc_html__('Audio Player General Settings', 'sonaar-music'),
                'type'          => 'title',
                'id'            => 'music_player_title'
            ) );
            $general_options->add_field( array(
                'name'          => esc_html__('Website Type', 'sonaar-music'),
                'description'   => esc_html__('Music or Podcast Website?','sonaar-music'),
                'id'            => 'player_type',
                'label_cb'         => 'srmp3_add_tooltip_to_label',
                'tooltip'       => array(
                    'title'     => esc_html__('What is your style?', 'sonaar-music'),
                    'text'      => __('Either you run a Music, Radio or Podcast website, we\'ve got you covered. This affect how we assign labels & strings in the admin dashboard.<br><br>Turning Podcast Mode On will unlock dedicated podcast features such as an RSS Importer, Subscribe Buttons, Podcast Show taxonomy and other neat features.', 'sonaar-music'),
                    'image'     => '',
                    'pro'       => '',
                ),
                'type'          => 'select',
                'options'       => array(
                    'classic'    => esc_html__('Music oriented (For Musicians, Artists, Labels, Producers, etc)', 'sonaar-music'),
                    'podcast'    => esc_html__('Podcast oriented (For Podcast, Audiobook, Meditation, etc) ', 'sonaar-music'),
                ),
                'default'       => 'classic'
            ) );
            $general_options->add_field( array(
                'name' => esc_html__('Player Layout', 'sonaar-music'),
                'label_cb'      => 'srmp3_add_tooltip_to_label',
                'tooltip'       => array(
                    'title'     => esc_html__('Default Player Layout', 'sonaar-music'),
                    'text'      => sprintf(__('We have designed 2 different audio player layouts. One has a floated style with tracklist and the cover image side-by-side while the other has a boxed layout with full-width playlist below the player.<br><br> The player layout is used in the playlist/episode single page. <br><br>You can customize the default player look and feel in Settings > Widget tab.<br><br>You can also customize each player\'s instance with shortcode attributes, Elementor Widget or Gutenberg block. %1$sLearn More%2$s', 'sonaar-music'), '<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>' ),
                    'image'     => '',
                ),
                'id'   =>   'player_widget_type',
                'type' => 'image_select',
                'width' => '350px',
                'options' => array(
                    'skin_float_tracklist' => array('title' => 'Floated', 'alt' => 'Floated', 'img' => plugin_dir_url( __FILE__ ) . 'img/player_type_floated.svg'),
                    'skin_boxed_tracklist' => array('title' => 'Boxed', 'alt' => 'Boxed', 'img' => plugin_dir_url( __FILE__ ) . 'img/player_type_boxed.svg'),
                ),
                'default' => 'skin_float_tracklist',
            ));
            $general_options->add_field( array(
                'name'          => esc_html('Post Types', 'sonaar-music'),
                //'desc'          => esc_html('Select the post types for which you want to enable playlist creation', 'sonaar-music'),
                'label_cb'      => 'srmp3_add_tooltip_to_label',
                'tooltip'       => array(
                    'title'     => esc_html__('Where are you using the player?', 'sonaar-music'),
                    'text'      => esc_html__('We will display our custom fields in the selected post types so you can add audio tracks by editing their single post.', 'sonaar-music'),
                    'image'     => 'postype.svg',
                ),
                'id'            => 'srmp3_posttypes',
                'type'          => 'multicheck',
                'select_all_button' => false,
                'options'       => get_the_cpt(),
                'default'        => array(SR_PLAYLIST_CPT, 'product'),
            ) );
            if( Sonaar_Music::get_option('player_type', 'srmp3_settings_general') === 'podcast'){
                $general_options->add_field( array(
                    'name'          => esc_html__('Waveform Type', 'sonaar-music'),
                    'id'            => 'waveformType',
                    'type'          => 'select',
                    'label_cb'      => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => '',
                        'text'      => __('Choose between 3 different waveforms & progress bars.<br><br>Synthetic Waveforms load lightning fast and is used for most common type of websites.<br><br>Dynamic Waveforms is powered by Wavesurfer.js. To generate the waveforms, we need to preload your MP3 file. We display the waveforms once the MP3 has been fully preloaded so its recommend to use only small audio files. It does not work with streaming feed.<br><br>Simple Bar do not generate waveforms but a simple neat & clean progress bar.', 'sonaar-music'),
                        'image'     => 'waveform.svg',
                    ),
                    'options'       => array(
                        'mediaElement'  => 'Synthetic Waveform (faster)',
                        'simplebar'     => 'Very Simple Bar (faster)',
                    ),
                    'default'       => defaultWaveform()
                ) ); 
            }else{
                $general_options->add_field( array(
                    'name'          => esc_html__('Waveform Type', 'sonaar-music'),
                    'id'            => 'waveformType',
                    'type'          => 'select',
                    'label_cb'      => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => '',
                        'text'      => __('Choose between 3 different waveforms & progress bars.<br><br>Synthetic Waveforms load lightning fast and is used for most common type of websites.<br><br>Dynamic Waveforms is powered by Wavesurfer.js. To generate the waveforms, we need to preload your MP3 file. We display the waveforms once the MP3 has been fully preloaded so its recommend to use only small audio files. It does not work with streaming feed.<br><br>Simple Bar do not generate waveforms but a simple neat & clean progress bar.', 'sonaar-music'),
                        'image'     => 'waveform.svg',
                    ),
                    'options'       => array(
                        'mediaElement'  => 'Synthetic Waveform (faster)',
                        'simplebar'     => 'Very Simple Bar (faster)',
                        'wavesurfer'    => 'Dynamic Waveform (slower)'
                    ),
                    'default'       => defaultWaveform()
                ) ); 
            }
           
            $general_options->add_field( array(
                'name'          => esc_html__('Soundwave Max Height', 'sonaar-music'),
                'id'            => 'sr_soundwave_height',
                'type'          => 'select',
                'options'       => array(
                    "70"      => esc_html__('Default (70px)', 'sonaar-music'),
                    "20"    => esc_html__('Tiny (20px)', 'sonaar-music'),
                    "40"    => esc_html__('Small (40px)', 'sonaar-music'),
                    "120"    => esc_html__('Huge (120px)', 'sonaar-music'),
                ),
                'attributes'    => array(
                    'data-conditional-id'    => 'waveformType',
                    'data-conditional-value' => wp_json_encode( array( 'mediaElement' ) ),
                ),
                //'default'       => 1,
            ) );
            $general_options->add_field( array(
                'name'          => esc_html__('Progress Bar Height (px)', 'sonaar-music'),
                'id'            => 'sr_soundwave_height_simplebar',
                'type'          => 'text_small',
                'attributes'    => array(
                    'type' => 'number',
                    'data-conditional-id'    => 'waveformType',
                    'data-conditional-value' => wp_json_encode( array( 'simplebar' ) ),
                ),
                'default'       => 5,
            ) );  
            
            $general_options->add_field( array(
                'name'          => esc_html__('Soundwave Bar Width (px)', 'sonaar-music'),
                'id'            => 'music_player_barwidth',
                'type'          => 'text_small',
                'attributes'    => array(
                    //'type' => 'number',
                    'data-conditional-id'    => 'waveformType',
                    'data-conditional-value' => wp_json_encode( array( 'mediaElement' ) ),
                ),
                'default'       => 1,
            ) );
            $general_options->add_field( array(
                'name'          => esc_html__('Soundwave Bar Gap (px)', 'sonaar-music'),
                'id'            => 'music_player_bargap',
                'type'          => 'text_small',
                'attributes'    => array(
                    //'type' => 'number',
                    'data-conditional-id'    => 'waveformType',
                    'data-conditional-value' => wp_json_encode( array( 'mediaElement' ) ),
                ),
                'default'       => 1,
            ) );        
            $general_options->add_field( array(
                'name'          => $this->sr_GetString('Display Artist Name'),
                'id'            => 'show_artist_name',
                'type'          => 'checkbox',
                'label_cb'      => 'srmp3_add_tooltip_to_label',
                'tooltip'       => array(
                    'title'     => '',
                    'text'      => esc_html__('When enabled, we display the artist name beside each of your track. E.g. < Track Title "by" Artist Name >. You can change the separator text label as well.', 'sonaar-music'),
                    'image'     => 'artistname.svg',
                ),
            ) );
            $general_options->add_field( array(
                'name'          => $this->sr_GetString('Artist Name Prefix Separator'),
                'id'            => 'artist_separator',
                'type'          => 'text_small',
                'default'       => esc_html__('by', 'sonaar-music'),
                'attributes'    => array(
                    'data-conditional-id'    => 'show_artist_name',
                    'data-conditional-value' => 'on',
                    'placeholder' => 'by',
                ),
            ) );

            /**
             * Registers fourth options page, and set main item as parent.
             */
            $args = array(
                'id'           => 'yourprefix_fourth_options_page',
                'menu_title'   => esc_html__( 'Widget Settings', 'sonaar-music' ),
                'title'        => esc_html__( 'Widget Player Settings', 'sonaar-music' ),
                'object_types' => array( 'options-page' ),
                'option_key'   => 'srmp3_settings_widget_player', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
                'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. //'yourprefix_main_options',
                'tab_group'    => 'yourprefix_main_options',
                'tab_title'    => esc_html__( 'Widget Player', 'sonaar-music' ),
            );

            // 'tab_group' property is supported in > 2.4.0.
            if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                $args['display_cb'] = 'yourprefix_options_display_with_tabs';
            }

            $widget_player_options = new_cmb2_box( $args );
            array_push($options_name, $widget_player_options);

            if ( function_exists( 'run_sonaar_music_pro' ) ){
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Default Widget Player Settings', 'sonaar-music'),
                    'type'          => 'title',
                    'id'            => 'widget_player_settings'
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Skip 15/30 Seconds button', 'sonaar-music'),
                    'id'            => 'player_show_skip_bt',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => '',
                        'text'      => esc_html__('A listener just missed something in your track? Add a 15 seconds backward button so he can quickly catch-up. Same thing if he want to quickly skip a segment or two.', 'sonaar-music'),
                        'image'     => 'skip30.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Playback Speed Button', 'sonaar-music'),
                    'id'            => 'player_show_speed_bt',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Default Playback Speed', 'sonaar-music'),
                        'text'      => esc_html__('A speed rate button gives your user the ability to change the playback speed from 0.5x, 1x, 1.2x, 1.5x and 2x', 'sonaar-music'),
                        'image'     => 'speedrate.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Volume Control', 'sonaar-music'),
                    'id'            => 'player_show_volume_bt',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Default Volume Controller Button', 'sonaar-music'),
                        'text'      => esc_html__('We will add a cool volume control under your player so the user may adjust the volume level. The volume level is retained in its browser session.', 'sonaar-music'),
                        'image'     => 'volume.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Shuffle Button', 'sonaar-music'),
                    'id'            => 'player_show_shuffle_bt',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Default Shuffle Button', 'sonaar-music'),
                        'text'      => esc_html__('Allow the ability to shuffle the tracks randomly within the Playlist.', 'sonaar-music'),
                        'image'     => 'shuffle.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Date in the Player', 'sonaar-music'),
                    'id'            => 'player_show_publish_date',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Display Published Date in Player', 'sonaar-music'),
                        'text'      => esc_html__('We will display the published date of the current Playlist/Episode that is being played within the player. You can change the published date by editing the post\'s date.', 'sonaar-music'),
                        'image'     => 'playerdate.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Date in the Tracklist', 'sonaar-music'),
                    'id'            => 'player_show_track_publish_date',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Display Published Dates in Tracklist', 'sonaar-music'),
                        'text'      => esc_html__('We will display the published date for each track in the playlist. Useful if you run a podcast and you want to display dates for each of your episode in the tracklist.', 'sonaar-music'),
                        'image'     => 'tracklistdate.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Total Number of Tracks', 'sonaar-music'),
                    'id'            => 'player_show_tracks_count',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('', 'sonaar-music'),
                        'text'      => esc_html__('Sometimes its useful to let your visitor knows how many tracks contains the playlist. We will show this label in the player. Below, you can change and translate the track label for something that better suits your needs such as 10 Songs, Tracks, Episodes, Sermons, etc.', 'sonaar-music'),
                        'image'     => 'totaltrack.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Total Playlist Time Duration', 'sonaar-music'),
                    'id'            => 'player_show_meta_duration',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Display Total Playlist Duration', 'sonaar-music'),
                        'text'      => esc_html__('As the name suggest, we will calculate the sum of each track\'s duration and will display the total amount of the duration in the player. You can change and translate the label of hours and minutes.', 'sonaar-music'),
                        'image'     => 'totaltime.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Enable Track Redirection to the Single Post', 'sonaar-music'),
                    'id'            => 'player_post_link',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Link to Single Post', 'sonaar-music'),
                        'text'      => esc_html__('When enabled, track titles in your playlist will link to their single posts. This feature is mostly used for podcasters.', 'sonaar-music'),
                        'image'     => 'redirectpost.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Text label for Call-to-Action Icon', 'sonaar-music'),
                    'id'            => 'show_label',
                    'type'          => 'switch',
                    'default'       => 'false',
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Text Label for Call-to-Actions', 'sonaar-music'),
                        'text'      => esc_html__('When you add a call to action button for your tracks, we only show the icon by default to maximize the space for the track title. By enabling this option, we will also show its label name.', 'sonaar-music'),
                        'image'     => 'textlabel_cta.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Display Text Label for the Play Button', 'sonaar-music'),
                    'id'            => 'player_use_play_label',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Text Label instead of Play Icon', 'sonaar-music'),
                        'text'      => esc_html__('Only used for the boxed layout player. We will replace the big Play/Pause Icon in the player by a text button. You can translate the Play & Pause strings by anything you like below.', 'sonaar-music'),
                        'image'     => 'textlabel_play.svg',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Play Button Label', 'sonaar-music'),
                    'id'            => 'labelPlayTxt',
                    'type'          => 'text_small',
                    'attributes'    => array( 'placeholder' => esc_html__( "Play", 'sonaar-music' ) ),
                    'default'       => esc_html__('Play', 'sonaar-music'),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Pause Button Label', 'sonaar-music'),
                    'id'            => 'labelPauseTxt',
                    'type'          => 'text_small',
                    'attributes'    => array( 'placeholder' => esc_html__( "Pause", 'sonaar-music' ) ),
                    'default'       => esc_html__('Pause', 'sonaar-music'),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Total Number of Tracks Label', 'sonaar-music'),
                    'id'            => 'player_show_tracks_count_label',
                    'type'          => 'text_small',
                    'default'       => esc_html__('Tracks', 'sonaar-music'),
                    'attributes'    => array( 'placeholder' => esc_html__( "Tracks", 'sonaar-music' ) ),
                    'description'   => esc_html__('Label displayed after the total number of tracks. Eg: 6 Tracks, 6 Episodes, 6 Songs, 6 Sermons', 'sonaar-music'),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Hours Total Duration Label', 'sonaar-music'),
                    'id'            => 'player_hours_label',
                    'type'          => 'text_small',
                    'attributes'    => array( 'placeholder' => esc_html__( "hr.", 'sonaar-music' ) ),
                    'default'       => esc_html__('hr.', 'sonaar-music'),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Minutes Total Duration Label', 'sonaar-music'),
                    'id'            => 'player_minutes_label',
                    'type'          => 'text_small',
                    'attributes'    => array( 'placeholder' => esc_html__( "min.", 'sonaar-music' ) ),
                    'default'       => esc_html__('min.', 'sonaar-music'),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Date Format', 'sonaar-music'),
                    'id'            => 'player_date_format',
                    'type'          => 'text_small',
                    'default'       => '',
                    'attributes'    => array( 'placeholder' => esc_html__( "F j, Y", 'sonaar-music' ) ),
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Date Format', 'sonaar-music'),
                        'text'      => sprintf(__('Here are some examples of date format with the result output.<br><br>
                        F j, Y g:i a – November 6, 2010 12:50 am<br>
                        F j, Y – November 6, 2010<br>
                        F, Y – November, 2010<br>
                        g:i a – 12:50 am<br>
                        g:i:s a – 12:50:48 am<br>
                        l, F jS, Y – Saturday, November 6th, 2010<br>
                        M j, Y @ G:i – Nov 6, 2010 @ 0:50<br>
                        Y/m/d \a\t g:i A – 2010/11/06 at 12:50 AM<br>
                        Y/m/d \a\t g:ia – 2010/11/06 at 12:50am<br>
                        Y/m/d g:i:s A – 2010/11/06 12:50:48 AM<br>
                        Y/m/d – 2010/11/06<br><br>%1$sView documentation%2$s on date and time formatting.', 'sonaar-music'), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>' ),
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Single Post Settings', 'sonaar-music'),
                    'type'          => 'title',
                    'id'            => 'widget_player_single_post_title'
                ) );
                $widget_player_options->add_field( array(
                    'name'          => sprintf( esc_html__('Single %1$s Page Slug', 'sonaar-music'), ucfirst($this->sr_GetString('playlist'))),
                    'id'            => 'sr_singlepost_slug',
                    'type'          => 'text_medium',
                    'attributes'    => array( 'placeholder' => $this->sr_GetString('album_slug') ),
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('', 'sonaar-music'),
                        'text'      => sprintf(__('Each single %2$s page has a unique URL and is represented by a slug name. You can replace it by anything you like.<br><br>eg: http://www.domain.com/<strong>%1$s</strong>/post-title', 'sonaar-music'), $this->sr_GetString('album_slug'), $this->sr_GetString('playlist')),
                        'image'     => '',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Category Slug', 'sonaar-music'),
                    'id'            => 'sr_category_slug',
                    'type'          => 'text_medium',
                    'attributes'    => array( 'placeholder' => $this->sr_GetString('category_slug') ),
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('', 'sonaar-music'),
                        'text'      => sprintf(__('Each %2$s\'s category page has a unique URL and is represented by a slug name. You can replace it by anything you like.<br><br>eg: http://www.domain.com/<strong>%1$s</strong>/category-title', 'sonaar-music'), $this->sr_GetString('category_slug'), $this->sr_GetString('playlist')),
                        'image'     => '',
                        'pro'       => true,
                    ),
                ) );
                if (Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ){
                    $widget_player_options->add_field( array(
                        'name'          => esc_html__('Podcast Show Slug', 'sonaar-music'),
                        'id'            => 'sr_podcastshow_slug',
                        'type'          => 'text_medium',
                        'attributes'    => array( 'placeholder' => esc_attr('podcast-show') ),
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => __('A podcast show is like a podcast category but its dedicated for Podcast shows. Main difference is that the podcast show taxonomy contains your podcast settings for your RSS feed.<br><br>Each podcast show page has a unique URL and is represented by a slug name. You can replace it by anything you like.<br><br>eg: http://www.domain.com/<strong>podcast-show</strong>/show-title', 'sonaar-music'),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                }
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Use Advanced Player Shortcode for the Single Post', 'sonaar-music'),
                    'id'            => 'sr_single_post_use_custom_shortcode',
                    'type'          => 'switch',
                    'default'       => 0,
                    'after'         => 'srmp3_add_tooltip_to_label',
                    'tooltip'       => array(
                        'title'     => esc_html__('Custom Shortcode in Single Post', 'sonaar-music'),
                        'text'      => sprintf(__('The player in your single %3$s page can be changed/tweaked by entering our shortcode and our supported attributes.<br><br>Will override the default player widget in the single post page by your own shortcode and attributes.<br><br>View shortcode & supported attributes %1$sdocumentation%2$s', 'sonaar-music'), '<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>', $this->sr_GetString('playlist')),
                        'image'     => '',
                        'pro'       => true,
                    ),
                ) );
                $widget_player_options->add_field( array(
                    'name'          => esc_html__('Custom Shortcode', 'sonaar-music'),
                    'type'          => 'textarea_small',
                    'id'            => 'sr_single_post_shortcode',
                    'description'          => sprintf( wp_kses( __('For shortcode attributes, %1$s read this article%2$s.','sonaar-music'), $escapedVar), '<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>'),
                    'default'       => '[sonaar_audioplayer player_layout="skin_boxed_tracklist" sticky_player="true" post_link="false" hide_artwork="false" show_playlist="true" show_track_market="true" show_album_market="true" hide_progressbar="false" hide_times="false" hide_track_title="true"]',
                    'attributes'    => array(
                        'data-conditional-id'    => 'sr_single_post_use_custom_shortcode',
                        'data-conditional-value' => 'true',
                    ),

                ) );                
            }
            $widget_player_options->add_field( array(
                'name'          => esc_html__('Widget Player & Controls', 'sonaar-music'),
                'type'          => 'title',
                'id'            => 'widget_player_controls_title'
            ) );   
            $widget_player_options->add_field( array(
                'id'            => 'music_player_icon_color',
                'type'          => 'colorpicker',
                'name'          => esc_html__('Player Control', 'sonaar-music'),
                'class'         => 'color',
                'default'       => 'rgba(127, 127, 127, 1)',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_artwork_icon_color',
                'type'          => 'colorpicker',
                'name'          => esc_html__('Player Control over Image', 'sonaar-music'),
                'class'         => 'color',
                'default'       => '#f1f1f1',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            if ( function_exists( 'run_sonaar_music_pro' ) ){
                $widget_player_options->add_field( array(
                    'id'            => 'labelPlayColor',
                    'type'          => 'colorpicker',
                    'name'          => esc_html__('Play Text Label', 'sonaar-music'),
                    'class'         => 'color',
                    'default'       => '',
                    'attributes'    => array(
                        'data-conditional-id'    => 'player_use_play_label',
                        'data-conditional-value' => 'true',
                    ),
                ) );
            }
            $widget_player_options->add_field( array(
                'id'            => 'music_player_timeline_color',
                'type'          => 'colorpicker',
                'name'          => esc_html__('SoundWave/Timeline Container Bar', 'sonaar-music'),
                'class'         => 'color',
                'default'       => 'rgba(31, 31, 31, 1)',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_progress_color',
                'type'          => 'colorpicker',
                'name'          => esc_html__('SoundWave/Timeline Progress Bar', 'sonaar-music'),
                'class'         => 'color',
                'default'       => 'rgba(13, 237, 180, 1)',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_bgcolor',
                'type'          => 'colorpicker',
                'name'          => esc_html__('Player Background Color', 'sonaar-music'),
                'desc'          => esc_html__('Apply on boxed player layout and the players in the single post','sonaar-music'),
                'class'         => 'color',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_playlist_bgcolor',
                'type'          => 'colorpicker',
                'name'          => esc_html__('Player Playlist Background Color', 'sonaar-music'),
                'desc'          => esc_html__('Apply on boxed player layout and the players in the single post','sonaar-music'),
                'class'         => 'color',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_coverSize',
                'type'          => 'select',
                'name'          => $this->sr_GetString('Album cover size image source'),
                'show_option_none' => false,
                'default'       => 'large',
                'options'       => music_player_coverSize(),
            ) );
            $widget_player_options->add_field( array(
                'name'          => esc_html__('Tracklist Fonts & Colors', 'sonaar-music'),
                'type'          => 'title',
                'id'            => 'music_player_typography'
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_album_title',
                'type'          => 'typography',
                'name'          => $this->sr_GetString('Album Title'),
                'description'   => esc_html__('Choose a font, font size and color', 'sonaar-music'),
                'fields'        => array(
                    'font-weight' 		=> false,
                    'background' 		=> false,
                    'text-align' 		=> false,
                    'text-transform' 	=> false,
                    'line-height' 		=> false,
                )
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_date',
                'type'          => 'typography',
                'name'          => $this->sr_GetString('Album Subtitle 2'),
                'description'   => esc_html__('Choose a font, font size and color', 'sonaar-music'),
                'fields'        => array(
                    'font-weight' 		=> false,
                    'background' 		=> false,
                    'text-align' 		=> false,
                    'text-transform' 	=> false,
                    'line-height' 		=> false,
                )
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_playlist',
                'type'          => 'typography',
                'name'          => esc_html__('Tracklist', 'sonaar-music'),
                'description'   => esc_html__('Choose a font, font size and color', 'sonaar-music'),
                'fields'        => array(
                    'font-weight' 		=> false,
                    'background' 		=> false,
                    'text-align' 		=> false,
                    'text-transform'    => false,
                    'line-height' 		=> false,
                )
            ) );
            if ( function_exists( 'run_sonaar_music_pro' ) ){
                $widget_player_options->add_field( array(
                    'id'            => 'player_track_desc_style',
                    'type'          => 'typography',
                    'name'          => esc_html__('Tracklist description', 'sonaar-music'),
                    'description'   => esc_html__('Choose a font, font size and color', 'sonaar-music'),
                    'fields'        => array(
                        'font-weight' 		=> false,
                        'background' 		=> false,
                        'text-align' 		=> false,
                        'text-transform'    => false,
                        'line-height' 		=> false,
                    ),
                ) );
            }
            $widget_player_options->add_field( array(
                'id'            => 'music_player_featured_color',
                'type'          => 'colorpicker',
                'name'          => esc_html__('Tracklist Play/Pause Color', 'sonaar-music'),
                'class'         => 'color',
                'default'       => 'rgba(0, 0, 0, 1)',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            $widget_player_options->add_field( array(
                'name'          => esc_html__('Optional Calls to Action Buttons', 'sonaar-music'),
                'type'          => 'title',
                'id'            => 'CTA_Section_title'
            ) );
            $widget_player_options->add_field( array(
                'id'            => 'music_player_store_drawer',
                'type'          => 'colorpicker',
                'name'          => esc_html__('CTA 3-Dots Drawer Colors', 'sonaar-music'),
                'class'         => 'color',
                'default'       => '#BBBBBB',
                'options'       => array(
                    'alpha'         => true, // Make this a rgba color picker.
                ),
            ) );
            if ( function_exists( 'run_sonaar_music_pro' ) ){
                $widget_player_options->add_field( array(
                    'id'            => 'music_player_wc_bt_color',
                    'type'          => 'colorpicker',
                    'name'          => esc_html__('CTA Text Color', 'sonaar-music'),
                    'class'         => 'color',
                    'default'       => 'rgba(255, 255, 255, 1)',
                ) );
                $widget_player_options->add_field( array(
                    'id'            => 'music_player_wc_bt_bgcolor',
                    'type'          => 'colorpicker',
                    'name'          => esc_html__('CTA Button Color', 'sonaar-music'),
                    'class'         => 'color',
                    'default'       => 'rgba(0, 0, 0, 1)',
                    'options'       => array(
                        'alpha'         => true, // Make this a rgba color picker.
                    ),
                ) );
            }
                if ( !function_exists('run_sonaar_music_pro')){
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Pro Options', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'promo_music_player_sticky_title',
                        'after'         => 'promo_ad_cb',
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Display Volume Control', 'sonaar-music'),
                        'id'            => 'promo_player_show_volume_bt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Default Volume Controller Button', 'sonaar-music'),
                            'text'      => esc_html__('We will add a cool volume control under your player so the user may adjust the volume level. The volume level is retained in its browser session.', 'sonaar-music'),
                            'image'     => 'volume.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Display Skip 15/30 Seconds button', 'sonaar-music'),
                        'id'            => 'promo_player_show_skip_bt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => '',
                            'text'      => esc_html__('A listener just missed something in your track? Add a 15 seconds backward button so he can quickly catch-up. Same thing if he want to quickly skip a segment or two.', 'sonaar-music'),
                            'image'     => 'skip30.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Display Playback Speed Button', 'sonaar-music'),
                        'id'            => 'promo_player_show_speed_bt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Default Playback Speed', 'sonaar-music'),
                            'text'      => esc_html__('A speed rate button gives your user the ability to change the playback speed from 0.5x, 1x, 1.2x, 1.5x and 2x', 'sonaar-music'),
                            'image'     => 'speedrate.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Display Shuffle Button', 'sonaar-music'),
                        'id'            => 'promo_player_show_shuffle_bt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Default Shuffle Button', 'sonaar-music'),
                            'text'      => esc_html__('Allow the ability to shuffle the tracks randomly within the Playlist.', 'sonaar-music'),
                            'image'     => 'shuffle.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Display Dates', 'sonaar-music'),
                        'id'            => 'promo_player_show_track_publish_date',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Display Published Dates', 'sonaar-music'),
                            'text'      => esc_html__('We will display the published date for each track in the playlist. Useful if you run a podcast and you want to display dates for each of your episode in the tracklist.', 'sonaar-music'),
                            'image'     => 'tracklistdate.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Display Text label for Call-to-Action Icon', 'sonaar-music'),
                        'id'            => 'promo_show_label',
                        'type'          => 'switch',
                        'default'       => 'false',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Text Label for Call-to-Actions', 'sonaar-music'),
                            'text'      => esc_html__('When you add a call to action button for your tracks, we only show the icon by default to maximize the space for the track title. By enabling this option, we will also show its label name.', 'sonaar-music'),
                            'image'     => 'textlabel_cta.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => sprintf( esc_html__('Single %1$s Page Slug', 'sonaar-music'), ucfirst($this->sr_GetString('playlist'))),
                        'id'            => 'promo_sr_singlepost_slug',
                        'type'          => 'text_medium',
                        'attributes'    => array( 'placeholder' => $this->sr_GetString('album_slug') ),
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('Each single %2$s page has a unique URL and is represented by a slug name. You can replace it by anything you like.<br><br>eg: http://www.domain.com/<strong>%1$s</strong>/post-title', 'sonaar-music'), $this->sr_GetString('album_slug'), $this->sr_GetString('playlist')),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Category Slug', 'sonaar-music'),
                        'id'            => 'promo_sr_category_slug',
                        'type'          => 'text_medium',
                        'attributes'    => array( 'placeholder' => $this->sr_GetString('category_slug') ),
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('Each %2$s\'s category page has a unique URL and is represented by a slug name. You can replace it by anything you like.<br><br>eg: http://www.domain.com/<strong>%1$s</strong>/category-title', 'sonaar-music'), $this->sr_GetString('category_slug'), $this->sr_GetString('playlist')),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                    if (Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ){
                        $widget_player_options->add_field( array(
                            'classes'       => 'srmp3-pro-feature',
                            'name'          => esc_html__('Podcast Show Slug', 'sonaar-music'),
                            'id'            => 'promo_sr_podcastshow_slug',
                            'type'          => 'text_medium',
                            'attributes'    => array( 'placeholder' => esc_attr('podcast-show') ),
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('', 'sonaar-music'),
                                'text'      => __('A podcast show is like a podcast category but its dedicated for Podcast shows. Main difference is that the podcast show taxonomy contains your podcast settings for your RSS feed.<br><br>Each podcast show page has a unique URL and is represented by a slug name. You can replace it by anything you like.<br><br>eg: http://www.domain.com/<strong>podcast-show</strong>/show-title', 'sonaar-music'),
                                'image'     => '',
                                'pro'       => true,
                            ),
                        ) );
                    }
                    $widget_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Use Advanced Player Shortcode for the Single Post', 'sonaar-music'),
                        'id'            => 'promo_sr_single_post_use_custom_shortcode',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Custom Shortcode in Single Post', 'sonaar-music'),
                            'text'      => sprintf(__('The player in your single %3$s page can be changed/tweaked by entering our shortcode and our supported attributes.<br><br>Will override the default player widget in the single post page by your own shortcode and attributes.<br><br>View shortcode & supported attributes %1$sdocumentation%2$s', 'sonaar-music'), '<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>', $this->sr_GetString('playlist')),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                }

            
                /**
                 * Registers secondary options page, and set main item as parent.
                 */
                $args = array(
                    'id'           => 'yourprefix_secondary_options_page',
                    'title'        => esc_html__( 'Sticky Player Settings', 'sonaar-music' ),
                    'menu_title'   => esc_html__( 'Sticky Player Settings', 'sonaar-music' ),
                    'object_types' => array( 'options-page' ),
                    'option_key'   => 'srmp3_settings_sticky_player', // The option key and admin menu page slug. 'yourprefix_secondary_options',
                    'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. // 'yourprefix_main_options',
                    'tab_group'    => 'yourprefix_main_options',
                    'tab_title'    => esc_html__( 'Sticky Player', 'sonaar-music' ),
                );

                // 'tab_group' property is supported in > 2.4.0.
                if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                    $args['display_cb'] = 'yourprefix_options_display_with_tabs';
                }

                $sticky_player_options = new_cmb2_box( $args );
                array_push($options_name, $sticky_player_options);

                if ( !function_exists( 'run_sonaar_music_pro' ) ){
                    $sticky_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Sticky Player Settings', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'promo_music_player_sticky_title',
                        'after'         => 'promo_ad_cb',
                    ) );
                    $sticky_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Enable Sticky Player', 'sonaar-music'),
                        'id'            => 'promo_enable_sticky_player',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('We will automatically display the sticky footer player on your site.<br><br>Create a %1$s post in WP-Admin > MP3 Player then set your audio track(s) using our custom fields.<br><br>Come back here and choose the %1$s(s) post to play in the sticky player.<br><br>Note that you can also enable the sticky player on each player instance and widget.', 'sonaar-music'), $this->sr_GetString('playlist')),
                            'image'     => 'sticky.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Enable Continuous Player', 'sonaar-music'),
                        'id'            => 'promo_enable_continuous_player',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('Having a continuous audio playback is a stunning feature and will improve the overall UX of your website.<br><br>The concept is pretty simple. Your visitor starts the audio player from any player on your site. We save the revelant times in a cookie. When user loads a new page, everything is reloaded but the audio player resume where it left.<br><br>You can also exclude pages to prevent sticky player loads on them.<br><br>%1$sLearn More About Continuous Player%2$s', 'sonaar-music'), '<a href="https://sonaar.io/tips-and-tricks/continuous-audio-player-on-wordpress/" target="_blank">', '</a>'),
                            'image'     => 'continuous.svg',
                            'pro'       => true,
                        ),
                    ) );
                }
                if ( function_exists( 'run_sonaar_music_pro' ) ){
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Sticky Player Settings', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'music_player_sticky_title'
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__( 'Load Sticky Player on your website', 'sonaar-music'),
                        'id'            => 'overall_sticky_playlist',
                        'type'          => 'post_search_text', // This field type
                        'post_type'     => ( Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') != null ) ? Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') : SR_PLAYLIST_CPT,
                        'desc'          => sprintf(__('Enter a comma separated list of post IDs. Enter <i>latest</i> to always load the latest published %1$s post. Click the magnifying glass to search for content','sonaar-music'), $this->sr_GetString('playlist') ),
                        // Default is 'checkbox', used in the modal view to select the post type
                        'select_type'   => 'checkbox',
                        // Will replace any selection with selection from modal. Default is 'add'
                        'select_behavior' => 'add',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('We will automatically display the sticky footer player on your site.<br><br>Create a %1$s post in WP-Admin > MP3 Player then set your audio track(s) using our custom fields.<br><br>Come back here and enter the %1$s(s) post ID to play in the sticky player.<br><br>Enter \'latest\' (without single quotes) to automatically play the latest published post.<br><br>Note that you can also enable the sticky player on each player instance and widget.', 'sonaar-music'), $this->sr_GetString('playlist')),
                            'image'     => 'sticky.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Use Sticky Player in the single post', 'sonaar-music'),
                        'id'            => 'use_sticky_cpt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('Launch the sticky player when user click play from the single %1$s post page. Default is disabled.', 'sonaar-music'), $this->sr_GetString('playlist')),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Display Previous/Next button', 'sonaar-music'),
                        'id'            => 'sticky_show_nextprevious_bt',
                        'type'          => 'switch',
                        'default'       => 'true',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => esc_html__('Display the previous/next track button in the sticky player. Default is enabled.', 'sonaar-music'),
                            'image'     => 'nextprevious.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Display Skip 15/30 seconds button', 'sonaar-music'),
                        'id'            => 'sticky_show_skip_bt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => esc_html__('A listener just missed something in your track? Add a 15 seconds backward button so he can quickly catch-up. Same thing if he want to quickly skip a segment or two.', 'sonaar-music'),
                            'image'     => 'skip30.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__( 'Show Speed Lecture button (0.5x, 1x, 2x)', 'sonaar-music'),
                        'id'            => 'sticky_show_speed_bt',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Default Playback Speed', 'sonaar-music'),
                            'text'      => esc_html__('A speed rate button gives your user the ability to change the playback speed from 0.5x, 1x, 1.2x, 1.5x and 2x', 'sonaar-music'),
                            'image'     => 'speedrate.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Display Tracklist button', 'sonaar-music'),
                        'id'            => 'sticky_show_tracklist_bt',
                        'type'          => 'switch',
                        'default'       => 'true',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => esc_html__('Display a tracklist button on the sticky player to show all tracks in the playlist. Default is enabled.', 'sonaar-music'),
                            'image'     => 'tracklist.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Show Related Post in Tracklist', 'sonaar-music'),
                        'id'            => 'sticky_show_related-post',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('When enabled, we will show all tracks from all posts related to the same category than the current track being played.<br><br>These tracks will appear when tracklist button is clicked in the sticky player.<br><br>This is useful if sticky player is launched from a single post by example, and you want to show all other %1$s related to this post in the sticky.', 'sonaar-music'), $this->sr_GetString('playlist')),
                            'image'     => 'tracklist.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Display Shuffle button', 'sonaar-music'),
                        'id'            => 'sticky_show_shuffle_bt',
                        'type'          => 'switch',
                        'default'       => 'true',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => esc_html__('Allow the ability to shuffle the tracks randomly within the Playlist.', 'sonaar-music'),
                            'image'     => 'shuffle.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Sticky Player Preset', 'sonaar-music'),
                        'id'            => 'sticky_preset',
                        'type'          => 'select',
                        'options'       => array(
                            'fullwidth'         => esc_html__('Fullwidth', 'sonaar-music'),
                            'mini_fullwidth'    => esc_html__('Mini Fullwidth', 'sonaar-music'),
                            'float'             => esc_html__('Float', 'sonaar-music'),
                        ),
                        'default'       => 'fullwidth',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => __('We have 3 different layouts for the sticky player. <br><br><strong>Fullwidth</strong> is a full width and 90px tall player.<br><br><strong>Mini Fullwidth</strong> is a full width player but 42px tall.<br><br><strong>Float</strong> is a floated & draggable sticky player that can be positioned on the left, center or right bottom of your screen. It\'s more discreet.', 'sonaar-music'),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Float Position', 'sonaar-music'),
                        'id'            => 'float_pos',
                        'type'          => 'select',
                        'options'       => array(
                            'left'         => esc_html__('Left', 'sonaar-music'),
                            'center'    => esc_html__('Center', 'sonaar-music'),
                            'right'             => esc_html__('Right (Default)', 'sonaar-music'),
                        ),
                        'default'       => 'right',
                        'attributes'  => array(
                            'data-conditional-id'    => 'sticky_preset',
                            'data-conditional-value' => wp_json_encode( array( 'float' ) ),
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Allow users to drag the player', 'sonaar-music'),
                        'id'            => 'make_draggable',
                        'type'          => 'switch',
                        'default'       => 0,
                        'attributes'  => array(
                            'data-conditional-id'    => 'sticky_preset',
                            'data-conditional-value' => wp_json_encode( array( 'float' ) ),
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Sticky Roundness (px)', 'sonaar-music'),
                        'id'            => 'float_radius',
                        'type'          => 'text_small',
                        'default'       => 30,
                        'attributes'  => array(
                            'data-conditional-id'    => 'sticky_preset',
                            'data-conditional-value' => wp_json_encode( array( 'float' ) ),
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Show Controls on Hover Only', 'sonaar-music'),
                        'desc'          => esc_html__('User have to hover sticky player to display controls','sonaar-music'),
                        'id'            => 'show_controls_hover',
                        'type'          => 'switch',
                        'default'       => 1,
                        'attributes'  => array(
                            'data-conditional-id'    => 'sticky_preset',
                            'data-conditional-value' => wp_json_encode( array( 'float' ) ),
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Hide Progress Bar', 'sonaar-music'),
                        'id'            => 'sticky_hide_progress_bar',
                        'type'          => 'switch',
                        'default'       => 1,
                        'attributes'  => array(
                            'data-conditional-id'    => 'sticky_preset',
                            'data-conditional-value' => wp_json_encode( array( 'float' ) ),
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Enable Continuous Player', 'sonaar-music'),
                        'id'            => 'enable_continuous_player',
                        'type'          => 'switch',
                        'default'       => 0,
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('Having a continuous audio playback is a stunning feature and will improve the overall UX of your website.<br><br>The concept is pretty simple. Your visitor starts the audio player from any player on your site. We save the revelant times in a cookie. When user loads a new page, everything is reloaded but the audio player resume where it left.<br><br>You can also exclude pages to prevent sticky player loads on them.<br><br>%1$sLearn More About Continuous Player%2$s', 'sonaar-music'), '<a href="https://sonaar.io/tips-and-tricks/continuous-audio-player-on-wordpress/" target="_blank">', '</a>'),
                            'image'     => 'continuous.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'              => esc_html__('Exclude Continuous Player on the following slug URL(s)  ', 'sonaar-music'),
                        'id'                => 'sr_prevent_continuous_url',
                        'type'              => 'textarea_small',
                        'desc'              => esc_html__('Always prevent Continuous Player to play on the specified URL. One path URL per line (eg: /cart/ )', 'sonaar-music'),
                        'attributes'    => array(
                            'data-conditional-id'    => 'enable_continuous_player',
                            'data-conditional-value' => 'true',
                        ),
                    ));
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Enable shuffle mode', 'sonaar-music'),
                        'id'            => 'overall_shuffle',
                        'type'          => 'checkbox',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => esc_html__('When the sticky footer player kicks in, we will automatically set the shuffle mode On so the tracks play randomly.', 'sonaar-music'),
                            'image'     => 'shuffle.svg',
                            'pro'       => true,
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'name'          => esc_html__('Sticky Player Typography and Colors', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'music_player_sticky_lookandfeel_title'
                    ) );
                    $sticky_player_options->add_field( array(
                        'id'            => 'sticky_player_typo',
                        'type'          => 'typography',
                        'name'          => esc_html__('Typography', 'sonaar-music'),
                        'fields'        => array(
                            'font-weight'       => false,
                            'background'        => false,
                            'text-align'        => false,
                            'text-transform'    => false,
                            'line-height'       => false,
                        )
                    ) );
                    $sticky_player_options->add_field( array(
                        'id'            => 'sticky_player_featured_color',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('Featured Color', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => 'rgba(116, 221, 199, 1)',
                        'options'       => array(
                            'alpha'         => true, // Make this a rgba color picker.
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'id'            => 'sticky_player_labelsandbuttons',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('Labels and Buttons', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => 'rgba(255, 255, 255, 1)',
                        'options'       => array(
                            'alpha'         => true, // Make this a rgba color picker.
                        ),
                    ) );            
                    $sticky_player_options->add_field( array(
                        'id'            => 'sticky_player_soundwave_bars',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('SoundWave/Timeline Container Bar', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => 'rgba(79, 79, 79, 1)',
                        'options'       => array(
                            'alpha'         => true, // Make this a rgba color picker.
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'id'            => 'sticky_player_soundwave_progress_bars',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('SoundWave/Timeline Progress Bar', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => 'rgba(116, 221, 199, 1)',
                        'options'       => array(
                            'alpha'         => true, // Make this a rgba color picker.
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'id'            => 'mobile_progress_bars',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('Mobile Progress Bars', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => '',
                        'options'       => array(
                            'alpha'         => true, // Make this a rgba color picker.
                        ),
                    ) );
                    $sticky_player_options->add_field( array(
                        'id'            => 'sticky_player_background',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('Sticky Background Color', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => 'rgba(0, 0, 0, 1)',
                        'options'       => array(
                            'alpha'         => true, // Make this a rgba color picker.
                        ),
                    ) ); 
            }

                if ( defined( 'WC_VERSION' )) {
                    /**
                     * Registers tertiary options page, and set main item as parent.
                     */
                    $args = array(
                        'id'           => 'yourprefix_tertiary_options_page',
                        'menu_title'   => esc_html__( 'WooCommerce Settings', 'sonaar-music' ),
                        'title'        => esc_html__( 'WooCommerce Settings', 'sonaar-music' ),
                        'object_types' => array( 'options-page' ),
                        'option_key'   => 'srmp3_settings_woocommerce', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
                        'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. //'yourprefix_main_options',
                        'tab_group'    => 'yourprefix_main_options',
                        'tab_title'    => esc_html__( 'WooCommerce', 'sonaar-music' ),
                    );

                    // 'tab_group' property is supported in > 2.4.0.
                    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                        $args['display_cb'] = 'yourprefix_options_display_with_tabs';
                    }

                    $woocommerce_options = new_cmb2_box( $args );
                    array_push($options_name, $woocommerce_options);

                    if ( !function_exists( 'run_sonaar_music_pro' ) || get_site_option('SRMP3_ecommerce') != '1'){
                        $woocommerce_options->add_field( array(
                            'classes'       => 'srmp3-pro-feature',
                            'name'          => esc_html__('WooCommerce Setting', 'sonaar-music'),
                            'type'          => 'title',
                            'id'            => 'promo_music_player_sticky_title',
                            'after'         => 'promo_ad_cb',
                            'options' => array(
                                'textpromo' => esc_html__('Pro WooCommerce Feature | Upgrade to Pro', 'sonaar-music'),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'classes'       => 'srmp3-pro-feature',
                            'name'          => esc_html__('Enable Player in WooCommerce Grid', 'sonaar-music'),
                            'type'          => 'switch',
                            'default'       => 'false',
                            'id'            => 'promo_sr_woo_shop_setting_heading',
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('WC Shop Loop', 'sonaar-music'),
                                'text'      => __('When you display your WooCommerce products in a grid, shop page or archive, you may want to display audio players on each instance.<br><br>You can choose to display audio controls over or below the thumbnail.', 'sonaar-music'),
                                'image'     => 'wc_shoploop.svg',
                                'pro'       => true,
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'classes'       => 'srmp3-pro-feature',
                            'name'          => esc_html__('Enable Player in WooCommerce Page', 'sonaar-music'),
                            'type'          => 'switch',
                            'default'       => 'false',
                            'id'            => 'promo_sr_enable_player_wc_page',
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('Enable Player in WC Single Page', 'sonaar-music'),
                                'text'      => sprintf(__('For each single product page, we automatically display the audio player if you have set tracks using our custom fields.<br><br>The player is shown within the product\'s detail page.
                                You can either use the settings below to setup the player layout, or use our shortcode with any of our supported attributes for more flexibility.<br><br>
                                View shortcode & supported attributes %1$sdocumentation%2$s.', 'sonaar-music'),'<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>' ),
                                'image'     => '',
                                'pro'       => true,
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'classes'       => 'srmp3-pro-feature',
                            'name'          => esc_html__('WooCommerce CTA Buttons in tracklist', 'sonaar-music'),
                            'id'            => 'promo_wc_bt_type',
                            'type'          => 'select',
                            'options'       => array(
                                'wc_bt_type_label_price'    => 'Label + Price',
                                'wc_bt_type_label'          => 'Label Only',
                                'wc_bt_type_price'          => 'Price Only',
                                'wc_bt_type_inactive'       => 'Inactive',
                            ),
                            'default'       => 'wc_bt_type_price',
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('Call-to-Action Buttons', 'sonaar-music'),
                                'text'      => __('When tracks are added through a WooCommerce product post, we automatically display Buy Now / Add to Cart call-to-action buttons beside each track.<br><br>
                                Here you can set what to display in the call-to-action buttons.<br><br>
                                Example:<br><br>
                                <strong>Label + Price</strong> = [ Buy Now $9.99 ]<br>
                                <strong>Label Only</strong> = [ Buy Now ]<br>
                                <strong>Price Only</strong> = [ $9.99 ]<br>
                                <strong>Inactive</strong> = No button will be displayed<br><br>
                                You can disable call-to-action buttons for specific products by editing the product post.<br><br>
                                You can change or translate the label strings below.', 'sonaar-music'),
                                'image'     => 'woocommerce_cta.svg',
                                'pro'       => true,
                            ),
                        ) );
                        
                    }
                    if ( function_exists( 'run_sonaar_music_pro' ) && get_site_option('SRMP3_ecommerce') == '1'){
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('WooCommerce CTA Buttons in tracklist', 'sonaar-music'),
                            'id'            => 'wc_bt_type',
                            'type'          => 'select',
                            'options'       => array(
                                'wc_bt_type_label_price'    => 'Label + Price',
                                'wc_bt_type_label'          => 'Label Only',
                                'wc_bt_type_price'          => 'Price Only',
                                'wc_bt_type_inactive'       => 'Inactive',
                            ),
                            'default'       => 'wc_bt_type_price',
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('Call-to-Action Buttons', 'sonaar-music'),
                                'text'      => __('When tracks are added through a WooCommerce product post, we automatically display Buy Now / Add to Cart call-to-action buttons beside each track.<br><br>
                                Here you can set what to display in the call-to-action buttons.<br><br>
                                Example:<br><br>
                                <strong>Label + Price</strong> = [ Buy Now $9.99 ]<br>
                                <strong>Label Only</strong> = [ Buy Now ]<br>
                                <strong>Price Only</strong> = [ $9.99 ]<br>
                                <strong>Inactive</strong> = No button will be displayed<br><br>
                                You can disable call-to-action buttons for specific products by editing the product post.<br><br>
                                You can change or translate the label strings below.', 'sonaar-music'),
                                'image'     => 'woocommerce_cta.svg',
                                'pro'       => true,
                            ),
                        ) ); 
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Add to Cart Label', 'sonaar-music'),
                            'id'            => 'wc_add_to_cart_text',
                            'type'          => 'text_medium',
                            'default'       => esc_html__('', 'sonaar-music'),
                            'attributes'  => array(
                                'placeholder' => 'Add to Cart',
                                'data-conditional-id'    => 'wc_bt_type',
                                'data-conditional-value' => wp_json_encode( array( 'wc_bt_type_label_price', 'wc_bt_type_label' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Buy Now Label', 'sonaar-music'),
                            'id'            => 'wc_buynow_text',
                            'type'          => 'text_medium',
                            'default'       => esc_html__('', 'sonaar-music'),
                            'attributes'  => array(
                                'placeholder' => 'Buy Now',
                                'data-conditional-id'    => 'wc_bt_type',
                                'data-conditional-value' => wp_json_encode( array( 'wc_bt_type_label_price', 'wc_bt_type_label' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('WooCommerce CTA - Show Icon', 'sonaar-music'),
                            'id'            => 'wc_bt_show_icon',
                            'type'          => 'switch',
                            'default'       => 'true',
                            'attributes'  => array(
                                'data-conditional-id'    => 'wc_bt_type',
                                'data-conditional-value' => wp_json_encode( array( 'wc_bt_type_label_price', 'wc_bt_type_label', 'wc_bt_type_price' ) ),
                            ),
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('', 'sonaar-music'),
                                'text'      => esc_html__('When option is disable, we remove the small cart icon beside the text label', 'sonaar-music'),
                                'image'     => 'wc_noicon.svg',
                                'pro'       => true,
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('WooCommerce Shop Loop/Archive Page', 'sonaar-music'),
                            'type'          => 'title',
                            'id'            => 'sr_woo_shop_setting_heading',
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('WC Shop Loop', 'sonaar-music'),
                                'text'      => __('When you display your WooCommerce products in a grid, shop page or archive, you may want to display audio players on each instance.<br><br>You can choose to display audio controls over or below the thumbnail.', 'sonaar-music'),
                                'image'     => 'wc_shoploop.svg',
                                'pro'       => true,
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Player Position', 'sonaar-music'),
                            'id'            => 'sr_woo_shop_position',
                            'type'          => 'select',
                            'options'       => array(
                                'disable'   => esc_html__('Inactive', 'sonaar-music'),
                                'over_image'    => esc_html__('Over the image', 'sonaar-music'),
                                'before'    => esc_html__('Before the title', 'sonaar-music'),
                                'after'     => esc_html__('After the title', 'sonaar-music'),
                                'after_item'     => esc_html__('After the block item', 'sonaar-music'),
                            ),
                            'default'       => 'disable'
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Design Preset', 'sonaar-music'),
                            'id'            => 'sr_woo_skin_shop',
                            'type'          => 'select',
                            'options'       => array(
                            // 'over_image'            => esc_html__('Player Over Image', 'sonaar-music'),
                                'preset'                => esc_html__('Use Settings Below', 'sonaar-music'),
                                'custom_shortcode'      => esc_html__('Custom Shortcode', 'sonaar-music'),
                            ),
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_shop_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'after_item' ) ),
                            ),
                            //'default'       => 'over_image'
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Player Shortcode', 'sonaar-music'),
                            'type'          => 'textarea_small',
                            'id'            => 'sr_woo_shop_player_shortcode',
                            'description'          => sprintf( wp_kses( __('For shortcode attributes, %1$s read this article%2$s.','sonaar-music'), $escapedVar), '<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>'),
                            'default'       => '[sonaar_audioplayer sticky_player="true" hide_artwork="true" show_playlist="false" show_track_market="false" show_album_market="false" hide_progressbar="false" hide_times="true" hide_track_title="true"]',
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_skin_shop',
                                'data-conditional-value' => wp_json_encode( array( 'custom_shortcode' ) ),
                            ),
        
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Remove WooCommerce Featured Image', 'sonaar-music'),                
                            'id'            => 'remove_wc_featured_image',
                            'type'          => 'switch',
                            'default'       => 0,
                            
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_shop_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'after_item' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Sticky Player on Play', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_shop_attr_sticky_player',
                            'type'          => 'switch',
                            'default'       => 1,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_shop_position',
                                'data-conditional-value' => wp_json_encode( array( 'over_image', 'before', 'after', 'after_item' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Tracklist', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_shop_attr_tracklist',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_shop_position',
                                'data-conditional-value' => wp_json_encode( array( 'over_image', 'before', 'after', 'after_item' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Progress Bar', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_shop_attr_progressbar',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_shop_position',
                                'data-conditional-value' => wp_json_encode( array( 'over_image', 'before', 'after', 'after_item' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Progress Bar Inline', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_shop_attr_progress_inline',
                            'type'          => 'switch',
                            'default'       => 1,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_shop_position',
                                'data-conditional-value' => wp_json_encode( array( 'over_image', 'before', 'after', 'after_item' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('WooCommerce PRODUCT Page', 'sonaar-music'),
                            'type'          => 'title',
                            'id'            => 'sr_woo_product_setting_heading',
                            'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('', 'sonaar-music'),
                                'text'      => sprintf(__('For each single product page, we automatically display the audio player if you have set tracks using our custom fields.<br><br>The player is shown within the product\'s detail page.
                                You can either use the settings below to setup the player layout, or use our shortcode with any of our supported attributes for more flexibility.<br><br>
                                View shortcode & supported attributes %1$sdocumentation%2$s.', 'sonaar-music'),'<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>' ),
                                'image'     => '',
                                'pro'       => true,
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Player Position', 'sonaar-music'),
                            'id'            => 'sr_woo_product_position',
                            'type'          => 'select',
                            'options'       => array(
                                'disable'   => esc_html__('Inactive', 'sonaar-music'),
                                'before'    => esc_html__('Before the title', 'sonaar-music'),
                                'after'     => esc_html__('After the title', 'sonaar-music'),
                                'before_rating'     => esc_html__('Before the rating', 'sonaar-music'),
                                'after_price'     => esc_html__('After the price', 'sonaar-music'),
                                'after_add_to_cart'     => esc_html__('After Add to Cart', 'sonaar-music'),
                                'before_excerpt'     => esc_html__('Before short description', 'sonaar-music'),
                                'after_excerpt'     => esc_html__('After short description', 'sonaar-music'),
                                'before_meta'     => esc_html__('Before metadata', 'sonaar-music'),
                                'after_meta'     => esc_html__('After metadata', 'sonaar-music'),
                                'after_summary'     => esc_html__('After the summary', 'sonaar-music'),
                            ),
                            'default'       => 'disable'
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Design Preset', 'sonaar-music'),
                            'id'            => 'sr_woo_skin_product',
                            'type'          => 'select',
                            'options'       => array(
                            // 'over_image'            => esc_html__('Player Over Image', 'sonaar-music'),
                                'preset'                => esc_html__('Use Settings Below', 'sonaar-music'),
                                'custom_shortcode'      => esc_html__('Custom Shortcode', 'sonaar-music'),
                            ),
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                            //'default'       => 'over_image'
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('WooCommerce Product Player Shortcode', 'sonaar-music'),
                            'type'          => 'textarea_small',
                            'id'            => 'sr_woo_product_player_shortcode',
                            'desc'          => sprintf( wp_kses( __('For shortcode attributes, %1$s read this article%2$s.','sonaar-music'), $escapedVar), '<a href="https://sonaar.io/go/mp3player-shortcode-attributes" target="_blank">', '</a>'),
                            'default'       => '[sonaar_audioplayer sticky_player="true" hide_artwork="true" show_playlist="false" show_track_market="false" show_album_market="false" hide_progressbar="false" hide_times="true" hide_track_title="true"]',
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_skin_product',
                                'data-conditional-value' => wp_json_encode( array( 'custom_shortcode' ) ),
                            ),
        
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Sticky Player on Play', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_sticky_player',
                            'type'          => 'switch',
                            'default'       => 1,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Tracklist', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_tracklist',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Tracklist Title', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_albumtitle',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Tracklist Subtitle', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_albumsubtitle',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Progress Bar', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_progressbar',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Progress Bar Inline', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_progress_inline',
                            'type'          => 'switch',
                            'default'       => 1,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                        $woocommerce_options->add_field( array(
                            'name'          => esc_html__('Display Control Buttons', 'sonaar-music'),                
                            'id'            => 'sr_woo_skin_product_attr_control',
                            'type'          => 'switch',
                            'default'       => 0,
                            'attributes'    => array(
                                'data-conditional-id'    => 'sr_woo_product_position',
                                'data-conditional-value' => wp_json_encode( array( 'before', 'after', 'before_rating','after_price', 'after_add_to_cart', 'before_excerpt', 'after_excerpt', 'before_meta', 'after_meta', 'after_summary' ) ),
                            ),
                        ) );
                }
            }

           
                /**
                 * Registers fifth options page, and set main item as parent.
                 */
                $args = array(
                    'id'           => 'yourprefix_fifth_options_page',
                    'menu_title'   => esc_html__( 'Popup Settings', 'sonaar-music' ),
                    'title'        => esc_html__( 'Popup Call-to-Action Settings', 'sonaar-music' ),
                    'object_types' => array( 'options-page' ),
                    'option_key'   => 'srmp3_settings_popup', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
                    'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. //'yourprefix_main_options',
                    'tab_group'    => 'yourprefix_main_options',
                    'tab_title'    => esc_html__( 'Track Popup', 'sonaar-music' ),
                );

                // 'tab_group' property is supported in > 2.4.0.
                if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                    $args['display_cb'] = 'yourprefix_options_display_with_tabs';
                }

                $popup_options = new_cmb2_box( $args );
                array_push($options_name, $popup_options);
                if (!function_exists( 'run_sonaar_music_pro' ) ){
                     // POP-UP IF PRO PLUGIN IS INSTALLED
                     $popup_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Call to Action Pop-up', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'promo_music_player_sticky_title',
                        'after'         => 'promo_ad_cb',
                    ) );
                     $popup_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Enable Call-to-Action Pop-up', 'sonaar-music'),
                        'type'          => 'switch',
                        'default'       => 0,
                        'id'            => 'promo_cta-popup',
                        'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('', 'sonaar-music'),
                                'text'      => sprintf(__('You can display call-to-action buttons beside each track, by editing your %1$s\'s post.<br><br>For each button, you can choose its action between a link URL or a Popup to display content such as text, forms or any third party plugin shortcodes in a popup window.<br><br>
                                You can also display track description and we will display it within a lightbox. Useful for episode and show notes!<br><br>
                                This is the popup lightbox look and feel settings', 'sonaar-music'), $this->sr_GetString('playlist')),
                                'image'     => 'popup.svg',
                                'pro'       => true,
                            ),
                    ) );

                }
                if ( function_exists( 'run_sonaar_music_pro' ) ){
                    // POP-UP IF PRO PLUGIN IS INSTALLED
                    $popup_options->add_field( array(
                        'name'          => esc_html__('Call to Action Pop-up', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'cta-popup',
                        'after'         => 'srmp3_add_tooltip_to_label',
                            'tooltip'       => array(
                                'title'     => esc_html__('', 'sonaar-music'),
                                'text'      => sprintf(__('You can display call-to-action buttons beside each track, by editing your %1$s\'s post.<br><br>For each button, you can choose its action between a link URL or a Popup to display content such as text, forms or any third party plugin shortcodes in a popup window.<br><br>
                                You can also display track description and we will display it within a lightbox. Useful for episode and show notes!<br><br>
                                This is the popup lightbox look and feel settings', 'sonaar-music'), $this->sr_GetString('playlist')),
                                'image'     => 'popup.svg',
                                'pro'       => true,
                            ),
                    ) );
                    $popup_options->add_field( array(
                        'id'            => 'cta-popup-typography',
                        'type'          => 'typography',
                        'name'          => esc_html__('Typography', 'sonaar-music'),
                        'fields'        => array(
                            'font-weight'       => false,
                            'background'        => false,
                            'text-align'        => false,
                            'text-transform'    => false,
                            'line-height'       => false,
                        )
                    ) );
                    $popup_options->add_field( array(
                        'id'            => 'cta-popup-close-btn-color',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('Close button color', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => '#000000',
                        'options'       => array(
                            'alpha'         => false,
                        ),
                    ) ); 
                    $popup_options->add_field( array(
                        'id'            => 'cta-popup-background',
                        'type'          => 'colorpicker',
                        'name'          => esc_html__('Background Color', 'sonaar-music'),
                        'class'         => 'color',
                        'default'       => '#ffffff',
                        'options'       => array(
                            'alpha'         => false,
                        ),
                    ) );          
                }
                 /**
                 * Registers fifth options page, and set main item as parent.
                 */
                $args = array(
                    'id'           => 'yourprefix_sixth_options_page',
                    'menu_title'   => esc_html__( 'Stats & Reports', 'sonaar-music' ),
                    'title'        => esc_html__( 'Statistic & Report Settings', 'sonaar-music' ),
                    'object_types' => array( 'options-page' ),
                    'option_key'   => 'srmp3_settings_stats', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
                    'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. //'yourprefix_main_options',
                    'tab_group'    => 'yourprefix_main_options',
                    'tab_title'    => esc_html__( 'Stats & Reports', 'sonaar-music' ),
                );

                // 'tab_group' property is supported in > 2.4.0.
                if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                    $args['display_cb'] = 'yourprefix_options_display_with_tabs';
                }

                $stats_options = new_cmb2_box( $args );
                array_push($options_name, $stats_options);
                if (!function_exists( 'run_sonaar_music_pro' ) || !get_site_option( 'sonaar_music_licence', '' )){
                     $stats_options->add_field( array(
                        'classes'       => 'srmp3-pro-feature',
                        'name'          => esc_html__('Statistic & Report', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'promo_music_player_sticky_title',
                        'after'         => 'promo_ad_cb',
                        'options' => array(
                            'textpromo' => esc_html__('PRO LICENCE REQUIRED | UPGRADE TO PRO', 'sonaar-music'),
                        ),
                    ) );
                    $stats_options->add_field( array(
                        'name'          => esc_html__('Google Analytics Tracking Code', 'sonaar-music'),
                        'classes'       => 'srmp3-pro-feature',
                        'id'            => 'promo_srmp3_ga_tag',
                        'type'          => 'text_medium',
                        'attributes'    => array( 'placeholder' => esc_html__( "UA-XXXXXXXXX-X", 'sonaar-music' ) ),
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('MP3 Audio Player PRO can connect to your Google Analytics so you will receive statistics report such as number of plays and number of downloads for each tracks directly in your Google Analytics Dashboard. All you need is a %1$sGoogle Analytics%2$s account.<br><br>Read %3$sthis article%2$s to learn more', 'sonaar-music'), '<a href="http://www.google.com/analytics/" target="_blank">', '</a>', '<a href="https://sonaar.ticksy.com/article/17737/" target="_blank">'),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                }
                if ( function_exists( 'run_sonaar_music_pro' ) && get_site_option( 'sonaar_music_licence', '' )){
                    // POP-UP IF PRO PLUGIN IS INSTALLED
                    $stats_options->add_field( array(
                        'name'          => esc_html__('Stats & Report', 'sonaar-music'),
                        'type'          => 'title',
                        'id'            => 'stats_report_title',
                    ) );
                    $stats_options->add_field( array(
                        'name'          => esc_html__('Google Analytics Tracking Code', 'sonaar-music'),
                        'id'            => 'srmp3_ga_tag',
                        'type'          => 'text_medium',
                        'attributes'    => array( 'placeholder' => esc_html__( "UA-XXXXXXXXX-X", 'sonaar-music' ) ),
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('', 'sonaar-music'),
                            'text'      => sprintf(__('MP3 Audio Player PRO can connect to your Google Analytics so you will receive statistics report such as number of plays and number of downloads for each tracks directly in your Google Analytics Dashboard. All you need is a %1$sGoogle Analytics%2$s account.<br><br>Read %3$sthis article%2$s to learn more', 'sonaar-music'), '<a href="http://www.google.com/analytics/" target="_blank">', '</a>', '<a href="https://sonaar.ticksy.com/article/17737/" target="_blank">'),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                    $stats_options->add_field( array(
                        'name'          => esc_html__('Use Built-In Stats Report (Deprecated)', 'sonaar-music'),
                        'id'            => 'srmp3_use_built_in_stats',
                        'type'          => 'switch',
                        'after'         => 'srmp3_add_tooltip_to_label',
                        'tooltip'       => array(
                            'title'     => esc_html__('Deprecated Option', 'sonaar-music'),
                            'text'      => esc_html__('This option is deprecated and will be removed in the next update. Use Google Analytics instead.', 'sonaar-music'),
                            'image'     => '',
                            'pro'       => true,
                        ),
                    ) );
                }
/**
             * Registers Settings Tools options page, and set main item as parent.
             */
            $args = array(
                'id'           => 'srmp3_settings_tools',
                'menu_title'   => esc_html__( 'Import', 'sonaar-music' ),
                'title'        => esc_html__( 'Tools & Importer', 'sonaar-music' ),
                'object_types' => array( 'options-page' ),
                'option_key'   => 'srmp3_settings_tools', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
                'parent_slug'  => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu. //'yourprefix_main_options',
                'tab_group'    => 'yourprefix_main_options',
                'tab_title'    => esc_html__( 'Tools / Import', 'sonaar-music' ),
            );
            $setting_tools = new_cmb2_box( $args );

            if (Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ){
                $setting_tools->add_field( array(
                    'name'          => esc_html__('Podcast RSS Importer', 'sonaar-music'),
                    'type'          => 'title',
                    'description'   => sprintf( __( '%1$sImport your existing Podcast Episodes%2$s by using your RSS Feed URL provided by your Podcast provider. We support all major podcast distributors!', 'sonaar-music' ), '<a href="' . esc_url(get_admin_url( null, 'admin.php?import=podcast-rss' )) . '" target="' . wp_strip_all_tags( '_self' ) . '">', '</a>' ),
                    'id'            => 'srtools_podcast_importer'
                ) );
                if ( !function_exists('run_sonaar_music_pro')){
                    $setting_tools->add_field( array(
                        'name'          => esc_html__('Podcast Fetcher : Automatically import New Episode', 'sonaar-music'),
                        'after'         => 'promo_ad_cb',
                        'classes'       => array('srmp3-pro-feature', 'prolabel--nomargin', 'prolabel--nohide'),
                        'type'          => 'title',
                        'description'   => sprintf( __( 'Give you the ability to automatically fetch/import new episodes on your website from your existing Podcast distributor as soon as a new episode came out! %1$sLearn More%2$s ', 'sonaar-music' ), '<a href="https://sonaar.ticksy.com/article/17664" target="_blank">', '</a>' ),
                        'id'            => 'srtools_podcast_importer_cron'
                    ) );
                }else{
                    $setting_tools->add_field( array(
                        'name'          => esc_html__('Podcast Fetcher : Automatically import New Episode', 'sonaar-music'),
                        'type'          => 'title',
                        'description'   => sprintf( __( 'Give you the ability to automatically fetch/import new episodes on your website from your existing Podcast distributor as soon as a new episode came out! %1$sLearn More%2$s ', 'sonaar-music' ), '<a href="https://sonaar.ticksy.com/article/17664" target="_blank">', '</a>' ),
                        'id'            => 'srtools_podcast_importer_cron'
                    ) );
                }
            }
            if ( !function_exists('run_sonaar_music_pro')){
                $setting_tools->add_field( array(
                    'after'         => 'promo_ad_cb',
                    //'classes'       => array('srmp3-pro-feature', 'prolabel--nomargin', 'prolabel--nohide'),
                    'classes'       => array('srmp3-pro-feature', 'prolabel--nomargin', 'prolabel--nohide'),
                    'name'          => esc_html__('MP3 Bulk Importer', 'sonaar-music'),
                    'type'          => 'title',
                    'description'   =>  esc_html__( 'Import MP3 Files and create post(s) or product(s) in 1-click!', 'sonaar-music' ),
                    'id'            => 'srtools_importer'
                ) );
            }else{
                $setting_tools->add_field( array(
                    'name'          => esc_html__('MP3 Bulk Importer', 'sonaar-music'),
                    'type'          => 'title',
                    'description'   => sprintf( __( '%1$sImport MP3 Files and create post(s) or product(s) in 1-click!%2$s', 'sonaar-music' ), '<a href="' . esc_url(get_admin_url( null, 'edit.php?post_type=' . SR_PLAYLIST_CPT . '&page=sonaar_music_pro_tools' )) . '" target="' . wp_strip_all_tags( '_self' ) . '">', '</a>' ),
                    'id'            => 'srtools_importer'
                ) );
            }
            // 'tab_group' property is supported in > 2.4.0.
            if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
                $args['display_cb'] = 'yourprefix_options_display_with_tabs';
            }
            $category_options = array(
                'Arts'                       => esc_html__( 'Arts', 'sonaar' ),
                'Business'                   => esc_html__( 'Business', 'sonaar' ),
                'Comedy'                     => esc_html__( 'Comedy', 'sonaar' ),
                'Education'                  => esc_html__( 'Education', 'sonaar' ),
                'Fiction'                  	 => esc_html__( 'Fiction', 'sonaar' ),
                'Government' 				 => esc_html__( 'Government', 'sonaar' ),
                'Health & Fitness'           => esc_html__( 'Health & Fitness', 'sonaar' ),
                'History'           		 => esc_html__( 'History', 'sonaar' ),
                'Kids & Family'              => esc_html__( 'Kids & Family', 'sonaar' ),
                'Leisure'           		 => esc_html__( 'Leisure', 'sonaar' ),
                'Music'                      => esc_html__( 'Music', 'sonaar' ),
                'News'           			 => esc_html__( 'News', 'sonaar' ),
                'Religion & Spirituality'    => esc_html__( 'Religion & Spirituality', 'sonaar' ),
                'Science'        			 => esc_html__( 'Science', 'sonaar' ),
                'Society & Culture'          => esc_html__( 'Society & Culture', 'sonaar' ),
                'Sports'        			 => esc_html__( 'Sports', 'sonaar' ),
                'Technology'                 => esc_html__( 'Technology', 'sonaar' ),
                'True Crime'                 => esc_html__( 'True Crime', 'sonaar' ),
                'TV & Film'                  => esc_html__( 'TV & Film', 'sonaar' ),
            );
            $subcategory_options = array(
                'None'                       => esc_html__( '-- None --', 'sonaar' ),
    
                'Books'                      => esc_html__( 'Arts > Books', 'sonaar' ),
                'Design'                     => esc_html__( 'Arts > Design', 'sonaar' ),
                'Fashion & Beauty'           => esc_html__( 'Arts > Fashion & Beauty', 'sonaar' ),
                'Food'                       => esc_html__( 'Arts > Food', 'sonaar' ),
                'Performing Arts'            => esc_html__( 'Arts > Performing Arts', 'sonaar' ),
                'Visual Arts'                => esc_html__( 'Arts > Visual Arts', 'sonaar' ),
    
                'Careers'                    => esc_html__( 'Business > Careers', 'sonaar' ),
                'Enterpreneurship'           => esc_html__( 'Business > Enterpreneurship', 'sonaar' ),
                'Investing'                  => esc_html__( 'Business > Investing', 'sonaar' ),
                'Management'                 => esc_html__( 'Business > Management', 'sonaar' ),
                'Marketing'                  => esc_html__( 'Business > Marketing', 'sonaar' ),
                'Non-profit'                 => esc_html__( 'Business > Non-profit', 'sonaar' ),
    
                'Comedy Interviews'          => esc_html__( 'Comedy > Comedy Interviews', 'sonaar' ),
                'Improv'                     => esc_html__( 'Comedy > Improv', 'sonaar' ),
                'Standup'                    => esc_html__( 'Comedy > Standup', 'sonaar' ),
    
                'Courses'                    => esc_html__( 'Education > Courses', 'sonaar' ),
                'How to'                     => esc_html__( 'Education > How to', 'sonaar' ),
                'Language Learning'          => esc_html__( 'Education > Language Learning', 'sonaar' ),
                'Self Improvement'           => esc_html__( 'Education > Self Improvement', 'sonaar' ),
    
                'Comedy Fiction'             => esc_html__( 'Fiction > Comedy Fiction', 'sonaar' ),
                'Drama'                      => esc_html__( 'Fiction > Drama', 'sonaar' ),
                'Science Fiction'            => esc_html__( 'Fiction > Science Fiction', 'sonaar' ),
    
                'Alternative Health'         => esc_html__( 'Health & Fitness > Alternative Health', 'sonaar' ),
                'Fitness'                    => esc_html__( 'Health & Fitness > Fitness', 'sonaar' ),
                'Medicine'                   => esc_html__( 'Health & Fitness > Medicine', 'sonaar' ),
                'Mental Health'              => esc_html__( 'Health & Fitness > Mental Health', 'sonaar' ),
                'Nutrition'                  => esc_html__( 'Health & Fitness > Nutrition', 'sonaar' ),
                'Sexuality'                  => esc_html__( 'Health & Fitness > Sexuality', 'sonaar' ),
    
                'Education for Kids'         => esc_html__( 'Kids & Family > Education for Kids', 'sonaar' ),
                'Parenting'                  => esc_html__( 'Kids & Family > Parenting', 'sonaar' ),
                'Pets & Animals'             => esc_html__( 'Kids & Family > Pets & Animals', 'sonaar' ),
                'Stories for Kids'           => esc_html__( 'Kids & Family > Stories for Kids', 'sonaar' ),
    
                'Animation & Manga'          => esc_html__( 'Leisure > Animation & Manga', 'sonaar' ),
                'Automotive'                 => esc_html__( 'Leisure > Automotive', 'sonaar' ),
                'Aviation'                   => esc_html__( 'Leisure > Aviation', 'sonaar' ),
                'Crafts'                     => esc_html__( 'Leisure > Crafts', 'sonaar' ),
                'Games'                      => esc_html__( 'Leisure > Games', 'sonaar' ),
                'Hobbies'                    => esc_html__( 'Leisure > Hobbies', 'sonaar' ),
                'Home & Garden'              => esc_html__( 'Leisure > Home & Garden', 'sonaar' ),
                'Video Games'                => esc_html__( 'Leisure > Video Games', 'sonaar' ),
    
                'Music Commentary'           => esc_html__( 'Music > Music Commentary', 'sonaar' ),
                'Music History'              => esc_html__( 'Music > Music History', 'sonaar' ),
                'Music Interviews'           => esc_html__( 'Music > Music Interviews', 'sonaar' ),
    
                'Business News'              => esc_html__( 'News > Business News', 'sonaar' ),
                'Daily News'                 => esc_html__( 'News > Daily News', 'sonaar' ),
                'Entertainment News'         => esc_html__( 'News > Entertainment News', 'sonaar' ),
                'News Commentary'            => esc_html__( 'News > News Commentary', 'sonaar' ),
                'Politics'                   => esc_html__( 'News > Politics', 'sonaar' ),
                'Sports News'                => esc_html__( 'News > Sports News', 'sonaar' ),
                'Tech News'                  => esc_html__( 'News > Tech News', 'sonaar' ),
    
                'Buddhism'                   => esc_html__( 'Religion & Spirituality > Buddhism', 'sonaar' ),
                'Christianity'               => esc_html__( 'Religion & Spirituality > Christianity', 'sonaar' ),
                'Hinduism'                   => esc_html__( 'Religion & Spirituality > Hinduism', 'sonaar' ),
                'Islam'                      => esc_html__( 'Religion & Spirituality > Islam', 'sonaar' ),
                'Judaism'                    => esc_html__( 'Religion & Spirituality > Judaism', 'sonaar' ),
                'Religion'                   => esc_html__( 'Religion & Spirituality > Religion', 'sonaar' ),
                'Spirituality'               => esc_html__( 'Religion & Spirituality > Spirituality', 'sonaar' ),
                'Buddhism'                   => esc_html__( 'Religion & Spirituality > Buddhism', 'sonaar' ),
    
    
                'Astronomy'                  => esc_html__( 'Science > Astronomy', 'sonaar' ),
                'Chemistry'                  => esc_html__( 'Science > Chemistry', 'sonaar' ),
                'Earth Sciences'             => esc_html__( 'Science > Earth Sciences', 'sonaar' ),
                'Life Sciences'              => esc_html__( 'Science > Life Sciences', 'sonaar' ),
                'Mathematics'                => esc_html__( 'Science > Mathematics', 'sonaar' ),
                'Natural Sciences'           => esc_html__( 'Science > Natural Sciences', 'sonaar' ),
                'Nature'                   	 => esc_html__( 'Science > Nature', 'sonaar' ),
                'BuddhPhysicssm'             => esc_html__( 'Science > Physics', 'sonaar' ),
                'Social Sciences'            => esc_html__( 'Science > Social Sciences', 'sonaar' ),
    
                'Documentary'                => esc_html__( 'Society & Culture > Documentary', 'sonaar' ),
                'Personal Journals'          => esc_html__( 'Society & Culture > Personal Journals', 'sonaar' ),
                'Philosophy'                 => esc_html__( 'Society & Culture > Philosophy', 'sonaar' ),
                'Places & Travel'            => esc_html__( 'Society & Culture > Places & Travel', 'sonaar' ),
                'Relationships'              => esc_html__( 'Society & Culture > Relationships', 'sonaar' ),
    
                'Baseball'                   => esc_html__( 'Sports > Baseball', 'sonaar' ),
                'Basketball'                 => esc_html__( 'Sports > Basketball', 'sonaar' ),
                'Cricket'                    => esc_html__( 'Sports > Cricket', 'sonaar' ),
                'Fantasy Sports'             => esc_html__( 'Sports > Fantasy Sports', 'sonaar' ),
                'Football'                   => esc_html__( 'Sports > Football', 'sonaar' ),
                'Golf'                   	 => esc_html__( 'Sports > Golf', 'sonaar' ),
                'Hockey'                     => esc_html__( 'Sports > Hockey', 'sonaar' ),
                'Rugby'                      => esc_html__( 'Sports > Rugby', 'sonaar' ),
                'Running'                    => esc_html__( 'Sports > Running', 'sonaar' ),
                'Soccer'                     => esc_html__( 'Sports > Soccer', 'sonaar' ),
                'Swimming'                   => esc_html__( 'Sports > Swimming', 'sonaar' ),
                'Tennis'                     => esc_html__( 'Sports > Tennis', 'sonaar' ),
                'Volleyball'                 => esc_html__( 'Sports > Volleyball', 'sonaar' ),
                'Wilderness'                 => esc_html__( 'Sports > Wilderness', 'sonaar' ),
                'Wrestling'                  => esc_html__( 'Sports > Wrestling', 'sonaar' ),
    
                'After Shows'                => esc_html__( 'TV & Film > After Shows', 'sonaar' ),
                'Film History'               => esc_html__( 'TV & Film > Film History', 'sonaar' ),
                'Film Interviews'            => esc_html__( 'TV & Film > Film Interviews', 'sonaar' ),
                'Film Reviews'               => esc_html__( 'TV & Film > Film Reviews', 'sonaar' ),
                'TV Reviews'                 => esc_html__( 'TV & Film > TV Reviews', 'sonaar' ),
    
    
            );
            if ( Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ){
                $args = array(
                    'id'           => 'srmp3_settings_podcast_tag_tool',
                    'title'        => esc_html__( 'Podcast RSS Tools', 'sonaar-music' ),
                    'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
                    'classes'      => array( 'cmb2-options-page', 'srmp3_podcast_rss', 'srmp3_podcast_rss_url' ),
                    'taxonomies'   => array( 'podcast-show' ), // Tells CMB2 which taxonomies should have these fields
                    'new_term_section' => true,
                );
    
                $srmp3_settings_podcast_tag_tool = new_cmb2_box( $args );
                
                $srmp3_settings_podcast_tag_tool->add_field( array(
                    'name'          => esc_html__('RSS Importer', 'sonaar-music'),
                    'type'          => 'title',
                    'description'   => sprintf( __( 'Import your existing Podcast Episodes %1$shere.%2$s', 'sonaar-music' ), '<a href="' . esc_url(get_admin_url( null, 'admin.php?import=podcast-rss' )) . '" target="' . wp_strip_all_tags( '_self' ) . '">', '</a>' ),
                    'id'            => 'srpodcast_importer'
                ) );
                if ( !function_exists('run_sonaar_music_pro')){
                    $srmp3_settings_podcast_tag_tool->add_field( array(
                        'name'          => esc_html__('Podcast Fetcher : Automatically import New Episode', 'sonaar-music'),
                        'after'         => 'promo_ad_cb',
                        'classes'       => array('srmp3-pro-feature', 'prolabel--nomargin', 'prolabel--nohide'),
                        'type'          => 'title',
                        'description'   => sprintf( __( 'Give you the ability to automatically fetch/import new episodes on your website from your existing Podcast distributor as soon as a new episode came out! %1$sLearn More%2$s<br><br>', 'sonaar-music' ), '<a href="https://sonaar.ticksy.com/article/17664" target="_blank">', '</a>' ),
                        'id'            => 'srpodcast_importer_cronjob'
                    ) );
                }else{
                    $srmp3_settings_podcast_tag_tool->add_field( array(
                        'name'          => esc_html__('Podcast Fetcher : Automatically import New Episode', 'sonaar-music'),
                        'type'          => 'title',
                        'description'   => sprintf( __( 'Give you the ability to automatically fetch/import new episodes on your website from your existing Podcast distributor as soon as a new episode came out! %1$sLearn More%2$s<br><br>', 'sonaar-music' ), '<a href="https://sonaar.ticksy.com/article/17664" target="_blank">', '</a>' ),
                        'id'            => 'srpodcast_importer_cronjob'
                    ) );
                }
            
            $args = array(
                'id'           => 'srmp3_settings_podcast_rss',
                'menu_title'   => esc_html__( 'Podcast RSS Settings', 'sonaar-music' ),
                'title'        => esc_html__( 'Podcast RSS Settings', 'sonaar-music' ),
                'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
                'classes'      => array( 'cmb2-options-page', 'srmp3_podcast_rss' ),
                'taxonomies'   => array( 'podcast-show' ), // Tells CMB2 which taxonomies should have these fields
                'new_term_section' => true,
                'option_key'   => 'srmp3_settings_podcast_rss', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
            );

            $podcast_rss = new_cmb2_box( $args );

            if( isset( $_REQUEST['tag_ID'] ) ){
                $term_id = (int) $_REQUEST['tag_ID'];
                $term = get_term( $term_id, 'podcast-show' );
                $slug = ( isset($term) ) ? $term->slug : '';
                $podcast_cat_id = ( isset($term_id) ) ? $term_id : '';
               //$podcast_original_feed =  ( isset($term_id) && get_term_meta($term_id, 'srpodcast_data_feedurl', true)) ? get_term_meta($term_id, 'srpodcast_data_feedurl', true) : '';
            }else{
                $slug = '';
                $podcast_cat_id = '';
            }
            
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Original RSS Feed URL', 'sonaar-music'),
                'id'            => 'srpodcast_data_feedurl',
                'type'          => 'hidden',
                'description'   => esc_html__('A description/summary of your podcast - no HTML allowed.', 'sonaar-music'),
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('RSS Feed Settings', 'sonaar-music'),
                'type'          => 'title',
                'description'   => sprintf( __( '
                Your Podcast Show ID is %4$s<br>
                Your WordPress RSS Feed URL is %1$s %3$s %2$s<br><br>
                An RSS feed is the only way an audience can access a podcast\'s content. Without an RSS feed, your podcast will not appear on your website or any podcasting directories, making it impossible for people to listen to it. Every podcast needs an RSS feed, there are not any exceptions.', 'sonaar-music' ),
                '<a href="' . esc_url(get_site_url( null, '/feed/podcast/?show=' . $slug )) . '" target="' . wp_strip_all_tags( '_blank' ) . '">',
                '</a>',
                esc_url(get_site_url( null, '/feed/podcast/?show=' . $slug )), $podcast_cat_id),
                'id'            => 'srpodcast_rss_feed_settings'
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Disable this RSS Feed', 'sonaar-music'),                
                'id'            => 'srpodcast_disable_rss',
                'type'          => 'switch',
                'label'    => array('on'=> 'Yes', 'off'=> 'No')
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Title', 'sonaar-music'),
                'id'            => 'srpodcast_data_title',
                'type'          => 'text',
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Subtitle', 'sonaar-music'),
                'id'            => 'srpodcast_data_subtitle',
                'type'          => 'text',
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Description', 'sonaar-music'),
                'id'            => 'srpodcast_data_description',
                'type'          => 'textarea',
                'description'   => esc_html__('A description/summary of your podcast - no HTML allowed.', 'sonaar-music'),
            ) );
            $podcast_rss->add_field( array(
                'name'              =>  esc_html__('Podcast Show Cover Image', 'sonaar-music'),
                'id'                => 'srpodcast_data_image',
                'type'              => 'file',
                'text'              => array(
                    'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
                ),
                'preview_size' => array( 120, 120 ),  // Image size to use when previewing in the admin.
                'options' => array(
                    'url' => false, // Hide the text input for the url
                ),
                // query_args are passed to wp.media's library query.
                'query_args'        => array(
                    // Or only allow gif, jpg, or png images
                    'type'  => array(
                         'image/gif',
                         'image/jpeg',
                         'image/png',
                    ),
                ),
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Author Name', 'sonaar-music'),
                'id'            => 'srpodcast_data_author',
                'type'          => 'text',
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Owner Name', 'sonaar-music'),
                'id'            => 'srpodcast_data_owner_name',
                'type'          => 'text',
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Author Email', 'sonaar-music'),
                'id'            => 'srpodcast_data_owner_email',
                'type'          => 'text_email',
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Language', 'sonaar-music'),
                'id'            => 'srpodcast_data_language',
                'type'          => 'text_small',
                'description'   => sprintf( __( 'Your podcast\'s language in %1$sISO-639-1 format%2$s.', 'sonaar' ), '<a href="' . esc_url( 'http://www.loc.gov/standards/iso639-2/php/code_list.php' ) . '" target="' . wp_strip_all_tags( '_blank' ) . '">', '</a>' ),
                'default'       => get_bloginfo ( 'language' )
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast Copyright', 'sonaar-music'),
                'id'            => 'srpodcast_data_copyright',
                'type'          => 'text',
                'default'       => esc_html(get_bloginfo( 'name' )) . ' &#xA9; ' . esc_html(date( 'Y' )) . ' - All Rights Reserved.' ,
            ) );
            $podcast_rss->add_field( array(
                'id'                => 'srpodcast_data_category',
                'type'              => 'select',
                'name'              => esc_html('Podcast Catergory', 'sonaar-music'),
                'show_option_none'  => false,
                'options'           => $category_options,
            ) );
            $podcast_rss->add_field( array(
                'id'                => 'srpodcast_data_subcategory',
                'type'              => 'select',
                'name'              => esc_html('Podcast subcategory (Optional)', 'sonaar-music'),
                'show_option_none'  => false,
                'options'           => $subcategory_options,
                'description'   => esc_html__('Attention! Make sure you choose a subcategory that belong to the choosen Category above otherwise Apple will reject it. ', 'sonaar-music'),
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Is your podcast explicit?', 'sonaar-music'),                
                'id'            => 'srpodcast_explicit',
                'type'          => 'switch',
                'label'    => array('on'=> 'Yes', 'off'=> 'No')
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Is your podcast complete?', 'sonaar-music'),                
                'description'   => esc_html__('Mark if this podcast is complete or not. Only do this if no more episodes are going to be added to this feed.', 'sonaar-music'),
                'id'            => 'srpodcast_complete',
                'type'          => 'switch',
                'label'    => array('on'=> 'Yes', 'off'=> 'No')
            ) );
            $podcast_rss->add_field( array(
                'id'                => 'srpodcast_consume_order',
                'type'              => 'select',
                'name'              => esc_html('Show Type', 'sonaar-music'),
                'show_option_none'  => false,
                'options'     => array(
                    'episodic' => esc_html__( 'Episodic', 'sonaar-music' ),
                    'serial'   => esc_html__( 'Serial', 'sonaar-music' )
                ),
                'description'   => sprintf( __( 'The order your podcast episodes will be listed. %1$sMore details here.%2$s', 'sonaar-music' ), '<a href="' . esc_url( 'https://www.google.com/search?q=apple+podcast+episodes+serial+vs+episodic' ) . '" target="' . wp_strip_all_tags( '_blank' ) . '">', '</a>' ),
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Redirect this feed to a new URL', 'sonaar-music'),
                'description'   => esc_html__('Redirect your feed to a new URL (specified below).', 'sonaar-music'),
                'id'            => 'srpodcast_redirect_feed',
                'type'          => 'switch',
                'label'    => array('on'=> 'Yes', 'off'=> 'No')
            ) );
            $podcast_rss->add_field( array(
                'name'          => esc_html__('Podcast feed URL redirection', 'sonaar-music'),
                'id'            => 'srpodcast_new_feed_url',
                'type'          => 'text_url',
                'attributes'    => array(
                    'required'               => false, // Will be required only if visible.
                    'data-conditional-id'    => 'srpodcast_redirect_feed',
                    'data-conditional-value' => 'true',
                )
            ) );

            $args = array(
                'id'           => 'srmp3_settings_podcast_rss_url',
                //'menu_title'   => esc_html__( 'Podcast RSS Settings', 'sonaar-music' ),
                'title'        => esc_html__( 'Podcast RSS Settings', 'sonaar-music' ),
                'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
                'classes'      => array( 'cmb2-options-page', 'srmp3_podcast_rss', 'srmp3_podcast_rss_url' ),
                'taxonomies'   => array( 'podcast-show' ), // Tells CMB2 which taxonomies should have these fields
                'new_term_section' => true,
                //'option_key'   => 'srmp3_settings_podcast_rss_url', // The option key and admin menu page slug. 'yourprefix_tertiary_options',
            );

            $podcast_rss_url = new_cmb2_box( $args );

            $links_group = $podcast_rss_url->add_field( array(
                'id'            => 'podcast_rss_url',            
                'type'          => 'group',
                'description'   => esc_html__('Where your listeners can subscribe? Will display a follow/subscribe button on the player. You can reorder the buttons by using the up/down arrows. ', 'sonaar-music'),
                'name' 			=> 'Subscribe Button Links',
                'classes'       => 'srpodcast_url_group',
                'repeatable'    => true, // use false if you want non-repeatable group
                'options'       => array(
                    'add_button'    => esc_html__('Add Subscribe Button', 'sonaar-music'),
                    'remove_button' => esc_html__('Remove Button', 'sonaar-music'),
                    'sortable'      => true, // beta
                    'closed'        => false, // true to have the groups closed by default
                ),
            ) );
            $podcast_rss_url->add_group_field( $links_group ,array(
                'name'              => esc_html__( 'Podcast Platform', 'sonaar-music' ),
                'id'                => 'srpodcast_url_icon',
                'classes'       => 'srpodcast_url_icon',
                'type'              => 'select',
                'show_option_none'  => true,
                'options' => $this->getPodcastPlatforms(),
                'default'           => '',
            ));

            $podcast_rss_url->add_group_field( $links_group ,array(
                'name'          => esc_html__('Link URL', 'sonaar-music'),
                'id'            => 'srpodcast_url',
                'type'          => 'text_url',
                'classes'       => 'srpodcast_url_link',
            ));     
        }  
        // migrate iron_music_player key in separate setting tabs since version 3.0
        if( FALSE != get_option('iron_music_player') && !get_option('srmp3_settings_general') ){
            //$options_name = array($general_options, $popup_options, $widget_player_options, $sticky_player_options, $woocommerce_options);
            //var_dump($options_name);
            foreach($options_name as $option_name){
            $options_key_name = $option_name->meta_box['option_key'][0];
                if (FALSE === get_option($options_key_name) && FALSE === update_option($options_key_name, FALSE)){
                    foreach ($option_name->meta_box['fields'] as $field ) {
                        $getKey = ( isset(get_option('iron_music_player')[$field['id']]) ) ? get_option('iron_music_player')[$field['id']] : '';
                        if( $getKey != '' ){
                            cmb2_update_option($options_key_name, $field['id'], $getKey );
                        }
                    }
                }
            }
        }
        /**
         * A CMB2 options-page display callback override which adds tab navigation among
         * CMB2 options pages which share this same display callback.
         *
         * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
         */
        function yourprefix_options_display_with_tabs( $cmb_options ) {            
            
            $tabs = yourprefix_options_page_tabs( $cmb_options );
            ?>
            <div class="wrap cmb2-options-page option-<?php echo esc_attr($cmb_options->option_key); ?>">
                <?php if ( get_admin_page_title() ) : ?>
                    <h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
                <?php endif; ?>
                <h2 class="nav-tab-wrapper">
                    <?php foreach ( $tabs as $option_key => $tab_title ) : ?>
                        <a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
                    <?php endforeach; ?>
                </h2>
                <form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo esc_attr($cmb_options->cmb->cmb_id); ?>" enctype="multipart/form-data" encoding="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
                    <?php $cmb_options->options_page_metabox(); ?>
                    <?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
                </form>
            </div>
            <?php
        }

        /**
         * Gets navigation tabs array for CMB2 options pages which share the given
         * display_cb param.
         *
         * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
         *
         * @return array Array of tab information.
         */
        function yourprefix_options_page_tabs( $cmb_options ) {
            $tab_group = $cmb_options->cmb->prop( 'tab_group' );
            $tabs      = array();

            foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
                if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
                    $tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
                        ? $cmb->prop( 'tab_title' )
                        : $cmb->prop( 'title' );
                }
            }

            return $tabs;
        }
        

        $cmb_options = new_cmb2_box( array(
            'id'            => 'sonaar_music_network_option_metabox',
            'title'         => esc_html__( 'Sonaar Music', 'sonaar-music' ),
            'object_types'  => array( 'options-page' ),
            'option_key'    => 'iron_music_player', // The option key and admin menu page slug.
            'icon_url'      => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
            'menu_title'    => esc_html__( 'Settings', 'sonaar-music' ), // Falls back to 'title' (above).
            'parent_slug'   => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu.
            'capability'    => 'manage_options', // Cap required to view options-page.
            'position'      => 1,
        ) );        
        /**
        * Manually render a field.
        *
        * @param  array      $field_args Array of field arguments.
        * @param  CMB2_Field $field      The field object
        */
        function banner_row( $field_args, $field ) {
            require_once plugin_dir_path( __FILE__ ) . 'partials/sonaar-music-admin-display.php';
        }
        // DISPLAY GO PRO TAB IN SIDE MENU
        if ( !function_exists( 'run_sonaar_music_pro' ) ){
            $cmb_promo = new_cmb2_box( array(
                'id'            => 'sonaar_music_promo',
                'title'        	=> esc_html__( 'Go Pro', 'sonaar-music' ),
                'object_types' 	=> array( 'options-page' ),
                'option_key'    => 'sonaar_music_promo', // The option key and admin menu page slug.
                'icon_url'      => 'dashicons-chart-pie', // Menu icon. Only applicable if 'parent_slug' is left empty.
                'menu_title'    => esc_html__( 'Go Pro', 'sonaar-music' ), // Falls back to 'title' (above).
                'parent_slug'   => 'edit.php?post_type=' . SR_PLAYLIST_CPT, // Make options page a submenu item of the themes menu.
                'capability'    => 'manage_options', // Cap required to view options-page.
                'enqueue_js'    => false,
                'cmb_styles'    => false,
                'display_cb'    => 'sonaar_music_promo_display',
                'position'      => 9999,
            ) );
        }
        
        function sonaar_music_promo_display(){
            require_once plugin_dir_path( __FILE__ ) . 'partials/sonaar-music-promo-display.php';
        }
       

    }
    /**
    * Register post fields
    **/
    public static function getPodcastPlatforms() {
        return array(
            'sricon-apple-podcasts'         => esc_html__( 'Apple Podcasts', 'sonaar-music' ),
            'sricon-spotify'                => esc_html__( 'Spotify', 'sonaar-music' ),
            'sricon-google-podcast'         => esc_html__( 'Google Podcasts', 'sonaar-music' ),
            'sricon-amazonmusic'            => esc_html__( 'Amazon Music', 'sonaar-music' ),
            'sricon-castbox'                => esc_html__( 'Castbox', 'sonaar-music' ),
            'sricon-castro'                 => esc_html__( 'Castro', 'sonaar-music' ),
            'sricon-deezer'                 => esc_html__( 'Deezer', 'sonaar-music' ),
            'sricon-iheartradio'            => esc_html__( 'iHeart Radio', 'sonaar-music' ),
            'sricon-overcast'               => esc_html__( 'Overcast', 'sonaar-music' ),
            'sricon-pandora'                => esc_html__( 'Pandora', 'sonaar-music' ),
            'sricon-playerfm'               => esc_html__( 'Player FM', 'sonaar-music' ),
            'sricon-pocketcasts'            => esc_html__( 'Pocket Casts', 'sonaar-music' ),
            'sricon-podcastaddict'          => esc_html__( 'Podcast Addict', 'sonaar-music' ),
            'sricon-podcastindex'           => esc_html__( 'Podcast Index', 'sonaar-music' ),
            'sricon-podchaser'              => esc_html__( 'Podchaser', 'sonaar-music' ),
            'sricon-stitcher'               => esc_html__( 'Stitcher', 'sonaar-music' ),
            'sricon-tunein'                 => esc_html__( 'TuneIn', 'sonaar-music' ),
            'sricon-rss-feed'               => esc_html__( 'RSS Feed', 'sonaar-music' ),
        );
    }
    public static function sr_GetString( $string ){
        $playerType = ( Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' )? 'podcast' : 'music';
        switch ( $string ){
            case 'Album Infos':
                $label = ( $playerType == 'music' )? esc_html__( 'Album Infos', 'sonaar-music' ) : esc_html__( 'Podcast Infos', 'sonaar-music' );
                break;
            case 'Track Title':
                $label = ( $playerType == 'music' )? esc_html__( 'Track Title', 'sonaar-music' ) : esc_html__( 'Episode Title', 'sonaar-music' );
                break;
            case 'Track Album':
                $label = ( $playerType == 'music' )? esc_html__( 'Track Album', 'sonaar-music' ) : esc_html__( 'Podcast Name', 'sonaar-music' );
                break;
            case 'Album Subtitle':
                $label = ( $playerType == 'music' )? esc_html__( 'Album Subtitle', 'sonaar-music' ) : esc_html__( 'Episode Subtitle', 'sonaar-music' );
                break;
            case 'Do not skip to the next track':
                $label = ( $playerType == 'music' )? esc_html__( 'Do not skip to the next track', 'sonaar-music' ) : esc_html__( 'Do not skip to the next episode', 'sonaar-music' );
                break;
            case 'Track Number':
                $label = ( $playerType == 'music' )? esc_html__( 'Track {#}', 'sonaar-music' ) : esc_html__( 'Episode {#}', 'sonaar-music' );
                break;
            case 'Add Another track':
                $label = ( $playerType == 'music' )? esc_html__( 'Add Another Track', 'sonaar-music' ) : esc_html__( 'Add Another Episode', 'sonaar-music' );
                break;
            case 'Remove Track':
                $label = ( $playerType == 'music' )? esc_html__( 'Remove Track', 'sonaar-music' ) : esc_html__( 'Remove Episode', 'sonaar-music' );
                break;
            case 'Optional Track Image':
                $label = ( $playerType == 'music' )? esc_html__( 'Optional Track Image', 'sonaar-music' ) : esc_html__( 'Optional Episode Cover', 'sonaar-music' );
                break;
            case 'Playlist Cover Image':
                $label = ( $playerType == 'music' )? esc_html__( 'Playlist Cover Image', 'sonaar-music' ) : esc_html__( 'Podcast Cover Image', 'sonaar-music' );
                break;
            case 'Remove Playlist Cover':
                $label = ( $playerType == 'music' )? esc_html__( 'Remove Playlist Cover', 'sonaar-music' ) : esc_html__( 'Remove Podcast Cover', 'sonaar-music' );
                break;
            case 'All Playlists':
                $label = ( $playerType == 'music' )? esc_html__( 'All Playlists', 'sonaar-music' ) : esc_html__( 'All Episodes', 'sonaar-music' );
                break;
            case 'Playlists':
                $label = ( $playerType == 'music' )? esc_html__( 'Playlists', 'sonaar-music' ) : esc_html__( 'Episodes', 'sonaar-music' );
                break;
            case 'playlist':
                $label = ( $playerType == 'music' )? esc_html__( 'playlist', 'sonaar-music' ) : esc_html__( 'episode', 'sonaar-music' );
                break;
            case 'Tracklist':
                $label = ( $playerType == 'music' )? esc_html__( 'Tracklist', 'sonaar-music' ) : esc_html__( 'Episodes List', 'sonaar-music' );
                break;
            case 'Add New Playlist':
                $label = ( $playerType == 'music' )? esc_html__( 'Add New Playlist', 'sonaar-music' ) : esc_html__( 'Add New Episode', 'sonaar-music' );
                break;
            case 'Playlist Categories':
                $label = ( $playerType == 'music' )? esc_html_x('Playlist Categories', 'Taxonomy : name', 'sonaar-music') : esc_html_x('Podcast Categories', 'Taxonomy : name', 'sonaar-music');
                break;
            case 'Edit Playlist':
                $label = ( $playerType == 'music' )? esc_html__( 'Edit Playlist', 'sonaar-music' ) : esc_html__( 'Edit Episode', 'sonaar-music' );
                break;
            case 'album_slug':
                $label = ( $playerType == 'music' )? esc_html__( 'album', 'sonaar-music' ) : esc_html__( 'episode', 'sonaar-music' );
                break;
            case 'category_slug':
                $label = ( $playerType == 'music' )? esc_html__( 'playlist-category', 'sonaar-music' ) : esc_html__( 'podcast-category', 'sonaar-music' );
                break;
            case 'Display Artist Name':
                $label = ( $playerType == 'music' )? esc_html__( 'Display Artist Name', 'sonaar-music' ) : esc_html__( 'Display Author Name', 'sonaar-music' );
                break;
            case 'Artist Name Prefix Separator':
                $label = ( $playerType == 'music' )? esc_html__( 'Artist Name Prefix Separator', 'sonaar-music' ) : esc_html__( 'Author Name Prefix Separator', 'sonaar-music' );
                break;
            case 'Album Title':
                $label = ( $playerType == 'music' )? esc_html__( 'Album Title', 'sonaar-music' ) : esc_html__( 'Player Title', 'sonaar-music' );
                break;
            case 'Album Subtitle 2':
                $label = ( $playerType == 'music' )? esc_html__( 'Album Subtitle', 'sonaar-music' ) : esc_html__( 'Player Subtitle', 'sonaar-music' );
                break;
            case 'Album cover size image source':
                $label = ( $playerType == 'music' )? esc_html__( 'Album cover size image source', 'sonaar-music' ) : esc_html__( 'Episode cover size image source', 'sonaar-music' );
                break;
            /*case 'Display Playlist Post Excerpt In The Track List':
                $label = ( $playerType == 'music' )? esc_html__( 'Display Playlist Post Excerpt In The Track List', 'sonaar-music' ) : esc_html__( 'Display Episode Post Excerpt In The Track List', 'sonaar-music' );
                break;*/
            case 'Optional Track Information':
                $label = ( $playerType == 'music' )? esc_html__( 'Optional Track Information', 'sonaar-music' ) : esc_html__( 'Episode Description/Notes', 'sonaar-music' );
                break;
            case 'track':
                $label = ( $playerType == 'music' )? esc_html__( 'track', 'sonaar-music' ) : esc_html__( 'episode', 'sonaar-music' );
                break;
            case 'playlist/podcast':
                $label = ( $playerType == 'music' )? esc_html__( 'playlist', 'sonaar-music' ) : esc_html__( 'podcast', 'sonaar-music' );
                break;
            
            default :
                $label = $string;
        }
        return $label;
    }

    public function init_postField(){
        function sr_check_if_wc(){
            if (get_post_type() == 'product'){
                return true;
            }
            return false;
        }
        function sr_check_if_sr_posttype(){
            if (get_post_type() == SR_PLAYLIST_CPT){
                return true;
            }
            return false;
        }
        function sr_admin_column_count( $field_args, $field) {
            global $post;
            $list = get_post_meta($post->ID, $field_args['id'], true);
            
            if(!is_array($list) || empty($list)){
                return esc_html__('N/A', 'sonaar-music'); 
            }

            return count($list);
        }

        if ( function_exists( 'run_sonaar_music_pro' ) ){
            $cmb_post_album = new_cmb2_box( array(
                'id'            => 'acf_post_albums',
                'title'         => 'Player Settings',//$this->sr_GetString('Album Infos'),
                'object_types'  => SR_PLAYLIST_CPT,
                'context'       => 'normal',
                'priority'      => 'low',
                'show_names'    => true,
                'capability'    => 'manage_options', // Cap required to view options-page.
            ) );
        
            $cmb_post_album->add_field( array(
                'name'          => esc_html__('NEW! Player Design', 'sonaar-music'),
                'id'            => 'post_player_type',
                'type'          => 'select',
                'options'       => array(
                    'default'    => esc_html__('Default (Same as the General Settings)', 'sonaar-music'),
                    'skin_float_tracklist'         => esc_html__('Floated', 'sonaar-music'),
                    'skin_boxed_tracklist'    => esc_html__('Boxed', 'sonaar-music'),
                ),
                'default'       => 'default'
            ) );
        }
        /////////////////////////////////
        $cmb_album = new_cmb2_box( array(
            'id'            => 'acf_albums_infos',
            'title'         => $this->sr_GetString('Album Infos'),
            'object_types'  => ( Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') != null ) ? Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') : SR_PLAYLIST_CPT,
            'context'       => 'normal',
            'priority'      => 'low',
            'show_names'    => true,
            'capability'    => 'manage_options', // Cap required to view options-page.
        ) );
        $cmb_album->add_field( array(
            'id'            => 'alb_release_date',
            'name'          => $this->sr_GetString('Album Subtitle'),
            'description'   => esc_html__('E.g. Release Date: 2019, New Album, Sold Out, etc. ', 'sonaar-music'),
            'type'          => 'text'
        ) );

        if ( !function_exists( 'run_sonaar_music_pro' ) ){
            $cmb_album->add_field( array(
                'show_on_cb'    => 'sr_check_if_wc',
                'id'            => 'promo_wc_add_to_cart',
                'before_field'  => 'promo_ad_cb',
                'classes'       => 'srmp3-pro-feature',
                'object_types'  => 'product',
                'default'       => 'true',
                'name'          => esc_html__('Add to Cart button', 'sonaar-music'),
                'description'   => sprintf( __('Display an Add to Cart button in the %s', 'sonaar-music'), (function_exists( 'run_sonaar_music_pro' )) ? 'sticky player and the available-on module.' : 'available-on module.' ),
                'type'          => 'switch'            
                
            ));
            $cmb_album->add_field( array(
                'show_on_cb'    => 'sr_check_if_wc',
                'id'            => 'promo_wc_buynow_bt',
                'before_field'  => 'promo_ad_cb',
                'classes'       => 'srmp3-pro-feature',
                'object_types'  => 'product',
                'default'       => 'false',
                'name'          => esc_html__('Buy Now button', 'sonaar-music'),
                'description'   => sprintf( __('Display a Buy Now button in the %s', 'sonaar-music'), (function_exists( 'run_sonaar_music_pro' )) ? 'sticky player and the available-on module.' : 'available-on module.' ),
                'type'          => 'switch'
                
            ));
        }else{
            $cmb_album->add_field( array(
                'show_on_cb'    => 'sr_check_if_wc',
                'id'            => 'wc_add_to_cart',
                'object_types'  => 'product',
                'default'       => 'true',
                'name'          => esc_html__('Add to Cart button', 'sonaar-music'),
                'description'   => sprintf( __('Display an Add to Cart button in the %s', 'sonaar-music'), (function_exists( 'run_sonaar_music_pro' )) ? 'sticky player and the available-on module.' : 'available-on module.' ),
                'type'          => 'switch'            
                
            ));
            $cmb_album->add_field( array(
                'show_on_cb'    => 'sr_check_if_wc',
                'id'            => 'wc_buynow_bt',
                'object_types'  => 'product',
                'default'       => 'false',
                'name'          => esc_html__('Buy Now button', 'sonaar-music'),
                'description'   => sprintf( __('Display a Buy Now button in the %s', 'sonaar-music'), (function_exists( 'run_sonaar_music_pro' )) ? 'sticky player and the available-on module.' : 'available-on module.' ),
                'type'          => 'switch'
                
            ));
        }
        
        if ( function_exists( 'run_sonaar_music_pro' ) ){            
            $cmb_album->add_field( array(
                'id'            => 'no_track_skip',
                'name'          => $this->sr_GetString('Do not skip to the next track'),
                'description'   => 'When the current track ends, do not play the second track automatically.',
                'type'          => 'checkbox'
            ));
        }

        $cmb_album->add_field( array(
            'id'            => 'reverse_post_tracklist',
            'name'          => esc_html__('Reverse Order', 'sonaar-music'),
            'description'   => 'Display tracklist in reverse order on the front-end',
            'type'          => 'checkbox'
        ));
        $tracklist = $cmb_album->add_field( array(
            'id'            => 'alb_tracklist',            
            'type'          => 'group',
            'name' 			=> $this->sr_GetString('Tracklist'),
            'repeatable'    => true, // use false if you want non-repeatable group
            'options'       => array(
                'group_title'   => $this->sr_GetString('Track Number'),//__( 'Track {#}', 'sonaar-music' ), // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => $this->sr_GetString('Add Another track'),
                'remove_button' => $this->sr_GetString('Remove Track'),
                'sortable'      => true, // beta
                'closed'        => false, // true to have the groups closed by default
            ),
            'column' => array(
                'name'     => esc_html__( 'Audio Tracks', 'sonaar-music' ),
            ),
            'display_cb'    => 'sr_admin_column_count',
        ) );
        $cmb_album->add_group_field( $tracklist ,array(
            'name'              => esc_html__('Source File', 'sonaar-music'),
            'description'       => 'Please select which type of audio source you want for this track',
            'id'                => 'FileOrStream',
            'type'              => 'radio',
            'show_option_none'  => false,
            'options'           => array(
                'mp3'               => 'Local MP3',
                'stream'            => 'External MP3'
            ),
            'default'           => 'mp3'
        ));
        
        $cmb_album->add_group_field($tracklist, array(
            'id'            => 'track_mp3',
            'name'          => esc_html__('MP3 File','sonaar-music'),
            'type'          => 'file',
            'description'   => esc_html__('Only .MP3 file accepted','sonaar-music'),
            'query_args'    => array(
                'type'          => 'audio/mpeg',
            ),
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => wp_json_encode( array( $tracklist, 'FileOrStream' )),
                'data-conditional-value' => 'mp3',
            )
        ));
        
        $cmb_album->add_group_field($tracklist, array(
            'id'            => 'stream_link',
            'classes'       => 'sr-stream-url-field',
            'name'          => esc_html__('External Audio link','sonaar-music'),
            'type'          => 'text_url',
            'description'   => sprintf( esc_html__('Enter URL that points to your audio file. See %s for supported providers', 'sonaar-music'), '<a href="https://sonaar.ticksy.com/article/15845" target="_blank">this article</a>'),
            //'description'   => esc_html__('See <a href="https://sonaar.ticksy.com/article/15845" target="_blank">this article</a> for supported providers. Enter URL that points to your audio file.','sonaar-music'),
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => wp_json_encode( array( $tracklist, 'FileOrStream' )),
                'data-conditional-value' => 'stream',
            )
        ));
        $cmb_album->add_group_field($tracklist, array(
            'id'            => 'stream_title',
            'classes'       => 'sr-stream-title-field',
            'name'          => $this->sr_GetString('Track Title'),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => wp_json_encode( array( $tracklist, 'FileOrStream' )),
                'data-conditional-value' => 'stream',
            )
        ));
        $cmb_album->add_group_field($tracklist, array(
            'id'            => 'stream_album',
            'classes'       => 'sr-stream-album-field',
            'name'          => $this->sr_GetString('Track Album'),
            'description'   => esc_html__("Leave blank if it's the same as the post title",'sonaar-music'),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => wp_json_encode( array( $tracklist, 'FileOrStream' )),
                'data-conditional-value' => 'stream',
            )
        ));
        $cmb_album->add_group_field($tracklist, array(
            'id'            => 'stream_lenght',
            'classes'       => 'sr-stream-lengh',
            'name'          => esc_html__('Audio Duration', 'sonaar-music'),
            'description'   => esc_html__('Format accepted: 01:20:30 (Eg: For 1 hour 20 minutes and 30 seconds duration)','sonaar-music'),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => wp_json_encode( array( $tracklist, 'FileOrStream' )),
                'data-conditional-value' => 'stream',
            )
        ));
        $cmb_album->add_group_field($tracklist, array(
            'classes'       => array('srmp3-pro-feature', 'prolabel--nomargin', 'prolabel--nohide'),
            'before'        => 'promo_ad_cb',
            'id'            => 'track_description',
            'name'          => $this->sr_GetString('Optional Track Information'),
            'description'   => esc_html__("BPM, Hashtag, Description, etc. Will appear below track title in the playlist.",'sonaar-music'),
            'type'          => 'wysiwyg',
            'options' => array(
                'textpromo' => esc_html__('Pro Feature', 'sonaar-music'),
                'wpautop' => false, // use wpautop?
                'media_buttons' => false, // show insert/upload button(s)
                'textarea_rows' => get_option('default_post_edit_rows', 6), // rows="..."
                'tabindex' => '',
                'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
                'editor_class' => '', // add extra class(es) to the editor textarea
                'teeny' => true, // output the minimal editor config used in Press This
                'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
                'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                'quicktags' => true, // load Quicktags, can be used to pass settings directly to Quicktags using an array()
               
            ),
            
        ));
        $cmb_album->add_group_field( $tracklist ,array(
            'name'              => $this->sr_GetString('Optional Track Image'),
            //'classes'           => array('srmp3-pro-feature', 'prolabel--nomargin'),
            'classes_cb'        => 'remove_pro_label_if_pro',
            'before'            => 'promo_ad_cb',
            'id'                => 'track_image',
            'type'              => 'file',
            'text'              => array(
                'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
            ),
            'preview_size' => array( 60, 60 ),  // Image size to use when previewing in the admin.
            'options' => array(
                'textpromo' => esc_html__('Pro Feature', 'sonaar-music'),
                'url' => false, // Hide the text input for the url
            ),
            // query_args are passed to wp.media's library query.
            'query_args'        => array(
                // Or only allow gif, jpg, or png images
                'type'  => array(
                     'image/gif',
                     'image/jpeg',
                     'image/png',
                ),
            ),
        ));

        $cmb_album->add_group_field( $tracklist, array(
            'id'            => 'song_store_list',
            'type'          => 'store_list',
            'name' 			=> esc_html__('Optional Call to Action','sonaar-music'),
            'repeatable'    => true,
            'icon'          => true,
            'options'       => array(
                'sortable'      => true, // beta
            ),
            'text'          => array(
                'add_row_text'      => 'Add Call to Action',
                'store_icon_text'   => '',
                'store_name_desc'   => esc_html__('Eg: Spotify, SoundCloud, Buy Now', 'sonaar-music'),
                'store_showlabel_desc'   => esc_html__('Make sure playlist is wide enough to display the label', 'sonaar-music'),
                'store_link_desc'   => '',
                'store_content_desc'   => esc_html__('Eg: Text, Lyrics, Shortcodes and HTML accepted','sonaar-music'),
            
            ) 
        ));
        if ( Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ){
            $cmb_album->add_group_field( $tracklist ,array(
                'name'          => esc_html__('Mark this episode as explicit', 'sonaar-music'),
                'id'            => 'podcast_explicit_episode',
                'show_on_cb'    => 'sr_check_if_sr_posttype',
                'type'          => 'switch',
                'default'       => 0,
            ) );
            $cmb_album->add_group_field( $tracklist ,array(
                'name'          => esc_html__('Block episode from appearing in the RSS', 'sonaar-music'),
                'id'            => 'podcast_itunes_notshow',
                'show_on_cb'    => 'sr_check_if_sr_posttype',
                'type'          => 'switch',
                'default'       => 0,
            ) );
            $cmb_album->add_group_field( $tracklist ,array(
                'name'          => esc_html__('iTunes Episode Title (exclude series or show number)', 'sonaar-music'),
                'id'            => 'podcast_itunes_episode_title',
                'show_on_cb'    => 'sr_check_if_sr_posttype',
                'type'          => 'text',
            ) );
            $cmb_album->add_group_field( $tracklist ,array(
                'name'          => esc_html__('Episode Number. Leave blank if none', 'sonaar-music'),
                'id'            => 'podcast_itunes_episode_number',
                'show_on_cb'    => 'sr_check_if_sr_posttype',
                'type'          => 'text_small',
            ) );
            $cmb_album->add_group_field( $tracklist ,array(
                'name'          => esc_html__('Season number. Leave blank if none', 'sonaar-music'),
                'id'            => 'podcast_itunes_season_number',
                'show_on_cb'    => 'sr_check_if_sr_posttype',
                'type'          => 'text_small',
            ) );
            $cmb_album->add_group_field( $tracklist ,array(
                'name'              => esc_html__( 'Episode Type', 'sonaar-music'),
                'id'                => 'podcast_itunes_episode_type',
                'show_on_cb'    => 'sr_check_if_sr_posttype',
                'type'              => 'select',
                'show_option_none'  => true,
                'options'           => array(
                    'full'        => esc_html__( 'Full', 'sonaar-music' ),
                    'trailer'              => esc_html__( 'Trailer', 'sonaar-music' ),
                    'bonus'              => esc_html__( 'Bonus', 'sonaar-music' ),
                ),
                'default'           => 'full',
            ) );

        }
        $cmb_album->add_field( array(
            'id'            => 'alb_store_list',
            'type'          => 'store_list',
            'name'          => esc_html__('External Links Buttons','sonaar-music'),
            'repeatable'    => true,
            'column' => array(
                'name'     => esc_html__( 'Store Links', 'sonaar-music' ),
            ),
            'display_cb'    => 'sr_admin_column_count',
            'icon'          => true,
            'text'          => array(
                'add_row_text'      => esc_html__('Add Link', 'sonaar-music'),
            )
        ));
        if ( !function_exists( 'run_sonaar_music_pro' ) ){
            $cmb_album_promo = new_cmb2_box( array(
                'id'            => 'sonaar_promo',
                'title'        	=> esc_html__( 'Why MP3 Player PRO?', 'sonaar-music' ),
                'object_types' 	=> array( SR_PLAYLIST_CPT ),
                'context'       => 'side',
                'priority'      => 'low',
                'show_names'    => false,
                'capability'    => 'manage_options', // Cap required to view options-page.
            ) );
        
            
            $cmb_album_promo->add_field( array(
                'id'            => 'calltoaction',
                'name'	        => esc_html__('sonaar pro', 'sonaar-music'),
                'type'          => 'calltoaction',
                'href'          => esc_html('https://sonaar.io/free-mp3-music-player-plugin-for-wordpress/?utm_source=Sonaar+Music+Free+Plugin&utm_medium=plugin'),
                'img'           => esc_url(plugin_dir_url(dirname(__FILE__)) . 'admin/img/sonaar-music-pro-banner-cpt.jpg'),                
            ));
        }
        /*if ( function_exists( 'run_sonaar_music_pro' ) ){
            $cmb_post_podcast = new_cmb2_box( array(
                'id'            => 'srp_post_podcast',
                'title'         => 'Podcast RSS Episode Info',//$this->sr_GetString('Album Infos'),
                'object_types'  => SR_PLAYLIST_CPT,
                'context'       => 'normal',
                'priority'      => 'low',
                'show_names'    => true,
                'capability'    => 'manage_options', // Cap required to view options-page.
            ) );
            $cmb_post_podcast->add_field( array(
                'name'          => esc_html__('Mark this episode as explicit', 'sonaar-music'),
                'id'            => 'podcast_explicit_episode',
                'type'          => 'switch',
                'default'       => 0,
            ) );
            $cmb_post_podcast->add_field( array(
                'name'          => esc_html__('Block this episode from appearing in iTunes and Google Play', 'sonaar-music'),
                'id'            => 'podcast_itunes_notshow',
                'type'          => 'switch',
                'default'       => 0,
            ) );
           
        }*/
    }
    /**
    * return CPT name "sr_playlist" or "album" for backward compatibility
    **/
    public function setPlaylistCPTName(){
        if( wp_get_theme()->template === 'sonaar' ){ // If Sonaar Theme is activated
			$cptName = 'sr_playlist';
		}else{
			$query = new WP_Query(array(
				'post_type' => 'album',
                'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
			));
            if ($query->have_posts()) { 
                $first_post = $query->posts[0];
                $meta = get_post_meta($first_post->ID, '', true);
                if( is_array($meta) && array_key_exists('artist_of_album', $meta) ){ //If album post has been created by sonaar theme
                    $cptName = 'sr_playlist';
                }else{ //If album post has been created by a old MP3 player version, keep the same CPT name
                    $cptName = 'album';
                }
            }else{
				$cptName = 'sr_playlist';
			}
		}
        return $cptName;
    }

    /**
    * Create custom posttype
    **/
    public function initCPT(){
        define('SR_PLAYLIST_CPT', $this->setPlaylistCPTName());
        delete_option('player_type');
        
	}
    
    public function srmp3_create_postType(){

        $podcast_shows_args = array(
            'public'            => true,
            'show_ui'           => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => false,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'show_tagcloud'     => true,
            'query_var'         => false,
            'rewrite'           => true,
            'hierarchical'      => false,
            'sort'              => false,
            'labels'            => array(
                'name'          => $this->sr_GetString('Podcast Show'),
                'all_items'     => esc_html_x('All Show',       'Taxonomy : all_items',     'sonaar-music'),
                'singular_name' => esc_html_x('Podcast Show',       'Taxonomy : singular_name', 'sonaar-music'),
                'add_new_item'  => esc_html_x('Add New Show',       'Taxonomy : add_new_item',  'sonaar-music'),
                'not_found'     => esc_html_x('No show founds.', 'Taxonomy : not_found',     'sonaar-music')
            ),
        );    
        $podcast_shows_slug = ( Sonaar_Music::get_option('sr_podcastshow_slug', 'srmp3_settings_widget_player') != null && Sonaar_Music::get_option('sr_podcastshow_slug', 'srmp3_settings_widget_player') != '') ? Sonaar_Music::get_option('sr_podcastshow_slug', 'srmp3_settings_widget_player') : 'podcast-show' ;       
        $podcast_shows_args['rewrite'] = array(
            'slug' => $podcast_shows_slug,
        );
        if ( Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ){
            register_taxonomy('podcast-show', SR_PLAYLIST_CPT, $podcast_shows_args);
        }

        $album_args = array(
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'has_archive'         => true,
            'query_var'           => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_icon'           => 'dashicons-format-audio',
            'exclude_from_search' => false,
            'delete_with_user'    => false,
        );
        
        $album_args['labels'] = array(
            'name'               => $this->sr_GetString('Playlists'),
            'singular_name'      => sprintf(esc_html__('%1$s (MP3 Audio Player Pro) ', 'sonaar-music'), ucfirst($this->sr_GetString('playlist'))),
            'name_admin_bar'     => esc_html__('Playlist', 'sonaar-music'),
            'menu_name'          => esc_html__('MP3 Player', 'sonaar-music'),
            'all_items'          => $this->sr_GetString('All Playlists'),
            'add_new'            => $this->sr_GetString('Add New Playlist'),
            'add_new_item'       => $this->sr_GetString('Add New Playlist'),
            'edit_item'          => $this->sr_GetString('Edit Playlist'),
            'new_item'           => esc_html__('New Playlist', 'sonaar-music'),
            'view_item'          => esc_html__('View playlist', 'sonaar-music'),
            'search_items'       => esc_html__('Search Playlists', 'sonaar-music'),
            'not_found'          => esc_html__('No playlists found.', 'sonaar-music'),
            'not_found_in_trash' => esc_html__('No playlists found in the Trash.', 'sonaar-music'),
            'featured_image'     => $this->sr_GetString('Playlist Cover Image'),
            'set_featured_image' => esc_html__('Set Playlist Cover', 'sonaar-music'),
            'remove_featured_image' => $this->sr_GetString('Remove Playlist Cover')
        );
        
        $album_args['supports'] = array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail'
        );
        
        $playlist_single_slug = ( Sonaar_Music::get_option('sr_singlepost_slug', 'srmp3_settings_widget_player') != null && Sonaar_Music::get_option('sr_singlepost_slug', 'srmp3_settings_widget_player') != '') ? Sonaar_Music::get_option('sr_singlepost_slug', 'srmp3_settings_widget_player') : $this->sr_GetString('album_slug') ;       
        $album_args['rewrite'] = array(
            'slug' => esc_attr($playlist_single_slug),
        );
        

        register_post_type( SR_PLAYLIST_CPT , $album_args);
        
        
        $album_category_args = array(
            'public'            => true,
            'show_ui'           => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => false,
            'show_admin_column' => true,
            'show_tagcloud'     => false,
            'query_var'         => false,
            'rewrite'           => true,
            'hierarchical'      => true,
            'sort'              => false,
            'labels'            => array(
                'name'          => $this->sr_GetString('Playlist Categories'),
                'all_items'     => esc_html_x('All Categories',       'Taxonomy : all_items',     'sonaar-music'),
                'singular_name' => esc_html_x('Category',             'Taxonomy : singular_name', 'sonaar-music'),
                'add_new_item'  => esc_html_x('Add New Category',     'Taxonomy : add_new_item',  'sonaar-music'),
                'not_found'     => esc_html_x('No categories found.', 'Taxonomy : not_found',     'sonaar-music')
            ),
        );    
        $category_slug = ( Sonaar_Music::get_option('sr_category_slug', 'srmp3_settings_widget_player') != null && Sonaar_Music::get_option('sr_category_slug', 'srmp3_settings_widget_player') != '') ? Sonaar_Music::get_option('sr_category_slug', 'srmp3_settings_widget_player') : $this->sr_GetString('category_slug') ;       
        $album_category_args['rewrite'] = array(
            'slug' => $category_slug,
        );

        register_taxonomy('playlist-category', SR_PLAYLIST_CPT, $album_category_args);

        if ( function_exists('add_theme_support') ) {
            add_theme_support( 'post-thumbnails', array( SR_PLAYLIST_CPT ) );
        }

        flush_rewrite_rules(); 
    }
    
    public function register_widget(){
        register_widget( 'Sonaar_Music_Widget' );
    }
    

    public function srmp3_add_shortcode(){
    
        function sonaar_shortcode_audioplayer( $atts ) {
            
    		/* Enqueue Sonaar Music related CSS and Js file */
    		wp_enqueue_style( 'sonaar-music' );
    		wp_enqueue_style( 'sonaar-music-pro' );
    		wp_enqueue_script( 'sonaar-music-mp3player' );
    		wp_enqueue_script( 'sonaar-music-pro-mp3player' );
    		wp_enqueue_script( 'sonaar_player' );
    		
    		if ( function_exists('sonaar_player') ) {
    			add_action('wp_footer','sonaar_player', 12);
    		}
    		
            extract( shortcode_atts( array(
                'title' => '',
                'albums' => '',
                'show_playlist' => '',
                'hide_artwork' => '',
                'show_album_market' => '',
                'show_track_market' => '',
                'remove_player' => '',
                'enable_sticky_player' => '',
            ), $atts ) );
            
            ob_start();
            
            the_widget('Sonaar_Music_Widget', $atts, array('widget_id'=>'arbitrary-instance-'.uniqid(), 'before_widget'=>'<article class="iron_widget_radio">', 'after_widget'=>'</article>'));
                $output = ob_get_contents();
                ob_end_clean();
                
                return $output;
        }

        add_shortcode( 'sonaar_audioplayer', 'sonaar_shortcode_audioplayer' );

    }

    public function init_my_shortcode_button() {
        $button_slug = 'sonaar_audioplayer';
        $escapedVar = array(
                
            'div' => array(
                'class' => array(),
            ),
            'em' => array(),
            'strong' => array(),
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array()
            ),
            'img' => array(
                'src' => array(),
            ),
            'br' => array(),
            'i' => array(
                'class' => array(),
            ),
        );
        $js_button_data = array(
            'qt_button_text' => esc_html__( 'MP3 Player Shortcode Generator', 'sonaar-music' ),
            'button_tooltip' => esc_html__( 'MP3 Player Shortcode Generator', 'sonaar-music' ),
            'icon'           => 'dashicons-format-audio',
            'author'         => 'Sonaar Music',
            'authorurl'      => 'https://sonaar.io',
            'infourl'        => 'https://sonaar.io',
            'version'        => '1.0.0',
            'include_close'  => true, // Will wrap your selection in the shortcode
            'mceView'        => false, // Live preview of shortcode in editor. YMMV.
            'l10ncancel'     => esc_html__( 'Cancel', 'sonaar-music' ),
            'l10ninsert'     => esc_html__( 'Insert Shortcode', 'sonaar-music' ),
        );

        $shorcodeGeneratorFields = array();
        array_push($shorcodeGeneratorFields, 
            array(
                'name'              => esc_html__( 'Choose Playlist Type:', 'sonaar-music' ),
                'id'                => 'playlist_type',
                'type'              => 'select',
                'show_option_none'  => true,
                'options'           => array(
                    'predefined'        => esc_html__( 'Predefined Playlists', 'cmb2' ),
                    'feed'              => esc_html__( 'Audio URL inputs (advanced)', 'cmb2' ),
                ),
                'default'           => '',
            ),
            array(
                'name'        => esc_html__( 'Choose Playlist(s)' ),
                'id'          => 'albums',
                'type'        => 'post_search_text', // This field type
                'post_type'=> ( Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') != null ) ? Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') : SR_PLAYLIST_CPT,
                'desc'          => sprintf(__('Enter a comma separated list of post IDs. Enter <i>latest</i> to always load the latest published %1$s post. Click the magnifying glass to search for content','sonaar-music'), $this->sr_GetString('playlist') ),
                // Default is 'checkbox', used in the modal view to select the post type
                'select_type' => 'checkbox',
                // Will replace any selection with selection from modal. Default is 'add'
                'select_behavior' => 'add',
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'predefined',
                ),
            ),
        
            array(
                'name'              => esc_html__( 'Playlist Title', 'sonaar-music' ),
                'id'                => 'playlist_title',
                'type'              => 'text',
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'feed',
                ),
            ),
            array(
                'name'              => $this->sr_GetString('Playlist Cover Image'),
                'id'                => 'artwork',
                'type'              => 'file',
                'text'              => array(
                    'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
                ),
                // query_args are passed to wp.media's library query.
                'query_args'        => array(
                    // Or only allow gif, jpg, or png images
                    'type'  => array(
                         'image/gif',
                         'image/jpeg',
                         'image/png',
                    ),
                ),
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'feed',
                ),
            ),
            array(
                'name'              => esc_html__( 'Track MP3 URLs', 'sonaar-music' ),
                'id'                => 'feed',
                'description'    => sprintf( wp_kses( __('eg: https://yourdomain.com/01.mp3 || https://yourdomain.com/02.mp3 . URL must be separated by || . See %1$sthis article%2$s for supported streaming providers.','sonaar-music'), $escapedVar), '<a href="https://sonaar.ticksy.com/article/16450" target="_blank">', '</a>'),
                'type'              => 'textarea_small',
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'feed',
                ),
            ),
            array(
                'name'              => esc_html__( 'Track Titles', 'sonaar-music' ),
                'id'                => 'feed_title',
                'description'       => esc_html__('eg: trackname 01 || trackname 02. Titles must be separated by ||', 'sonaar-music'),
                'type'              => 'textarea_small',
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'feed',
                ),
            ),
            array(
                'name'              => esc_html__( 'Track Image URLs', 'sonaar-music' ),
                'id'                => 'feed_img',
                'description'       => esc_html__('eg: https://yourdomain.com/img01.jpg || https://yourdomain.com/img02.jpg . URL must be separated by ||', 'sonaar-music'),
                'type'              => 'textarea_small',
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'feed',
                ),
            ),
            array(
                'name'              => esc_html__( 'Player Layout:', 'sonaar-music' ),
                'id'                => 'player_layout',
                'type'              => 'select',
                'show_option_none'  => true,
                'options'           => array(
                    'skin_float_tracklist'              => esc_html__( 'Floated', 'sonaar-music' ),
                    'skin_boxed_tracklist'              => esc_html__( 'Boxed', 'sonaar-music' ),
                ),
                'default'           => 'skin_float_tracklist',
                'attributes'    => array(
                    'data-conditional-id'       => 'playlist_type',
                    'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                ),
            ));

        if( function_exists( 'run_sonaar_music_pro' ) ){
            array_push($shorcodeGeneratorFields, 
                array(
                    'name'              => esc_html__( 'Show Skip 15/30 seconds button:', 'sonaar-music' ),
                    'id'                => 'show_skip_bt',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'              => esc_html__( 'Show Shuffle button', 'sonaar-music'),
                    'id'                => 'show_shuffle_bt',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'              => esc_html__( 'Show Speed Lecture button (0.5x, 1x, 2x)', 'sonaar-music'),
                    'id'                => 'show_speed_bt',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'              => esc_html__( 'Show Volume button', 'sonaar-music'),
                    'id'                => 'show_volume_bt',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'              => esc_html__( 'Show Publish Date', 'sonaar-music'),
                    'id'                => 'show_publish_date',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'              => esc_html__( 'Show Number of Player Tracks', 'sonaar-music'),
                    'id'                => 'show_tracks_count',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'              => esc_html__( 'Show Meta Duration', 'sonaar-music'),
                    'id'                => 'show_meta_duration',
                    'type'              => 'select',
                    'show_option_none'  => true,
                    'options'           => array(
                        'default'        => esc_html__( 'default', 'sonaar-music' ),
                        'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                        'false'              => esc_html__( 'No', 'sonaar-music' ),
                    ),
                    'default'           => 'default',
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ));
        };
        array_push($shorcodeGeneratorFields, 
            array(
                'name'              => esc_html__( 'Remove Progress Bar', 'sonaar-music' ),
                'id'                => 'hide_progressbar',
                'type'              => 'select',
                'show_option_none'  => true,
                'options'           => array(
                    'default'        => esc_html__( 'default', 'sonaar-music' ),
                    'true'              => esc_html__( 'Yes', 'sonaar-music' ),
                    'false'              => esc_html__( 'No', 'sonaar-music' ),
                ),
                'default'           => 'default',
                'attributes'    => array(
                    'data-conditional-id'       => 'playlist_type',
                    'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                ),
            ),
            array(
                'name'          => esc_html__( 'Show Controls over Image Cover', 'sonaar-music' ),
                'id'            => 'display_control_artwork',
                'type'          => 'switch',
                'default'       => false,
                'attributes'    => array(
                    'data-conditional-id'       => 'playlist_type',
                    'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                ),
            ),
            array(
                'name'              => esc_html__( 'Hide Cover Image', 'sonaar-music' ),
                'id'                => 'hide_artwork',
                'type'              => 'switch',
                'label'             => array('off'=> 'Show', 'on'=> 'Hide'), //default On, Off
                'default'           => false,
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'predefined',
                ),
            ),
            array(
                'name'              => esc_html__( 'Show Tracklist', 'sonaar-music' ),
                'id'                => 'show_playlist',
                'type'              => 'switch',
                'label'             => array('on'=> 'Yes', 'off'=> 'No'), //default On, Off
                'default'           => true,
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value'  => wp_json_encode( array( 'predefined', 'feed' ) ),
                ),
            ),
            array(
                'name'              => esc_html__( 'Show Track Store', 'sonaar-music' ),
                'id'                => 'show_track_market',
                'type'              => 'switch',
                'label'             => array('on'=> 'Yes', 'off'=> 'No'), //default On, Off
                'default'           => true,
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'predefined',
                ),
            ),
            array(
                'name'              => esc_html__( 'Show Album Store', 'sonaar-music' ),
                'id'                => 'show_album_market',
                'type'              => 'switch',
                'label'             => array('on'=> 'Yes', 'off'=> 'No'), //default On, Off
                'default'           => true,
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value' => 'predefined',
                ),
            ),
            array(
                'name'              => esc_html__( 'Remove Player', 'sonaar-music' ),
                'id'                => 'hide_timeline',
                'type'              => 'switch',
                'label'             => array('on'=> 'Yes', 'off'=> 'No'), //default On, Off
                'default'           => false,
                'attributes'        => array(
                    'data-conditional-id'    => 'playlist_type',
                    'data-conditional-value'  => wp_json_encode( array( 'predefined', 'feed' ) ),
                ),
            ));

        $additional_args = array(
            // Can be a callback or metabox config array
            'cmb_metabox_config'   => array(
                'id'                    => 'shortcode_'. esc_attr($button_slug),
                'fields'                => $shorcodeGeneratorFields,
                'show_on'           => array( 'key' => 'options-page', 'value' => esc_attr($button_slug) ),
            ),

            // Set the conditions of the shortcode buttons
            'conditional_callback'  => 'shortcode_button_only_pages',
        );
    
        if ( function_exists( 'run_sonaar_music_pro' ) ){
            $proParameters = array(
                array(
                    'name'          => esc_html__( 'Show Thumbnail for Each Track', 'sonaar-music' ),
                    'id'            => 'track_artwork',
                    'type'          => 'switch',
                    'default'       => false,
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'          => esc_html__( 'Enable Scrollbar on Tracklist', 'sonaar-music' ),
                    'id'            => 'scrollbar',
                    'type'          => 'switch',
                    'default'       => false,
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),

                ),
                array(
                    'name'          => esc_html__( 'Enable Shuffle', 'sonaar-music' ),
                    'id'            => 'shuffle',
                    'type'          => 'switch',
                    'default'       => false,
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
                array(
                    'name'          => esc_html__( 'Enable Sticky Player', 'sonaar-music' ),
                    'id'            => 'sticky_player',
                    'label'         => array('on'=> 'Yes', 'off'=> 'No'), //default On, Off
                    'type'          => 'switch',
                    'default'       => true,
                    'attributes'    => array(
                        'data-conditional-id'       => 'playlist_type',
                        'data-conditional-value'    => wp_json_encode( array( 'predefined', 'feed' ) ),
                    ),
                ),
            );

            foreach ($proParameters as &$parameter) {
                array_push( $additional_args['cmb_metabox_config']['fields'], $parameter);
            }
        }

        $button = new Shortcode_Button( $button_slug, $js_button_data, $additional_args );
    }


    /**
    * Callback dictates that shortcode button will only display if we're on a 'page' edit screen
    *
    * @return bool Expects a boolean value
    */
    function shortcode_button_only_pages() {
        if ( ! is_admin() || ! function_exists( 'get_current_screen' ) ) {
            return false;
        }
        
        $current_screen = get_current_screen();
        
        if ( ! isset( $current_screen->parent_base ) || $current_screen->parent_base != 'edit' ) {
            return false;
        }
        
        if ( ! isset( $current_screen->post_type ) || $current_screen->post_type != 'page' ) {
            return false;
        }
        
        // Ok, guess we're on a 'page' edit screen
        return true;
    }



    public function manage_album_columns ($columns){
        $iron_cols = array(
            'alb_shortcode'     => esc_html('')
        );
        
        $columns = Sonaar_Music::array_insert($columns, $iron_cols, 'date', 'before');
        
        $iron_cols = array('alb_icon' => '');
        
        $columns = Sonaar_Music::array_insert($columns, $iron_cols, 'title', 'before');
        
        $columns['date'] = esc_html__('Published', 'sonaar-music');   // Renamed date column
        
        return $columns;
    }


    public function manage_album_custom_column ($column, $post_id){
        switch ($column){                        
            case 'alb_shortcode':
                add_thickbox();
                
                echo '<div id="my-content-' . esc_attr($post_id) . '" style="display:none;">
                <h1>Playlist Shorcode</h1>
                <p>Here you can copy and paste the following shortcode anywhere your page</p>
                <textarea name="" id="" style="width:100%; height:150px;"> [sonaar_audioplayer title="' . esc_html(get_the_title( $post_id )) . '" albums="' . esc_attr($post_id) . '" hide_artwork="false" show_playlist="true" show_track_market="true" show_album_market="true" hide_timeline="true"][/sonaar_audioplayer]</textarea>
                </div>';
                echo '<a href="#TB_inline?width=600&height=300&inlineId=my-content-' . esc_attr($post_id) . '" class="thickbox"><span class="dashicons dashicons-format-audio"></span></a>';
                break;
            case 'alb_icon':
                $att_title = _draft_or_post_title();
                
                echo '<a href="' . esc_url(get_edit_post_link( $post_id, true )) . '" title="' . esc_attr( sprintf( esc_html__('Edit &#8220;%s&#8221;', 'sonaar-music'), $att_title ) ) . '">';
                
                if ( $thumb = get_the_post_thumbnail( $post_id, array(64, 64) ) ){
                    echo $thumb;
            }else{
                echo '<img width="46" height="60" src="' . esc_url(wp_mime_type_icon('image/jpeg')) . '" alt="">';
            }
            
            echo '</a>';
            
            break;
        }
    }
    
    public function prefix_admin_scripts( $hook ) {
		global $wp_version;
		if( version_compare( $wp_version, '5.4.2' , '>=' ) ) {
			wp_localize_script(
			  'wp-color-picker',
			  'wpColorPickerL10n',
			  array(
				'clear'            => esc_html__( 'Clear', 'sonaar-music'),
				'clearAriaLabel'   => esc_html__( 'Clear color', 'sonaar-music'),
				'defaultString'    => esc_html__( 'Default', 'sonaar-music'),
				'defaultAriaLabel' => esc_html__( 'Select default color', 'sonaar-music'),
				'pick'             => esc_html__( 'Select Color', 'sonaar-music'),
				'defaultLabel'     => esc_html__( 'Color value', 'sonaar-music')
			  )
			);
		}
	}

    public function checkAlbumVersion(){
        $albums = get_posts( array(
            'post_type' => SR_PLAYLIST_CPT,
            'post_status' => 'publish',
            'posts_per_page' => -1
    	));
    	foreach ( $albums as $album ) {
    		$oldVersion = ( get_post_meta($album->ID,'_alb_tracklist', true) !== '');

    		if ( $oldVersion ) {
                $meta = get_post_meta( $album->ID );
                $newList = array();

                for ($i=0; $i < $meta['alb_tracklist'][0] ; $i++) { 
                    
                    $newStructure = array(
                        'FileOrStream' =>  $meta['alb_tracklist_'. $i .'_FileOrStream'][0],
                        'track_mp3_id' =>  $meta['alb_tracklist_0_track_mp3'][0],
                        'track_mp3' =>  $meta['alb_tracklist_'. $i .'_track_mp3'][0],
                        'stream_link' =>  $meta['alb_tracklist_'. $i .'_stream_link'][0],
                        'stream_title' =>  $meta['alb_tracklist_'. $i .'_stream_title'][0],
                        'stream_artist' =>  $meta['alb_tracklist_'. $i .'_stream_artist'][0],
                        'stream_album' =>  $meta['alb_tracklist_'. $i .'_stream_album'][0],
                        'song_store_list' => array()
                    );

                    for ($a=0; $a < $meta['alb_tracklist_' . $i . '_song_store_list'][0] ; $a++) {
                        $newStructure['song_store_list'][$a] = array(
                            'store-icon'=> 'fab ' . $meta['alb_tracklist_' . $i . '_song_store_list_' . $a . '_song_store_icon'][0],
                            'store-name'=> $meta['alb_tracklist_' . $i . '_song_store_list_' . $a . '_song_store_name'][0],
                            'store-link'=> $meta['alb_tracklist_' . $i . '_song_store_list_' . $a . '_store_link'][0],
                            'store-target'=> $meta['alb_tracklist_' . $i . '_song_store_list_' . $a . '_song_store_target'][0],
                        );
                    }
                    $newList[$i] = $newStructure; 
                }
                    
                delete_post_meta( $album->ID, '_alb_tracklist' );
                update_post_meta( $album->ID, 'alb_tracklist', $newList );

            }
        }
    }

    public function yourprefix_remove_submenus( $submenu_file ) {
        global $plugin_page;
        $slug = 'edit.php?post_type=' . SR_PLAYLIST_CPT;
        $hidden_submenus = array(
            'srmp3_settings_widget_player' => true,
            'srmp3_settings_sticky_player' => true,
            'srmp3_settings_woocommerce' => true,
            'srmp3_settings_popup' => true,
            'srmp3_settings_stats' => true,
            'sonaar_music_pro_tools' => true,
            //'srmp3_settings_podcast_rss' => true,
        );
       
        // Select another submenu item to highlight (optional).
        if($plugin_page == 'sonaar_music_pro_tools'){
            $submenu_file = 'srmp3_settings_tools';
        }else if ( $plugin_page && isset( $hidden_submenus[ $plugin_page ] ) ) {
            $submenu_file = 'srmp3_settings_general';
        }
    
        // Hide the submenu.
        foreach ( $hidden_submenus as $submenu => $unused ) {
            remove_submenu_page( $slug , $submenu );
        }
    
        return $submenu_file;
    }
    

}