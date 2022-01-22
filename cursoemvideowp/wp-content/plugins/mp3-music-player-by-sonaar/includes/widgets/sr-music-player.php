<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Controls_Media;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

use Sonaar_Music_Admin;
use Sonaar_Music;
/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */

class SR_Audio_Player extends Widget_Base {
	public function get_name() {
		return 'music-player';
	}

	public function get_title() {
		return esc_html__( 'MP3 Audio Player', 'sonaar-music' );
	}

	public function get_icon() {
		return 'sricons-logo sonaar-badge';
	}

	public function get_help_url() {
		return 'https://support.sonaar.io';
	}

	public function get_categories() {
		return [ 'elementor-sonaar' ];
	}

	public function get_defaultLayout() {
		return Sonaar_Music::get_option('player_widget_type', 'srmp3_settings_general') ;
	}

	public function get_keywords() {
		return [ 'mp3', 'player', 'audio', 'sonaar', 'podcast', 'music', 'beat', 'sermon', 'episode', 'radio' ,'stream', 'sonar', 'sonnar', 'sonnaar', 'music player', 'podcast player'];
	}

	public function get_script_depends() {
		return [ 'elementor-sonaar' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' 							=> esc_html__( 'Audio Player Settings', 'sonaar-music' ),
				'tab'   							=> Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'album_img',
			[
				'label' => esc_html__( 'Image Cover (Optional)', 'sonaar-music' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => [ 'active' => true,],
				'separator' => 'after',
				'conditions'                    => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'player_layout', 
							'operator' => '==',
							'value' => 'skin_float_tracklist'
						],
						[
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'player_layout', 
									'operator' => '==',
									'value' => 'skin_boxed_tracklist'
								],
								[
									'name' => 'playlist_show_soundwave', 
									'operator' => '!=',
									'value' => 'yes'
								]
							]
						]
					]
				]
			]
		);
		$this->add_control(
				'playlist_source',
				[
					'label'					=> esc_html__( 'Source', 'sonaar-music' ),
					'type' 					=> Controls_Manager::SELECT,
					'label_block'			=> true,
					'options' 				=> [
						'from_cpt' 			=> 'Selected Post(s)',
						'from_cat'			=> 'All Posts',
						'from_elementor' 	=> 'This Widget',
						'from_current_post' => 'Current Post',
					],
					'default' 				=> 'from_cpt',
				]
		);
		$this->add_control(
			'playlist_list',
				[
					'label' => sprintf( esc_html__( 'Select %1$s Post(s)', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist')) ),
					'label_block' => true,
					'description' => sprintf( __('To create new %1$s %2$s Leave blank if you want to display your latest published %1$s', 'sonaar-music'), Sonaar_Music_Admin::sr_GetString('playlist'), __('<a href="' . esc_url(get_admin_url( null, 'post-new.php?post_type=' . SR_PLAYLIST_CPT )) . '" target="_blank">click here</a><br>','sonaar-music')),
					'type' 							=> \Elementor\Controls_Manager::SELECT2,
					'multiple' 						=> true,
					'options'               		=> sr_plugin_elementor_select_playlist(),   
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '==',
					            'value' => 'from_cpt'
					        ],
					    ]
					]   
				]
		);
		
		if ( !function_exists( 'run_sonaar_music_pro' ) ){
			$this->add_control(
				'playlist_list_cat_srpro',
					[
						'label'                 		=> esc_html__( 'All Posts', 'sonaar-music' ),
						'label_block'					=> true,
						'classes' 						=> 'sr-pro-only',
						'type' 							=> \Elementor\Controls_Manager::SELECT2,
						'multiple' 						=> true,
						'options'               		=> srp_elementor_select_category(),   
						'conditions' 					=> [
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'playlist_source',
									'operator' => '==',
									'value' => 'from_cat'
								],
							]
						]   
					]
			);
		}
		if ( function_exists( 'run_sonaar_music_pro' ) ){
			$this->add_control(
				'playlist_list_cat',
					[
						'label'                 		=> esc_html__( 'From specific category(s)', 'sonaar-music' ),
						'label_block'					=> true,
						'type' 							=> \Elementor\Controls_Manager::SELECT2,
						'multiple' 						=> true,
						'options'               		=> srp_elementor_select_category(),   
						'conditions' 					=> [
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'playlist_source',
									'operator' => '==',
									'value' => 'from_cat'
								],
							]
						]   
					]
			);
			$this->add_control(
				'show_cat_description',
				[
					'label' 						=> esc_html__( 'Display category description', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0',
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '==',
					            'value' => 'from_cat'
					        ],
					    ]
					]
				]
			);
			$this->add_control(
				'posts_per_page',
				[
					'label' => esc_html__( 'Max number of posts to load', 'sonaar-music' ),
					'description' => esc_html__( 'Leave blank for all posts', 'sonaar-music' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 10000,
					'step' => 1,
					'default' => 99,
					'conditions'                    => [
						'relation' => 'or',
							'terms' => [
								[
									'name' => 'playlist_source', 
									'operator' => '==',
									'value' => 'from_cat'
								]
							]
					]
				]
			);
		}
		$this->add_control(
			'playlist_title', [
				'label' => esc_html__( 'Playlist Title', 'sonaar-music' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true,],
				'conditions' 					=> [
				    'relation' => 'and',
				    'terms' => [
				        [
				            'name' => 'playlist_source',
				            'operator' => '==',
				            'value' => 'from_elementor'
				        ],
				    ]
				] 
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'feed_source',
			[
				'label' => esc_html__( 'Source', 'sonaar-music' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'media_file',
				'options' => [
					'media_file' => esc_html__( 'Media File', 'sonaar-music' ),
					'external_url' => esc_html__( 'External URL', 'sonaar-music' ),
				],
				'frontend_available' => true,
			]
		);
		$repeater->add_control(
			'feed_source_external_url',
			[
				'label' => esc_html__( 'External URL', 'sonaar-music' ),
				'type' => Controls_Manager::URL,
				'condition' => [
					'feed_source' => 'external_url',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your URL', 'sonaar-music' ),
				'frontend_available' => true,
			]
		);
		$repeater->add_control(
			'feed_source_file',
			[
				'label' => esc_html__( 'Upload MP3 File', 'sonaar-music' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'audio',
				'frontend_available' => true,
				'condition' => [
					'feed_source' => 'media_file',
				],
			]
		);
		$repeater->add_control(
			'feed_track_title', [
				'label' => sprintf( esc_html__( '%1$s Title', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true,],
				'condition' => [
					'feed_source' => 'external_url',
				],
			]
		);
		$repeater->add_control(
			'feed_track_img',
			[
				'label' => sprintf( esc_html__( '%1$s Cover (Optional)', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'description' => sprintf( esc_html__(  'Setting a %1$s cover image will override the main cover image. Recommended: JPG file 500x500px', 'sonaar-music' ), Sonaar_Music_Admin::sr_GetString('track') ),
				'dynamic' => [ 'active' => true,],
			]
		);

		$this->add_control(
			'feed_repeater',
			[
				'label' => sprintf( esc_html__( 'Add %1$s(s)', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ feed_source_file["url"] || feed_source_external_url["url"] }}}',
				'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'play_current_id',
					            'operator' => '==',
					            'value' => ''
					        ],
					        [
					            'name' => 'playlist_source',
					            'operator' => '==',
					            'value' => 'from_elementor'
					        ],
					    ]
				] 
			]
		);
		$this->add_control(
			'hr_storelinks',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '==',
					            'value' => 'from_elementor'
					        ],
					       	[
					            'name' => 'playlist_show_album_market',
					            'operator' => '==',
					            'value' => 'yes'
					        ],
					    ]
				]
			]
		);
		$store_repeater = new \Elementor\Repeater();
		$store_repeater->add_control(
			'store_icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);
		$store_repeater->add_control(
			'store_name', [
				'label' => esc_html__( 'Link Title', 'sonaar-music' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true,],
			]
		);
		$store_repeater->add_control(
			'store_link', [
				'label' => esc_html__( 'Link URL', 'sonaar-music' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true,],
			]
		);

		$this->add_control(
			'storelist_repeater',
			[
				'label' => esc_html__( 'External Link Buttons', 'sonaar-music' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $store_repeater->get_controls(),
				'title_field' => '{{{ store_name || store_link["url"] }}}',
				'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '==',
					            'value' => 'from_elementor'
					        ],
					       	[
					            'name' => 'playlist_show_album_market',
					            'operator' => '==',
					            'value' => 'yes'
					        ],
					    ]
				]
			]
		);
		$this->add_control(
			'hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'player_layout',
			[
				'label'					=> esc_html__( 'Player Design Layout', 'sonaar-music' ),
				'type' 					=> Controls_Manager::SELECT,
				'label_block'			=> true,
				'options' 				=> [
					'skin_float_tracklist'         =>  esc_html__('Floated', 'sonaar-music'),
					'skin_boxed_tracklist'    =>  esc_html__('Boxed', 'sonaar-music'),
				],
				'default' 				=> 'skin_float_tracklist',
			]
		);
		if ( function_exists( 'run_sonaar_music_pro' ) ){
			$this->add_control(
				'enable_sticky_player',
				[
					'label' 						=> esc_html__( 'Sticky Audio Player', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '1', 
				]
			);
			$this->add_control(
				'enable_shuffle',
				[
					'label' 						=> esc_html__( 'Enable Shuffle', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '', 
				]
			);
			$this->add_control(
				'no_track_skip',
				[
					'label' => sprintf( esc_html__( 'Stop when  %1$s ends', 'sonaar-music' ), Sonaar_Music_Admin::sr_GetString('track') ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> 'yes',
					'default' 						=> '', 
				]
			);
		}
		$this->add_control(
			'playlist_show_playlist',
			[
				'label' 							=> esc_html__( 'Show Tracklist', 'sonaar-music' ),
				'type' 								=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 							=> esc_html__( 'Show', 'sonaar-music' ),
				'label_off' 						=> esc_html__( 'Hide', 'sonaar-music' ),
				'return_value' 						=> 'yes',
				'default' 							=> 'yes',
			]
		);
		if ( function_exists( 'run_sonaar_music_pro' ) ){
			$this->add_control(
				'reverse_tracklist',
				[
					'label' 							=> esc_html__( 'Reverse Tracklist', 'sonaar-music' ),
					'type' 								=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 							=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 						=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 						=> 'yes',
					'default' 							=> '',
					'condition' 					=> [
						'playlist_source!' 	=> 'from_elementor',
					],
				]
			);
		}
		$this->add_control(
			'playlist_show_album_market',
			[
				'label' 							=> esc_html__( 'External Links', 'sonaar-music' ),
				'type' 								=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 							=> esc_html__( 'Show', 'sonaar-music' ),
				'label_off' 						=> esc_html__( 'Hide', 'sonaar-music' ),
				'return_value' 						=> 'yes',
				'default' 							=> 'yes',
			]
		);
		
		$this->add_control(
			'playlist_hide_artwork',
			[
				'label' 							=> esc_html__( 'Hide Image Cover', 'sonaar-music' ),
				'type' 								=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 							=> esc_html__( 'Hide', 'sonaar-music' ),
				'label_off' 						=> esc_html__( 'Show', 'sonaar-music' ),
				'return_value' 						=> 'yes',
				'default' 							=> '',
				'conditions'                    => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'player_layout', 
							'operator' => '==',
							'value' => 'skin_float_tracklist'
						],
						[
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'player_layout', 
									'operator' => '==',
									'value' => 'skin_boxed_tracklist'
								],
								[
									'name' => 'playlist_show_soundwave', 
									'operator' => '!=',
									'value' => 'yes'
								]
							]
						]
					]
				]
			]
		);
		$this->add_control(
			'sr_player_on_artwork',
			[
				'label' 						=> esc_html__( 'Show Controls over Image Cover', 'sonaar-music' ),
				'type' 							=> Controls_Manager::SWITCHER,
				'default' 						=> '',
				'return_value' 					=> 'yes',
				'conditions'                    => [
					'relation' => 'or',
					'terms' => [
						[
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'player_layout', 
									'operator' => '==',
									'value' => 'skin_float_tracklist'
								],
								[
									'name' => 'playlist_hide_artwork', 
									'operator' => '!=',
									'value' => 'yes'
								]
							]
						],
						[
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'player_layout', 
									'operator' => '==',
									'value' => 'skin_boxed_tracklist'
								],
								[
									'name' => 'playlist_show_soundwave', 
									'operator' => '!=',
									'value' => 'yes'
								],
								[
									'name' => 'playlist_hide_artwork', 
									'operator' => '!=',
									'value' => 'yes'
								]
							]
						]
					]
				]
			]
		);
		$this->add_control(
			'playlist_show_soundwave',
			[
				'label' 							=> esc_html__( 'Hide Mini Player / Soundwave', 'sonaar-music' ),
				'type' 								=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 							=> esc_html__( 'Hide', 'sonaar-music' ),
				'label_off' 						=> esc_html__( 'Show', 'sonaar-music' ),
				'return_value' 						=> 'yes',
				'default' 							=> '',
			]
		);

// Deprecated control: play_current_id. It's always hidden except for old installation. This has been replaced by playlist_source = from_current_post
		$this->add_control(
			'play_current_id',
			[
				'label'							 	=> esc_html__( 'Play its own Post ID track', 'sonaar-music' ),
				'description' 						=> esc_html__( 'Check this case if this player is intended to be displayed on its own single post', 'sonaar-music' ),
				'type' 								=> \Elementor\Controls_Manager::SWITCHER,
				'yes' 								=> esc_html__( 'Yes', 'sonaar-music' ),
				'no' 								=> esc_html__( 'No', 'sonaar-music' ),
				'return_value' 						=> 'yes',
				'default' 							=> '',
				'conditions' 					=> [
				    'relation' => 'and',
				    'terms' => [
				        [
				            'name' => 'playlist_source',
				            'operator' => '!=',
				            'value' => 'from_elementor'
				        ],
						[
							'name' => 'play_current_id',
							'operator' => '!=',
							'value' => ''
						],				       
				    ]
				]
			]
		);
		if ( !function_exists( 'run_sonaar_music_pro' ) ){
			$this->add_control(
				'hr',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
			$this->add_control(
				'enable_sticky_player_pro-only',
				[
					'label' 						=> esc_html__( 'Sticky Audio Player', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'description' 					=> esc_html__( 'This option allows you to display a sticky footer player bar on this page', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			$this->add_control(
				'enable_volume_pro-only',
				[
					'label' 						=> esc_html__( 'Display Volume Control', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			$this->add_control(
				'enable_playlistduration_pro-only',
				[
					'label' 						=> esc_html__( 'Display Playlist Duration', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			
			$this->add_control(
				'enable_publishdate_pro-only',
				[
					'label' 						=> esc_html__( 'Display Publish Date', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			$this->add_control(
				'enable_numbersoftrack_pro-only',
				[
					'label' 						=> sprintf( esc_html__( 'Display Total Numbers of %1$ss', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			$this->add_control(
				'enable_skipbt_pro-only',
				[
					'label' 						=> esc_html__( 'Display Skip 15/30 seconds button', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			$this->add_control(
				'enable_speedrate_pro-only',
				[
					'label' 						=> esc_html__( 'Display Speed Rate button', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
			
			$this->add_control(
				'enable_shuffle_pro-only',
				[
					'label' 						=> esc_html__( 'Display Shuffle/Random button', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '0', 
					'classes' 						=> 'sr-pro-only',
				]
			);
		}

		/*}*/
		$this->end_controls_section();
		if ( !function_exists( 'run_sonaar_music_pro' ) ){
			$this->start_controls_section(
				'go_pro_content',
				[
					'label' 						=> esc_html__( 'Go Pro', 'sonaar-music' ),
					'tab'   						=> Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'sonaar_go_pro',
				[
					'type' 							=> \Elementor\Controls_Manager::RAW_HTML,
					'raw' 							=> 	'<div class="sr_gopro elementor-nerd-box sonaar-gopro">' .
														'<i class="elementor-nerd-box-icon fa fas fa-bolt" aria-hidden="true"></i>
															<div class="elementor-nerd-box-title">' .
																__( 'Meet the MP3 Player PRO', 'sonaar-music' ) .
															'</div>
															<div class="elementor-nerd-box-message">' .
																__( 'Our PRO version lets you use Elementor\'s Style Editor to customize the look and feel of the player in real-time! Over 70+ options available!', 'sonaar-music' ) .
															'</div>
															<ul>
																<li><i class="eicon-check"></i>Sticky Player with Soundwave</li>
																<li><i class="eicon-check"></i>Elementor Real-Time Style Editor</li>
																<li><i class="eicon-check"></i>Display thumbnail beside each tracks</li>
																<li><i class="eicon-check"></i>Input feed URL directly in the widget</li>
																<li><i class="eicon-check"></i>Volume Control</li>
																<li><i class="eicon-check"></i>Shuffle Tracks</li>
																<li><i class="eicon-check"></i>Build dynamic playlist</li>
																<li><i class="eicon-check"></i>Tool to import/bulk create playlists</li>
																<li><i class="eicon-check"></i>Tracklist View</li>
																<li><i class="eicon-check"></i>Statistic Reports</li>
																<li><i class="eicon-check"></i>1 year of support via live chat</li>
																<li><i class="eicon-check"></i>1 year of plugin updates</li>
															</ul>
															<div class="elementor-nerd-box-message">' .
																__( 'All those features are available with the MP3 Player\'s Pro Version.', 'sonaar-music' ) .
															'</div>
															<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-go-pro" href="https://sonaar.io/free-mp3-music-player-plugin-for-wordpress/?utm_source=Sonaar+Music+Free+Plugin&utm_medium=plugin" target="_blank">' .
															__( 'Go Pro', 'elementor' ) .
															'</a>
														</div>',
				]
			);
		$this->end_controls_section();
		}

		/**
         * STYLE: ARTWORK
         * -------------------------------------------------
         */
		if ( function_exists( 'run_sonaar_music_pro' ) ){
			$this->start_controls_section(
	            'artwork_style',
	            [
	                'label'                 		=> esc_html__( 'Image Cover', 'sonaar-music' ),
					'tab'                   		=> Controls_Manager::TAB_STYLE,
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_hide_artwork', 
										'operator' => '!=',
										'value' => 'yes'
									]
								]
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_boxed_tracklist'
									],
									[
										'name' => 'playlist_show_soundwave', 
										'operator' => '!=',
										'value' => 'yes'
									],
									[
										'name' => 'playlist_hide_artwork', 
										'operator' => '!=',
										'value' => 'yes'
									]
								]
							]
						]
					]
	            ]
			);
			$this->add_responsive_control(
				'artwork_width',
				[
					'label' 						=> esc_html__( 'Image Width', 'sonaar-music' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'min' 					=> 1,
							'max' 					=> 450,
						],
					],
					'default' 						=> [
							'unit' => 'px',
							'size' => 300,
							],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_float_tracklist"] .album .album-art' => 'width: {{SIZE}}px;',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_responsive_control(
				'boxed_artwork_width',
				[
					'label' 						=> esc_html__( 'Image Width', 'sonaar-music' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'min' 					=> 1,
							'max' 					=> 450,
						],
					],
					'default' 						=> [
							'unit' => 'px',
							'size' => 160,
							],
					'selectors' 					=> [
						'{{WRAPPER}} .iron-audioplayer:not(.sonaar-no-artwork) .srp_player_grid' => 'grid-template-columns: {{SIZE}}px 1fr;',
						'{{WRAPPER}} .srp_player_boxed .album-art' => 'width: {{SIZE}}px; max-width: {{SIZE}}px;',
						'{{WRAPPER}} .srp_player_boxed .sonaar-Artwort-box' => 'min-width: {{SIZE}}px;'
					],	
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
				]
			);
			$this->add_responsive_control(
				'artwork_padding',
				[
					'label' 						=> esc_html__( 'Image Padding', 'sonaar-music' ),
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .sonaar-grid .album' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_responsive_control(
				'artwork_radius',
				[
					'label' 						=> esc_html__( 'Image Radius', 'elementor' ),
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 300,
						],
					],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .album .album-art img' => 'border-radius: {{SIZE}}px;',
					],
				]
			);
			$this->add_control(
				'artwork_vertical_align',
				[
					'label' 					=> esc_html__( 'Center the Image vertically with the Tracklist', 'sonaar-music' ),
					'type' 						=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 					=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 				=> esc_html__( 'No', 'sonaar-music' ),
					'default' 					=> '',
					'return_value' 				=> 'yes',
					'condition' 					=> [
						'playlist_show_playlist!' 	=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selectors' 				=> [
												'{{WRAPPER}} .sonaar-grid' => 'align-items: center;',
						 
				 ],
				]
			);
			$this->add_control(
				'audio_player_artwork_controls_color',
				[
					'label'                 		=> esc_html__( 'Audio Player Controls over Image', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'separator'						=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer.sr_player_on_artwork .sonaar-Artwort-box .control path, {{WRAPPER}} .iron-audioplayer.sr_player_on_artwork .sonaar-Artwort-box .control rect, {{WRAPPER}} .iron-audioplayer.sr_player_on_artwork .sonaar-Artwort-box .control polygon' => 'fill: {{VALUE}};',
													'{{WRAPPER}} .iron-audioplayer.sr_player_on_artwork .sonaar-Artwort-box .control .play' => 'border-color:{{VALUE}};'
					],
					'condition' 					=> [
						'sr_player_on_artwork' 	=> 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'audio_player_artwork_controls_scale',
				[
					
					'label' 						=> esc_html__( 'Control Size Scale', 'sonaar-music' ),
					'type' 							=> \Elementor\Controls_Manager::NUMBER,
					'min' 							=> 0,
					'max' 							=> 10,
					'step' 							=> 0.1,
					'default' 						=> 1,
					'condition' 					=> [
						'sr_player_on_artwork' 		=> 'yes',
					],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer.sr_player_on_artwork .sonaar-Artwort-box .control' => 'transform:scale({{SIZE}});',
					],
				]
			);

			$this->end_controls_section();



			/**
	         * STYLE: SOUNDWAVE 
	         * -------------------------------------------------
	         */
			
			$this->start_controls_section(
	            'player',
	            [
	                'label'							=> esc_html__( 'Mini Player & Soundwave', 'sonaar-music' ),
					'tab'							=> Controls_Manager::TAB_STYLE,
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'player_layout', 
								'operator' => '==',
								'value' => 'skin_boxed_tracklist'
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_show_soundwave', 
										'operator' => '!=',
										'value' => 'yes'
									]
								]
							]
						]
					]
	            ]
			);
			$this->add_control(
				'playlist_title_soundwave_show',
				[
					'label' 						=> sprintf( esc_html__( 'Hide %1$s Title', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist/podcast')) ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default'						=> '',
					'return_value' 					=> 'yes',
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'player_layout', 
								'operator' => '==',
								'value' => 'skin_boxed_tracklist'
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_show_playlist', 
										'operator' => '==',
										'value' => ''
									]
								]
							]
						]
					],
				]
			);
			$this->add_control(
				'playlist_title_html_tag_soundwave',
				[
					'label' => sprintf( esc_html__( 'HTML %1$s Title Tag', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist/podcast')) ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
						'div' => 'div',
						'span' => 'span',
						'p' => 'p',
					],
					'default' => 'div',
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'player_layout', 
								'operator' => '==',
								'value' => 'skin_boxed_tracklist'
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_title_soundwave_show', 
										'operator' => '==',
										'value' => ''
									],
									[
										'name' => 'playlist_show_playlist', 
										'operator' => '==',
										'value' => ''
									]
								]
							]
						]
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'playlist_title_soundwave_typography',
					'label' => sprintf( esc_html__( '%1$s Title Typography', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist/podcast')) ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'player_layout', 
								'operator' => '==',
								'value' => 'skin_boxed_tracklist'
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_title_soundwave_show', 
										'operator' => '==',
										'value' => ''
									],
									[
										'name' => 'playlist_show_playlist', 
										'operator' => '==',
										'value' => ''
									]
								]
							]
						]
					],
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .track-title, {{WRAPPER}} .iron-audioplayer .album-title',
				]
			);
			$this->add_control(
				'playlist_title_soundwave_color',
				[
					'label' => sprintf( esc_html__( '%1$s Title Color', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist/podcast')) ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'player_layout', 
								'operator' => '==',
								'value' => 'skin_boxed_tracklist'
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_title_soundwave_show', 
										'operator' => '==',
										'value' => ''
									],
									[
										'name' => 'playlist_show_playlist', 
										'operator' => '==',
										'value' => ''
									]
								]
							]
						]
					],
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .track-title, {{WRAPPER}} .iron-audioplayer .srp_player_boxed .track-title, {{WRAPPER}} .iron-audioplayer .player, {{WRAPPER}} .iron-audioplayer .album-title' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'hr7',
				[
					'type' 							=> \Elementor\Controls_Manager::DIVIDER,
					'style' 						=> 'thick',
					'condition' 					=> [
						'playlist_show_playlist' 	=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_control(
				'player_subtitle_btshow',
				[
					'label' 						=> esc_html__( 'Hide Subtitle', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'none',
					'selectors' 					=> [
													'{{WRAPPER}} .srp_player_boxed .srp_subtitle' => 'display:{{VALUE}}!important;',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
					'separator'						=> 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'player_subtitle_typography',
					'label' 						=> esc_html__( 'Subtitle Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'player_subtitle_btshow' 			=> '',
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
					'selector' 						=> '{{WRAPPER}} .srp_player_boxed .srp_subtitle',
				]
			);
			$this->add_control(
				'player_subtitle-color',
				[
					'label'                		 	=> esc_html__( 'Subtitle Color', 'sonaar-music' ),
					'type'                		 	=> Controls_Manager::COLOR,
					'default'            		    => '',
					'condition' 					=> [
						'player_subtitle_btshow' 			=> '',
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
					'selectors'             		=> [
													'{{WRAPPER}} .srp_player_boxed .srp_subtitle' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'title_soundwave_show',
				[
					'label' 						=> sprintf( esc_html__( 'Hide %1$s Title', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default'						=> '',
					'return_value' 					=> 'yes',
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
					/*'selectors' 					=> [
							 						'{{WRAPPER}} .iron-audioplayer .track-title' => 'display:{{VALUE}};',
					 ],*/
				]
			);
			$this->add_control(
				'title_html_tag_soundwave',
				[
					'label' => sprintf( esc_html__( 'HTML %1$s Title Tag', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
						'div' => 'div',
						'span' => 'span',
						'p' => 'p',
					],
					'default' => 'div',
					'condition' 					=> [
						'title_soundwave_show' 		=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'title_soundwave_typography',
					'label' 						=> sprintf( esc_html__( '%1$s Title Typography', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'title_soundwave_show' 		=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selector' 						=> '{{WRAPPER}} div.iron-audioplayer .track-title',
				]
			);
			$this->add_control(
				'title_soundwave_color',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Title Color', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'condition' 					=> [
						'title_soundwave_show' 		=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selectors'             		=> [
													'{{WRAPPER}} div.iron-audioplayer .track-title, {{WRAPPER}} .iron-audioplayer .player' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'cat_description_typo',
					'label' 						=> esc_html__( 'Description/About Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'separator'						=> 'before',
					'condition' 					=> [
						'show_cat_description' 	=> '1',
					],
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .srp_podcast_rss_description',
				]
			);
			$this->add_control(
				'cat_description_color',
				[
					'label'                 		=> esc_html__( 'Description/About  Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'condition' 					=> [
						'show_cat_description' 	=> '1',
					],
					'selectors'            			=> [
													'{{WRAPPER}} .iron-audioplayer .srp_podcast_rss_description' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'soundwave_show',
				[
					'label' 						=> esc_html__( 'Hide SoundWave', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'separator'						=> 'before',
					'return_value' 					=> 'yes',
				]
			);
			$this->add_control(
				'soundWave_progress_bar_color',
				[
					'label'                 		=> esc_html__( 'SoundWave Progress Bar Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'             		=> [
						'{{WRAPPER}} .sonaar_wave_cut rect' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .sr_waveform_simplebar .sonaar_wave_cut' => 'background-color: {{VALUE}}',
					],
					'condition' 					=> [
						'soundwave_show' 			=> '',
					],
					'render_type' => 'template',
					
				]
			);
			$this->add_control(
				'soundWave_bg_bar_color',
				[
					'label'                 		=> esc_html__( 'SoundWave Background Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'             		=> [
						'{{WRAPPER}} .sonaar_wave_base rect' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .sr_waveform_simplebar .sonaar_wave_base' => 'background-color: {{VALUE}}',
					],			
					'condition' 					=> [
						'soundwave_show' 			=> '',
					],
					'render_type' => 'template',
				]
			);
			if(Sonaar_Music::get_option('waveformType', 'srmp3_settings_general') === 'simplebar'){
				$this->add_responsive_control(
					'simple_bar_height',
					[
						
						'label' 						=> esc_html__( 'Progress Bar Height', 'sonaar-music' ),
						'type' 							=> Controls_Manager::SLIDER,
						'range' 						=> [
						'px' 						=> [
							'min'					=> 1,
							'max' 					=> 50,
						],
						],
						/*'type' 							=> \Elementor\Controls_Manager::NUMBER,
						'min' 							=> 1,
						'max' 							=> 20,
						'step' 							=> 1,
						'default' 						=> 5,*/
						'condition' 					=> [
							'soundwave_show' 			=> '',
						],
						'selectors' 					=> [
														'{{WRAPPER}} .sr_waveform_simplebar .sonaar_fake_wave .sonaar_wave_base, {{WRAPPER}} .sr_waveform_simplebar .sonaar_fake_wave .sonaar_wave_cut' => 'height:{{SIZE}}px!important;',
						],
					]
				);
				$this->add_responsive_control(
					'simple_bar_radius',
					[
						'label' 						=> esc_html__( 'Progress Bar Radius', 'elementor' ),
						'type' 							=> Controls_Manager::SLIDER,
						
						'range' 						=> [
							'px' 						=> [
								'max' 					=> 20,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 0,
						],
						'selectors' 					=> [
														'{{WRAPPER}} .sr_waveform_simplebar .sonaar_fake_wave .sonaar_wave_base, {{WRAPPER}} .sr_waveform_simplebar .sonaar_fake_wave .sonaar_wave_cut' => 'border-radius: {{SIZE}}px;',
						],
					]
				);
			}
			$this->add_control(
				'progressbar_inline',
				[
					'label' 						=> esc_html__( 'Inline Progress Bar', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'yes',
					'condition' 					=> [
						'soundwave_show' 			=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_control(
				'duration_soundwave_show',
				[
					'label' 						=> esc_html__( 'Hide Time Durations', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'yes',
					'separator'						=> 'before',
					'condition' 					=> [
						'soundwave_show' 			=> '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'duration_soundwave_typography',
					'label' 						=> esc_html__( 'Time Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'duration_soundwave_show' 	=> '',
						'soundwave_show' 			=> '',
					],
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .player',
				]
			);
			$this->add_control(
				'duration_soundwave_color',
				[
					'label'                 		=> esc_html__( 'Time Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'condition' 					=> [
						'duration_soundwave_show' 	=> '',
						'soundwave_show' 			=> '',
					],
					'selectors'            			=> [
													'{{WRAPPER}} .iron-audioplayer .currentTime, {{WRAPPER}} .iron-audioplayer .totalTime' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'audio_player_controls_color',
				[
					'label'                 		=> esc_html__( 'Audio Player Controls Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'separator'						=> 'before',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .control path, {{WRAPPER}} .iron-audioplayer .control rect, {{WRAPPER}} .iron-audioplayer .control polygon, {{WRAPPER}} .srp-play-button path, {{WRAPPER}} .srp-play-button rect' => 'fill: {{VALUE}}',
													'{{WRAPPER}} .iron-audioplayer .control .sr_speedRate div' => 'color: {{VALUE}}; border-color: {{VALUE}} ',
													'{{WRAPPER}} .iron-audioplayer .control' => 'color: {{VALUE}};',
													'{{WRAPPER}} .srp-play-button circle' => 'stroke: {{VALUE}};',
													'{{WRAPPER}} .iron-audioplayer .srp-play-button-label-container' => 'background: {{VALUE}};',
													
					],
				]
			);
			$this->add_control(
				'audio_player_play_text_color',
				[
					'label'                 		=> esc_html__( 'Play/Pause Text Color ', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .srp-play-button-label-container' => 'color: {{VALUE}};',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
				]
			);
			$this->add_control(
				'use_play_label',
				[
					'label' 		=> esc_html__( 'Show Text instead of Play Icon', 'sonaar-music' ),
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> [
						'default' 	=> esc_html__( 'Default', 'sonaar-music' ),
						'true' 		=> esc_html__( 'Yes', 'sonaar-music' ),
						'false' 	=> esc_html__( 'No', 'sonaar-music' ),
					],
					'default' 		=> 'default',
					'condition' 	=> [
					'player_layout' => 'skin_boxed_tracklist',
					],
				]
			);
			$this->add_responsive_control(
				'audio_player_controls_spacebefore',
				[
					'label' 					=> esc_html__( 'Add Space Before Player Control', 'sonaar-music' ) . ' (px)',
					'type' 						=> Controls_Manager::SLIDER,
					'range' 					=> [
						'px' 					=> [
							'min'				=> -500,
							'max' 				=> 100,
						],
					],
					'selectors' 				=> [
								'{{WRAPPER}} .iron-audioplayer .album-player .control' => 'top: {{SIZE}}px;position:relative;',
					],
					'condition' 				=> [
					'progressbar_inline'		=> '',
					],
				]
			);
			$this->add_control(
				'show_skip_bt',
				[
					'label' 		=> esc_html__( 'Show Skip 15/30 Seconds button', 'sonaar-music' ),
					'type' 			=> Controls_Manager::SELECT,
					'separator'		=> 'before',
					'options' 		=> [
						'default' 	=> esc_html__( 'Default', 'sonaar-music' ),
						'true' 		=> esc_html__( 'Yes', 'sonaar-music' ),
						'false' 	=> esc_html__( 'No', 'sonaar-music' ),
					],
					'default' 		=> 'default',
				]
			);

			$this->add_control(
				'show_shuffle_bt',
				[
					'label' 		=> esc_html__( 'Show Shuffle button', 'sonaar-music' ),
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> [
						'default' 	=> esc_html__( 'Default', 'sonaar-music' ),
						'true' 		=> esc_html__( 'Yes', 'sonaar-music' ),
						'false' 	=> esc_html__( 'No', 'sonaar-music' ),
					],
					'default' 		=> 'default',
				]
			);

			$this->add_control(
				'show_speed_bt',
				[
					'label' 		=> esc_html__( 'Show Playback Speed button', 'sonaar-music' ),
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> [
						'default' 	=> esc_html__( 'Default', 'sonaar-music' ),
						'true' 		=> esc_html__( 'Yes', 'sonaar-music' ),
						'false' 	=> esc_html__( 'No', 'sonaar-music' ),
					],
					'default' 		=> 'default',
				]
			);

			$this->add_control(
				'show_volume_bt',
				[
					'label' 		=> esc_html__( 'Show Volume Control', 'sonaar-music' ),
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> [
						'default' 	=> esc_html__( 'Default', 'sonaar-music' ),
						'true'		=> esc_html__( 'Yes', 'sonaar-music' ),
						'false' 	=> esc_html__( 'No', 'sonaar-music' ),
					],
					'default' 		=> 'default',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'player_background',
					'label' => esc_html__( 'Background', 'elementor-sonaar' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}} .iron-audioplayer .srp_player_boxed, {{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_float_tracklist"] .album-player',
					'separator' 				=> 'before',
				]
			);
			
			$this->add_responsive_control(
				'artwork_boxed_vertical_align',
				[
					'label' 						=> esc_html__( 'Vertical Alignment with the Image Cover', 'sonaar-music' ),
					'type' 							=> Controls_Manager::CHOOSE,
					'options' 						=> [
						'flex-start'    					=> [
							'title' 				=> esc_html__( 'Top', 'elementor' ),
							'icon' 					=> 'eicon-v-align-top',
						],
						'center' 					=> [
							'title' 				=> esc_html__( 'Center', 'elementor' ),
							'icon' 					=> 'eicon-v-align-middle',
						],
						'flex-end' 					=> [
							'title' 				=> esc_html__( 'Bottom', 'elementor' ),
							'icon' 					=> 'eicon-v-align-bottom',
						],
					],
					'default' 						=> '',
					'separator'					=> 'after',
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
					'selectors' 					=> [
														'{{WRAPPER}} .iron-audioplayer .srp_player_grid' => 'align-items:{{VALUE}}',
					],
				]
			);
			$this->end_controls_section();




	        /**
	         * STYLE: PLAYLIST
	         * -------------------------------------------------
	         */
				
			$this->start_controls_section(
	            'playlist_style',
	            [
	                'label'                			=> esc_html__( 'Tracklist', 'sonaar-music' ),
					'tab'                   		=> Controls_Manager::TAB_STYLE,
					'condition' 					=> [
						'playlist_show_playlist!' 	=> '',
					],
				]
			);
			$this->add_control(
					'move_playlist_below_artwork',
					[
						'label' 					=> esc_html__( 'Move Tracklist Below Artwork', 'sonaar-music' ),
						'type' 						=> \Elementor\Controls_Manager::SWITCHER,
						'label_on' 					=> esc_html__( 'Yes', 'sonaar-music' ),
						'label_off' 				=> esc_html__( 'No', 'sonaar-music' ),
						'return_value' 				=> 'auto',
						'separator'					=> 'after',
						'default' 					=> '',
						'prefix_class'				=> 'sr_playlist_below_artwork_',
						'condition' 				=> [
							'playlist_hide_artwork!' => 'yes',
							'player_layout' 	=> 'skin_float_tracklist',
						],
						'selectors' 				=> [
													'{{WRAPPER}} .sonaar-grid' => 'flex-direction: column;',
													
													//'{{WRAPPER}} .sonaar-Artwort-box' => 'justify-self:center;',
													//'{{WRAPPER}} .sonaar-grid' => 'justify-content:center!important;grid-template-columns:{{VALUE}}!important;',
							 
					 ],
					]
			);
			
			$this->add_control(
				'track_artwork_heading',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Image', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> Controls_Manager::HEADING,
					//'separator' 					=> 'before',
				]
			);
			$this->add_control(
				'track_artwork_show',
				[
					'label' 						=> sprintf( esc_html__( 'Show Thumbnail for Each %1$s', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default'						=> '',
					'return_value' 					=> 'yes',
				]
			);
			$this->add_responsive_control(
				'track_artwork_size',
				[
					'label' 						=> esc_html__( 'Thumbnail Width', 'sonaar-music' ) . ' (px)',
					'type'							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 500,
						],
					],
					'size_units' 					=> [ 'px', '%' ],
					'selectors' 					=> [
													//'{{WRAPPER}} .iron-audioplayer .sonaar-grid-2' => 'grid-template-columns: auto {{SIZE}}{{UNIT}};',
													'{{WRAPPER}} .iron-audioplayer .playlist li .sr_track_cover' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' 					=> [
						'track_artwork_show' 		=> 'yes',
					],
				]
			);
			$this->add_control(
				'alignment_options',
				[
					'label' 						=> esc_html__( 'Tracklist Alignments', 'sonaar-music' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_responsive_control(
				'playlist_justify',
				[
					'label' 						=> esc_html__( 'Tracklist Alignment', 'sonaar-music' ),
					'type' 							=> Controls_Manager::CHOOSE,
					'options' 						=> [
						'flex-start'    					=> [
							'title' 				=> esc_html__( 'Left', 'elementor' ),
							'icon' 					=> 'eicon-h-align-left',
						],
						'center' 					=> [
							'title' 				=> esc_html__( 'Center', 'elementor' ),
							'icon' 					=> 'eicon-h-align-center',
						],
						'flex-end' 					=> [
							'title' 				=> esc_html__( 'Right', 'elementor' ),
							'icon' 					=> 'eicon-h-align-right',
						],
					],
					'default' 						=> 'center',
					'selectors' 					=> [
														'{{WRAPPER}} .iron-audioplayer .sonaar-grid' => 'justify-content: {{VALUE}};',
														'{{WRAPPER}}.sr_playlist_below_artwork_auto .iron-audioplayer .sonaar-grid' => 'align-items:{{VALUE}}',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist'
					],
				]
			);
			$this->add_responsive_control(
				'artwork_align',
				[
					'label' 						=> esc_html__( 'Image Alignment', 'sonaar-music' ),
					'type' 							=> Controls_Manager::CHOOSE,
					'options' 						=> [
						'flex-start'    					=> [
							'title' 				=> esc_html__( 'Left', 'elementor' ),
							'icon' 					=> 'eicon-h-align-left',
						],
						'center' 					=> [
							'title' 				=> esc_html__( 'Center', 'elementor' ),
							'icon' 					=> 'eicon-h-align-center',
						],
						'flex-end' 					=> [
							'title' 				=> esc_html__( 'Right', 'elementor' ),
							'icon' 					=> 'eicon-h-align-right',
						],
					],
					'default' 						=> '',
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .sonaar-Artwort-box' => 'justify-content: {{VALUE}};',
													//'{{WRAPPER}} .iron-audioplayer .sonaar-Artwort-box' => 'justify-self: {{VALUE}}!important; text-align: {{VALUE}};',
					],
					'conditions' 					=> [
						'relation' => 'and',
						'terms' => [
							[
								'name' => 'sr_player_on_artwork',
								'operator' => '==',
								'value' => ''
							],
							[
								'name' => 'playlist_hide_artwork',
								'operator' => '==',
								'value' => ''
							],
							[
								'name' => 'playlist_show_playlist',
								'operator' => '!=',
								'value' => ''
							],
							[
								'name' => 'move_playlist_below_artwork',
								'operator' => '!=',
								'value' => ''
							],
						]
					],
				]
			);
			$this->add_responsive_control(
				'playlist_width',
				[
					'label' 						=> esc_html__( 'Tracklist Width', 'sonaar-music' ) . ' (px)',
					'type'							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 2000,
						],
					],
					'size_units' 					=> [ 'px', 'vw', '%' ],
					'selectors' 					=> [
													//'{{WRAPPER}} .iron-audioplayer .sonaar-grid-2' => 'grid-template-columns: auto {{SIZE}}{{UNIT}};',
													'{{WRAPPER}} .iron-audioplayer .playlist, {{WRAPPER}} .iron-audioplayer .sonaar-Artwort-box, {{WRAPPER}} .iron-audioplayer .buttons-block' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist'
					],
					'render_type'					=> 'template',
				]
			);
			$this->add_control(
				'title_options',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Title', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist/podcast')) ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_control(
				'title_html_tag_playlist',
				[
					'label' => esc_html__( 'HTML Title Tag', 'sonaar-music' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
						'div' => 'div',
						'span' => 'span',
						'p' => 'p',
					],
					'default' => 'h3',
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist'
					],
				]
			);
			$this->add_control(
				'title_btshow',
				[
					'label' 						=> esc_html__( 'Hide Title', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'none',
					'selectors' 					=> [
						 							'{{WRAPPER}} .playlist .sr_it-playlist-title' => 'display:{{VALUE}};',
					 ],
					 'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist'
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'title_typography',
					'label' 						=> esc_html__( 'Title Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'title_btshow' 				=> '',
						'player_layout' 	=> 'skin_float_tracklist'
					],
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .sr_it-playlist-title',
				]
			);
			$this->add_control(
				'title_color',
				[
					'label'                			=> esc_html__( 'Title Color', 'sonaar-music' ),
					'type'                 			=> Controls_Manager::COLOR,
					'default'               		=> '',
					'condition' 					=> [
						'title_btshow'				=> '',
						'player_layout' 	=> 'skin_float_tracklist'
					],
					'selectors'             		=> [
													'{{WRAPPER}} .playlist .sr_it-playlist-title, {{WRAPPER}} .srp_player_meta' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'title_align',
				[
					'label' 						=> esc_html__( 'Title Alignment', 'sonaar-music' ),
					'type' 							=> Controls_Manager::CHOOSE,
					'options' 						=> [
						'left'    					=> [
							'title' 				=> esc_html__( 'Left', 'elementor' ),
							'icon' 					=> 'eicon-h-align-left',
						],
						'center' 					=> [
							'title' 				=> esc_html__( 'Center', 'elementor' ),
							'icon' 					=> 'eicon-h-align-center',
						],
						'right' 					=> [
							'title' 				=> esc_html__( 'Right', 'elementor' ),
							'icon' 					=> 'eicon-h-align-right',
						],
					],
					'default' 						=> '',
					'condition' 					=> [
						'title_btshow'				=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selectors' 					=> [
													'{{WRAPPER}} .sr_it-playlist-title, {{WRAPPER}} .sr_it-playlist-artists, {{WRAPPER}} .srp_subtitle' => 'text-align: {{VALUE}}!important;',
													'{{WRAPPER}} .iron-audioplayer .srp_player_meta' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'title_indent',
				[
					
					'label' 						=> esc_html__( 'Title Indent', 'sonaar-music' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'min' 					=> -500,
						],
					],
					'condition' 					=> [
						'title_btshow' 				=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selectors' 					=> [
													'{{WRAPPER}} .sr_it-playlist-title' => 'margin-left: {{SIZE}}px;',
													'{{WRAPPER}} .sr_it-playlist-artists' => 'margin-left: {{SIZE}}px;',
													'{{WRAPPER}} .srp_subtitle' => 'margin-left: {{SIZE}}px;',
					],
				]
			);

			$this->add_control(
				'subtitle_options',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Subtitle', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('playlist/podcast')) ),
					'type' 							=> Controls_Manager::HEADING,
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'separator' 					=> 'before',
				]
			);
			$this->add_control(
				'subtitle_btshow',
				[
					'label' 						=> esc_html__( 'Hide Subtitle', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'none',
					'selectors' 					=> [
							 						'{{WRAPPER}} .playlist .srp_subtitle' => 'display:{{VALUE}}!important;',
					 ],
					 'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'subtitle_typography',
					'label' 						=> esc_html__( 'Subtitle Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'subtitle_btshow' 			=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selector' 						=> '{{WRAPPER}} .playlist .srp_subtitle',
					
				]
			);
			$this->add_control(
				'subtitle-color',
				[
					'label'                		 	=> esc_html__( 'Subtitle Color', 'sonaar-music' ),
					'type'                		 	=> Controls_Manager::COLOR,
					'default'            		    => '',
					'condition' 					=> [
						'subtitle_btshow' 			=> '',
						'player_layout' 	=> 'skin_float_tracklist',
					],
					'selectors'             		=> [
													'{{WRAPPER}} .playlist .srp_subtitle' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'track_options',
				[
					'label' 						=> esc_html__( 'Tracklist', 'elementor' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'track_title_typography',
					'label' 						=> sprintf( esc_html__( '%1$s Title Typography', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .playlist .audio-track, {{WRAPPER}} .iron-audioplayer .playlist .track-number',
				]
			);
			$this->start_controls_tabs( 'tabs_tracktitle_style' );
			$this->start_controls_tab(
				'tab_tracktitle_normal',
				[
					'label' 						=> esc_html__( 'Normal', 'elementor' ),
				]
			);
			$this->add_control(
				'track_title_color',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Title Color', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type'                 		 	=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'            		 	=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .audio-track, {{WRAPPER}} .iron-audioplayer .playlist .track-number,  {{WRAPPER}} .iron-audioplayer .player, {{WRAPPER}} .iron-audioplayer .sr-playlist-item .srp_noteButton, {{WRAPPER}} .srp_track_description' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'track_list_linked',
				[
					'label' 						=> sprintf( esc_html__( 'Link title to the %1$s page', 'sonaar-music' ), Sonaar_Music_Admin::sr_GetString('playlist') ),
					'type' 						=> Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'sonaar-music' ),
						'true' => esc_html__( 'Yes', 'sonaar-music' ),
						'false' => esc_html__( 'No', 'sonaar-music' ),
					],
					'default'					=> 'default',
					'condition' 					=> [
						'playlist_show_playlist!' 	=> '',
						'playlist_source!' 	=> 'from_elementor'
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_tracktitle_hover',
				[
					'label' 						=> esc_html__( 'Hover', 'elementor' ),
				]
			);
			$this->add_control(
				'tracklist_hover_color',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Title Hover Color', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .audio-track:hover, {{WRAPPER}} .iron-audioplayer .playlist .audio-track:hover .track-number, {{WRAPPER}} .iron-audioplayer .playlist a.song-store:not(.sr_store_wc_round_bt):hover, {{WRAPPER}} .iron-audioplayer .playlist .current a.song-store:not(.sr_store_wc_round_bt):hover' => 'color: {{VALUE}}',
													'{{WRAPPER}} .iron-audioplayer .playlist .audio-track:hover path, {{WRAPPER}} .iron-audioplayer .playlist .audio-track:hover rect' => 'fill: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'tab_tracktitle_active',
				[
					'label' 						=> esc_html__( 'Active', 'elementor' ),
				]
			);
			$this->add_control(
				'tracklist_active_color',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Title Active Color', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type'                 			=> Controls_Manager::COLOR,
					'default'              			=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .current .audio-track, {{WRAPPER}} .iron-audioplayer .playlist .current .audio-track .track-number, {{WRAPPER}} .iron-audioplayer .playlist .current a.song-store' => 'color: {{VALUE}}',
													'{{WRAPPER}} .iron-audioplayer .playlist .current .audio-track path, {{WRAPPER}} .iron-audioplayer .playlist .current .audio-track rect' => 'fill: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();		
			$this->add_control(
				'track_separator_color',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Separator Color', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> Controls_Manager::COLOR,
					'separator' 					=> 'before',
					'default' 						=> '',
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .playlist ul > li' => 'border-bottom: solid 1px {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'track_bgcolor',
				[
					'label'                			=> esc_html__( 'Tracklist Item Background', 'sonaar-music' ),
					'type'                 		 	=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'            		 	=> [
													'{{WRAPPER}} .sr-playlist-item'=> 'background: {{VALUE}}',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist'
					],
				]
			);

			$this->add_responsive_control(
				'tracklist_spacing',
				[
					'label' 						=> sprintf( esc_html__( '%1$s Spacing', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 50,
						],
					],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_float_tracklist"] .playlist .sr-playlist-item' => 'padding-top: {{SIZE}}px;padding-bottom: {{SIZE}}px;',
													'{{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_boxed_tracklist"] .sr-playlist-item + .sr-playlist-item' => 'margin-top: {{SIZE}}px;',
					],
				]
			);

			$this->add_responsive_control(
				'track_padding',
				[
					'label' 						=> esc_html__( 'Tracklist Item Padding', 'sonaar-music' ) . ' (px)', 
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_boxed_tracklist"] .playlist li.sr-playlist-item' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
												],
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist'
					],
				]
			);
			$this->add_control(
				'play_pause_bt_show',
				[
					'label' 						=> esc_html__( 'Hide Play/Pause Button', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default'						=> '',
					'return_value' 					=> 'yes',
					'separator' 					=> 'before',
					'selectors' => [
						'{{WRAPPER}} .iron-audioplayer .track-number' => 'display:none;',
					],
				]
			);
			$this->add_control(
				'tracklist_controls_color',
				[
					'label'                			=> esc_html__( 'Play/Pause Button Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'              		 	=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .audio-track path, {{WRAPPER}} .iron-audioplayer .playlist .audio-track rect' => 'fill: {{VALUE}}',
					],
					'condition' 					=> [
						'play_pause_bt_show' 		=> '',
					],
				]
			);
			$this->add_responsive_control(
				'tracklist_controls_size',
				[
					'label' => esc_html__( 'Play/Pause Button Size', 'sonaar-music' ) . ' (px)',
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .iron-audioplayer .track-number svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
						'{{WRAPPER}} .iron-audioplayer .track-number' => 'padding-left: calc({{SIZE}}px + 12px);',
						'{{MOBILE}}{{WRAPPER}} .iron-audioplayer .srp_tracklist-item-date' => 'padding-left: calc({{SIZE}}px + 12px);',
					],
					'condition' 					=> [
						'play_pause_bt_show' 		=> '',
					],
				]
			);
			$this->add_control(
				'hide_number_btshow',
				[
					'label' 						=> sprintf( esc_html__( 'Hide %1$s Number', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'separator' 					=> 'before',
					'return_value' 					=> 'none',
					'selectors' 					=> [
							 						'{{WRAPPER}} .iron-audioplayer .track-number .number' => 'display:{{VALUE}};',
							 						'{{WRAPPER}} .iron-audioplayer .track-number' => 'padding-right:0;',
					 ],
				]
			);
			$this->add_control(
					'hide_time_duration',
					[
						'label' 					=> sprintf( esc_html__( 'Hide %1$s Duration', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
						'type' 						=> \Elementor\Controls_Manager::SWITCHER,
						'label_on' 					=> esc_html__( 'Yes', 'sonaar-music' ),
						'label_off' 				=> esc_html__( 'No', 'sonaar-music' ),
						'return_value' 				=> 'none',
						'separator' 				=> 'before',
						'default'					=> '',
						'selectors' 				=> [
							 							'{{WRAPPER}} .iron-audioplayer .tracklist-item-time' => 'display:{{VALUE}};'
					 ],
					]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'duration_typography',
					'label' 						=> esc_html__( 'Duration Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'hide_time_duration' 		=> '',
					],
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .tracklist-item-time',
				]
			);
			$this->add_control(
				'duration_color',
				[
					'label'                			=> esc_html__( 'Duration Color', 'sonaar-music' ),
					'type'                 			=> Controls_Manager::COLOR,
					'default'               		=> '',
					'condition' 					=> [
						'hide_time_duration' 		=> '',
					],
					'selectors'             		=> [
													'{{WRAPPER}} .tracklist-item-time' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'show_track_publish_date',
				[
					'label' 					=> esc_html__( 'Show Publish Date', 'sonaar-music' ),
					'type' 						=> Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'sonaar-music' ),
						'true' => esc_html__( 'Yes', 'sonaar-music' ),
						'false' => esc_html__( 'No', 'sonaar-music' ),
					],
					'separator' 				=> 'before',
					'default'					=> 'default',
					'condition' 					=> [
						'playlist_show_playlist!' 	=> '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'date_typography',
					'label' 						=> esc_html__( 'Publish Date Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .srp_tracklist-item-date',
					'condition' 					=> [
						'playlist_show_playlist!' 	=> '',
					],
				]
			);
			$this->add_control(
				'date_color',
				[
					'label'                			=> esc_html__( 'Publish Date Color', 'sonaar-music' ),
					'type'                 			=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .srp_tracklist-item-date' => 'color: {{VALUE}}',
					],
					'condition' 					=> [
						'playlist_show_playlist!' 	=> '',
					],
				]
			);$this->add_control(
				'hide_trackdesc',
				[
					'label' 					=> sprintf( esc_html__( 'Hide %1$s Description', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 						=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' => esc_html__( 'No', 'sonaar-music' ),
					'return_value' => '1',
					'default' => '0',
					'separator' 				=> 'before',
					
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'track_desc_typography',
					'label' 						=> esc_html__( 'Description Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'selector' 						=> '{{WRAPPER}} .srp_track_description',
					'condition' => [
						'hide_trackdesc!' => '1',
					],
				]
			);
			$this->add_control(
				'track_desc_color',
				[
					'label'                			=> esc_html__( 'Description Color', 'sonaar-music' ),
					'type'                 			=> Controls_Manager::COLOR,
					'default'               		=> '',
					'selectors'             		=> [
													'{{WRAPPER}} .srp_track_description' => 'color: {{VALUE}}',
					],
					'condition' => [
						'hide_trackdesc!' => '1',
					],
				]
			);
			$this->add_control(
				'track_desc_lenght',
				[
					'label' => esc_html__( 'Description Lenght', 'sonaar-music' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 100000,
					'step' => 1,
					'default' => 55,
					'condition' => [
						'hide_trackdesc!' => '1',
					],
				]
			);
			$this->add_control(
				'strip_html_track_desc',
				[
					'label' => esc_html__( 'Strip HTML', 'sonaar-music' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' => esc_html__( 'No', 'sonaar-music' ),
					'return_value' => '1',
					'default' => '1',
					'condition' => [
						'hide_trackdesc!' => '1',
					],
				]
			);
			$this->add_control(
				'cta_icon_options',
				[
					'label' 						=> esc_html__( 'Call-to-Action Buttons', 'elementor' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					    ]
					] 
				]
			);
			$this->add_control(
				'hide_track_market',
				[
					'label'							=> sprintf( esc_html__( 'Hide %1$s\'s Call-to-Action(s)', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value'					=> 'yes',
					'default' 						=> '',
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					    ]
					] 
				]
			);
			$this->add_control(
				'view_icons_alltime',
				[
					'label' 						=> esc_html__( 'Display Icons without Popover', 'sonaar-music' ),
					'description' 					=> 'Turn off if you have a lot of icons',
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> 'yes',
					'default' 						=> 'yes',
					'prefix_class'					=> 'sr_track_inline_cta_bt__',
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					        [
					            'name' => 'hide_track_market',
					            'operator' => '==',
					            'value' => ''
					        ],
					    ]
					],
					
				]
			);
			$this->add_control(
				'popover_icons_store',
				[
					'label' 						=> esc_html__( 'Popover Icon Color', 'sonaar-music' ),
					'type'							=> Controls_Manager::COLOR,
					'default' 						=> '',
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					        [
					            'name' => 'view_icons_alltime',
					            'operator' => '==',
					            'value' => ''
					        ],
					        [
					            'name' => 'hide_track_market',
					            'operator' => '==',
					            'value' => ''
					        ],
					    ]
					],
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .song-store-list-menu .fa-ellipsis-v' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'tracklist_label_typography',
					'label' 						=> esc_html__( 'Button Label Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					        [
					            'name' => 'hide_track_market',
					            'operator' => '==',
					            'value' => ''
					        ],
					    ]
					],
					'selector' 						=> '{{WRAPPER}} .iron-audioplayer .playlist a.song-store',
				]
			);
			$this->add_control(
				'tracklist_icons_color',
				[
					'label'                 		=> esc_html__( 'Icons Color When No Label Present', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					        [
					            'name' => 'hide_track_market',
					            'operator' => '==',
					            'value' => ''
					        ],
					    ]
					],
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist a.song-store:not(.sr_store_wc_round_bt)' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'wc_icons_color',
				[
					'label'                 		=> esc_html__( 'Label Button Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'conditions' 					=> [
						'relation' => 'and',
						'terms' => [
							[
								'name' => 'playlist_source',
								'operator' => '!=',
								'value' => 'from_elementor'
							],
							[
								'name' => 'hide_track_market',
								'operator' => '==',
								'value' => ''
							],
						]
					],
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'wc_icons_bg_color',
				[
					'label'                 		=> esc_html__( 'Label Button Background Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'conditions' 					=> [
						'relation' => 'and',
						'terms' => [
							[
								'name' => 'playlist_source',
								'operator' => '!=',
								'value' => 'from_elementor'
							],
							[
								'name' => 'hide_track_market',
								'operator' => '==',
								'value' => ''
							],
						]
					],
					'selectors'             		=> [
													'{{WRAPPER}} .iron-audioplayer .playlist a.song-store.sr_store_wc_round_bt' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'tracklist_icons_spacing',
				[
					'label' 						=> esc_html__( 'Button Spacing', 'elementor' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 50,
						],
					],
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					        [
					            'name' => 'hide_track_market',
					            'operator' => '==',
					            'value' => ''
					        ],
					    ]
					],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .store-list .song-store-list-container' => 'column-gap: {{SIZE}}px;',
					],
				]
			);
			$this->add_responsive_control(
				'tracklist_icons_size',
				[
					'label' 						=> esc_html__( 'Icon Button Size (when no label is present)', 'sonaar-music' ) . ' (px)', 
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 50,
						],
					],
					'conditions' 					=> [
					    'relation' => 'and',
					    'terms' => [
					        [
					            'name' => 'playlist_source',
					            'operator' => '!=',
					            'value' => 'from_elementor'
					        ],
					        [
					            'name' => 'hide_track_market',
					            'operator' => '==',
					            'value' => ''
					        ],
					    ]
					],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .playlist .store-list .song-store .fab, {{WRAPPER}} .iron-audioplayer .playlist .store-list .song-store .fas' => 'font-size: {{SIZE}}px;',
					],
				]
			);
			$this->add_control(
				'cta_playlist_options',
				[
					'label' 						=> esc_html__( 'Tracklist Container', 'elementor' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'playlist_bgcolor',
					'label' => esc_html__( 'Background', 'elementor-sonaar' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_boxed_tracklist"] .playlist, {{WRAPPER}} .iron-audioplayer[data-playertemplate="skin_float_tracklist"] .sonaar-grid',
				]
			);
			
			$this->add_responsive_control(
				'playlist_margin',
				[
					'label' 						=> esc_html__( 'Container Margin', 'sonaar-music' ) . ' (px)', 
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .playlist' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_float_tracklist'
					],
				]
			);
			$this->add_responsive_control(
				'playlist_padding',
				[
					'label' 						=> esc_html__( 'Container Padding', 'sonaar-music' ) . ' (px)', 
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .playlist' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist'
					],
				]
			);
			$this->add_responsive_control(
				'tracklist_margin',
				[
					'label' 						=> esc_html__( 'Tracklist Margin', 'sonaar-music' ) . ' (px)', 
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .srp_tracklist' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'player_layout' 	=> 'skin_float_tracklist'
					],
				]
			);
			$this->add_control(
				'scrollbar_options',
				[
					'label' 						=> esc_html__( 'Scrollbar', 'elementor' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
				]
			);
			$this->add_control(
				'scrollbar',
				[
					'label' 						=> esc_html__( 'Enable Scrollbar', 'sonaar-music' ),
					'description' 					=> 'Enable a vertical scrollbar on your tracklist',
					'type' 							=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 						=> esc_html__( 'Yes', 'sonaar-music' ),
					'label_off' 					=> esc_html__( 'No', 'sonaar-music' ),
					'return_value' 					=> '1',
					'default' 						=> '',
				]
			);
			$this->add_responsive_control(
				'playlist_height',
				[
					'label' 						=> esc_html__( 'Scrollbar Height', 'sonaar-music' ) . ' (px)',
					'type'							=> Controls_Manager::SLIDER,
					'condition' 					=> [
													'scrollbar' => '1',
					],
					'default'						=> [
						'unit' 						=> 'px',
						'size' 						=> 215,
					],
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 2000,
						],
					],
					'size_units' 					=> [ 'px', 'vh', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer .playlist ul' => 'height: {{SIZE}}{{UNIT}}; overflow-y:hidden; overflow-x:hidden;',
					],
				]
			);	
			$this->end_controls_section();





			/**
	         * STYLE: METADATA
	         * -------------------------------------------------
	         */
				
			$this->start_controls_section(
	            'metadata_style',
	            [
	                'label'                			=> esc_html__( 'Metadata', 'sonaar-music' ),
					'tab'                   		=> Controls_Manager::TAB_STYLE,
					'conditions'                    => [
						'relation' => 'or',
						'terms' => [
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_float_tracklist'
									],
									[
										'name' => 'playlist_show_playlist', 
										'operator' => '!=',
										'value' => ''
									]
								]
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'player_layout', 
										'operator' => '==',
										'value' => 'skin_boxed_tracklist'
									],
									[
										'name' => 'playlist_show_soundwave', 
										'operator' => '!=',
										'value' => 'yes'
									]
								]
							]
						]
					]
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'metadata_typography',
					'label' 						=> esc_html__( 'Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'selector' 						=> '{{WRAPPER}} .sr_it-playlist-publish-date, {{WRAPPER}} .srp_playlist_duration, {{WRAPPER}} .srp_trackCount',
				]
			);	
			$this->add_control(
				'metadata_color',
				[
					'label'                		 	=> esc_html__( 'Color', 'sonaar-music' ),
					'type'                		 	=> Controls_Manager::COLOR,
					'default'            		    => '',
					'selectors'             		=> [
						'{{WRAPPER}} .sr_it-playlist-publish-date, {{WRAPPER}} .srp_playlist_duration, {{WRAPPER}} .srp_trackCount' => 'color: {{VALUE}}',
					],
				]
			);	
			$this->add_control(
				'publishdate_btshow',
				[
					'label' 						=> esc_html__( 'Show Date in the Mini-Player', 'sonaar-music' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'sonaar-music' ),
						'true' => esc_html__( 'Show', 'sonaar-music' ),
						'false' => esc_html__( 'Hide', 'sonaar-music' ),
					],
					'default' => 'default',
					'condition' => [
						'playlist_source!' => 'from_elementor',
					],
				]
			);
			$this->add_control(
				'nb_of_track_btshow',
				[
					'label' 						=> sprintf( esc_html__( 'Show Total Number of %1$ss', 'sonaar-music' ), ucfirst(Sonaar_Music_Admin::sr_GetString('track')) ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'sonaar-music' ),
						'true' => esc_html__( 'Show', 'sonaar-music' ),
						'false' => esc_html__( 'Hide', 'sonaar-music' ),
					],
					'default' => 'default',
				]
			);
			$this->add_control(
				'playlist_duration_btshow',
				[
					'label' 						=> esc_html__( 'Show Total Playlist Time Duration', 'sonaar-music' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'sonaar-music' ),
						'true' => esc_html__( 'Show', 'sonaar-music' ),
						'false' => esc_html__( 'Hide', 'sonaar-music' ),
					],
					'default' => 'default',
				]
			);			
			$this->end_controls_section();






			/**
	         * STYLE: External Links Buttons
	         * -------------------------------------------------
	         */
			
			$this->start_controls_section(
	            'album_stores',
	            [
	                'label'                			=> esc_html__( 'External Links Buttons', 'sonaar-music' ),
					'tab'                   		=> Controls_Manager::TAB_STYLE,
					'condition' 					=> [
						'playlist_show_album_market' => 'yes',
					],
	            ]
			);
			$this->add_control(
				'album_store_position',
				[
					'label' 						=> esc_html__( 'Move Links below soundwave', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'top',
					'condition' 					=> [
						'player_layout' 	=> 'skin_boxed_tracklist',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'storelinks_background',
					'label' => esc_html__( 'Background', 'elementor-sonaar' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}} .iron-audioplayer .album-store',
				]
			);
			$this->add_control(
				'store_heading_options',
				[
					'label' 						=> esc_html__( 'Heading Style', 'elementor' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
				]
			);
			$this->add_control(
				'store_title_btshow',
				[
					'label' 						=> esc_html__( 'Hide Heading', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'none',
					'selectors' 					=> [
							 						'{{WRAPPER}} .available-now' => 'display:{{VALUE}};',
					 ],
				]
			);
			$this->add_control(
				'store_title_text',
				[
					'label' 						=> esc_html__( 'Heading text', 'sonaar-music' ),
					'type' 							=> Controls_Manager::TEXT,
					'dynamic' 						=> [
						'active' 					=> true,
					],
					'default' 						=> '',
					'condition' 					=> [
						'store_title_btshow' 		=> '',
					],
					'label_block' 					=> false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'store_title_typography',
					'label' 						=> esc_html__( 'Heading Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'condition' 					=> [
						'store_title_btshow' 		=> '',
					],
					'selector' 						=> '{{WRAPPER}} .available-now',
				]
			);
			$this->add_control(
				'store_title_color',
				[
					'label'                 		=> esc_html__( 'Heading Color', 'sonaar-music' ),
					'type'                  		=> Controls_Manager::COLOR,
					'default'               		=> '',
					'condition' 					=> [
						'store_title_btshow' 		=> '',
					],
					'selectors'             		=> [
						'{{WRAPPER}} .available-now' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'store_title_align',
				[
					'label' 						=> esc_html__( 'Heading Alignment', 'sonaar-music' ),
					'type' 							=> Controls_Manager::CHOOSE,
					'options' 						=> [
						'flex-start'    					=> [
							'title' 				=> esc_html__( 'Left', 'elementor' ),
							'icon' 					=> 'eicon-h-align-left',
						],
						'center' 					=> [
							'title' 				=> esc_html__( 'Center', 'elementor' ),
							'icon' 					=> 'eicon-h-align-center',
						],
						'flex-end' 					=> [
							'title' 				=> esc_html__( 'Right', 'elementor' ),
							'icon' 					=> 'eicon-h-align-right',
						],
					],
					'default' 						=> '',
					'condition' 					=> [
						'store_title_btshow' 		=> '',
					],
					'selectors' 					=> [
														'{{WRAPPER}} .ctnButton-block' => 'justify-content: {{VALUE}};align-items:{{VALUE}}',
													//'{{WRAPPER}} .available-now' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'store_links_options',
				[
					'label' 						=> esc_html__( 'Button Style', 'elementor' ),
					'type' 							=> Controls_Manager::HEADING,
					'separator' 					=> 'before',
				]
			);
			$this->add_responsive_control(
				'album_stores_align',
				[
					'label'						 	=> esc_html__( 'Links Alignment', 'sonaar-music' ),
					'type' 							=> Controls_Manager::CHOOSE,
					'options' 						=> [
						'flex-start'    					=> [
							'title' 				=> esc_html__( 'Left', 'elementor' ),
							'icon' 					=> 'eicon-h-align-left',
						],
						'center' 					=> [
							'title' 				=> esc_html__( 'Center', 'elementor' ),
							'icon' 					=> 'eicon-h-align-center',
						],
						'flex-end' 					=> [
							'title' 				=> esc_html__( 'Right', 'elementor' ),
							'icon' 					=> 'eicon-h-align-right',
						],
					],
					'default' 						=> '',
					'selectors' 					=> [
													'{{WRAPPER}} .buttons-block' => 'justify-content: {{VALUE}};align-items: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 							=> 'store_button_typography',
					'label'						 	=> esc_html__( 'Button Typography', 'sonaar-music' ),
					'scheme' 						=> Typography::TYPOGRAPHY_1,
					'selector' 						=> '{{WRAPPER}} a.button',
				]
			);

			$this->start_controls_tabs( 'tabs_button_style' );

			$this->start_controls_tab(
				'tab_button_normal',
				[
					'label' 						=> esc_html__( 'Normal', 'elementor' ),
				]
			);

			$this->add_control(
				'button_text_color',
				[
					'label' 						=> esc_html__( 'Text Color', 'sonaar-music' ),
					'type' 							=> Controls_Manager::COLOR,
					'default' 						=> '',
					'selectors' 					=> [
													'{{WRAPPER}} a.button' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'background_color',
				[
					'label' 						=> esc_html__( 'Button Color', 'sonaar-music' ),
					'type' 							=> Controls_Manager::COLOR,
					/*'scheme' 						=> [
						'type' 						=> Scheme_Color::get_type(),
						'value' 					=> Scheme_Color::COLOR_4,
					],*/
					'selectors' 					=> [
													'{{WRAPPER}} a.button' => 'background: {{VALUE}}',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_hover',
				[
					'label' 						=> esc_html__( 'Hover', 'elementor' ),
				]
			);

			$this->add_control(
				'button_hover_color',
				[
					'label' 						=> esc_html__( 'Text Color', 'sonaar-music' ),
					'type' 							=> Controls_Manager::COLOR,
					'selectors' 					=> [
													'{{WRAPPER}} a.button:hover' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'button_background_hover_color',
				[
					'label' 						=> esc_html__( 'Button Color', 'sonaar-music' ),
					'type' 							=> Controls_Manager::COLOR,
					'selectors'					 	=> [
													'{{WRAPPER}} a.button:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'button_hover_border_color',
				[
					'label' 						=> esc_html__( 'Button Border Color', 'sonaar-music' ),
					'type' 							=> Controls_Manager::COLOR,
					'condition' 					=> [
						'border_border!' 			=> '',
					],
					'selectors' 					=> [
													'{{WRAPPER}} a.button:hover' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 							=> 'border',
					'selector' 						=> '{{WRAPPER}} .buttons-block .store-list li .button',
					'separator' 					=> 'before',
				]
			);
			$this->add_control(
				'button_border_radius',
				[
					'label' 						=> esc_html__( 'Button Radius', 'elementor' ),
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 20,
						],
					],
					'selectors' 					=> [
													'{{WRAPPER}} .store-list .button' => 'border-radius: {{SIZE}}px;',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 							=> 'button_box_shadow',
					'selector' 						=> '{{WRAPPER}} .store-list .button',
				]
			);
			$this->add_responsive_control(
				'button_text_padding',
				[
					'label' 						=> esc_html__( 'Button Padding', 'sonaar-music' ),
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .iron_widget_radio .store-list .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' 					=> 'before',
				]
			);
			$this->add_responsive_control(
				'space_between_store_button',
				[
					'label' 						=> esc_html__( 'Buttons Space', 'sonaar-music' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'range' 						=> [
						'px' 						=> [
							'max' 					=> 50,
						],
					],
					'selectors' 					=> [
													'{{WRAPPER}} .buttons-block .store-list' => 'column-gap: {{SIZE}}px;', 
					],
				]
			);
			$this->add_control(
				'hr6',
				[
					'type' 							=> \Elementor\Controls_Manager::DIVIDER,
					'style' 						=> 'thick',
				]
			);
			$this->add_control(
				'store_icon_show',
				[
					'label' 						=> esc_html__( 'Hide Icon', 'sonaar-music' ),
					'type' 							=> Controls_Manager::SWITCHER,
					'default' 						=> '',
					'return_value' 					=> 'none',
					'selectors' 					=> [
							 						'{{WRAPPER}} .store-list .button i' => 'display:{{VALUE}};',
					 ],
				]
			);
			$this->add_responsive_control(
				'icon-font-size',
				[
					'label'							=> esc_html__( 'Icon Font Size', 'sonaar-music' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'condition' 					=> [
						'store_icon_show'			=> '',
					],
					'range' 						=> [
						'px' 						=> [
						'max' 						=> 100,
						],
					],
					'selectors'						=> [
													'{{WRAPPER}} .buttons-block .store-list i' => 'font-size: {{SIZE}}px;', 
					],
				]
			);
			$this->add_responsive_control(
				'icon_indent',
				[
					'label' 						=> esc_html__( 'Icon Spacing', 'elementor' ) . ' (px)',
					'type' 							=> Controls_Manager::SLIDER,
					'condition' 					=> [
						'store_icon_show' 			=> '',
					],
					'range' 						=> [
						'px' 						=> [
						'max' 						=> 50,
						],
					],
					'selectors' 					=> [
													'{{WRAPPER}} .buttons-block .store-list i' => 'margin-right: {{SIZE}}px;',
					],
				]
			);

			$this->add_control(
				'hr11',
				[
					'type' 							=> \Elementor\Controls_Manager::DIVIDER,
					'style' 						=> 'thick',
				]
			);
			$this->add_responsive_control(
				'album_stores_padding',
				[
					'label' 						=> esc_html__( 'Link Buttons Margin', 'sonaar-music' ),
					'type' 							=> Controls_Manager::DIMENSIONS,
					'size_units' 					=> [ 'px', 'em', '%' ],
					'selectors' 					=> [
													'{{WRAPPER}} .iron-audioplayer.show-playlist .ctnButton-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

		// end if function exist
		}
		//
	
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$playlist_show_album_market = (($settings['playlist_show_album_market']=="yes") ? 'true' : 'false');
		$playlist_show_playlist = (($settings['playlist_show_playlist']=="yes") ? 'true' : 'false');
		$playlist_show_soundwave = (($settings['playlist_show_soundwave']=="yes") ? 'true' : 'false');
		$playlist_playlist_hide_artwork = (($settings['playlist_hide_artwork']=="yes") ? 'true' : 'false');
		
		
		if ( function_exists( 'run_sonaar_music_pro' ) ){
			$sticky_player = $settings['enable_sticky_player'];
			$shuffle = $settings['enable_shuffle'];
			$wave_color = $settings['soundWave_bg_bar_color'];
			$wave_progress_color = $settings['soundWave_progress_bar_color'];
		}else{
			$sticky_player = false;
			$shuffle = false;
			$wave_color = false;
			$wave_progress_color = false;
			$settings['title_html_tag_soundwave'] = 'div';
			$settings['playlist_title_html_tag_soundwave'] = 'div';
			$settings['title_html_tag_playlist'] = 'h3';
		}

		$shortcode = '[sonaar_audioplayer titletag_soundwave="'. $settings['playlist_title_html_tag_soundwave'] .'" track_titletag_soundwave="'. $settings['title_html_tag_soundwave'] .'" titletag_playlist="'. $settings['title_html_tag_playlist'] .'" hide_artwork="' . $playlist_playlist_hide_artwork .'" show_playlist="' . $playlist_show_playlist .'" reverse_tracklist="' . $settings['reverse_tracklist'] .'" show_album_market="' . $playlist_show_album_market .'" hide_timeline="' . $playlist_show_soundwave .'" sticky_player="' . $sticky_player .'" wave_color="' . $wave_color .'" wave_progress_color="' . $wave_progress_color .'" shuffle="' . $shuffle .'" ';
		if (isset($settings['show_cat_description'])){
			$shortcode .='show_cat_description="'. $settings['show_cat_description']  .'" ';
		}
		if (isset($settings['player_layout'])){
			$shortcode .= 'player_layout="' . $settings['player_layout'] . '" ';
		}

		if (isset($settings['show_skip_bt'])){
			$shortcode .= 'show_skip_bt="'. $settings['show_skip_bt'] .'" ';
		}

		if (isset($settings['show_speed_bt'])){
			$shortcode .= 'show_speed_bt="'. $settings['show_speed_bt'] .'" ';
		}

		if (isset($settings['show_volume_bt'])){
			$shortcode .= 'show_volume_bt="'. $settings['show_volume_bt'] .'" ';
		}

		if (isset($settings['show_shuffle_bt'])){
			$shortcode .= 'show_shuffle_bt="'. $settings['show_shuffle_bt'] .'" ';
		}

		if( $settings['playlist_title'] ){
			$shortcode .= 'playlist_title="'. $settings['playlist_title'] . '" ';
		}
		
		if( isset($settings['publishdate_btshow']) && $settings['publishdate_btshow'] != ''){
			$shortcode .= 'show_publish_date="'. $settings['publishdate_btshow'] . '" ';
		}
		if( isset($settings['playlist_duration_btshow']) && $settings['playlist_duration_btshow'] != ''){
			$shortcode .= 'show_meta_duration="'. $settings['playlist_duration_btshow'] . '" ';
		}
		if( isset($settings['nb_of_track_btshow']) && $settings['nb_of_track_btshow'] != ''){
			$shortcode .= 'show_tracks_count="'. $settings['nb_of_track_btshow'] . '" ';
		}
		if ( $settings['playlist_source'] == 'from_elementor' && !$settings['playlist_list']) {	
				
			$feed = '1';
			$shortcode .= 'feed=1 ';
			$shortcode .= 'el_widget_id="' . $this->get_id() .'" ';

			update_post_meta( get_the_ID(), 'srmp3_elementor_tracks', $settings['feed_repeater'] ); // update post meta to retrieve data in json later
			update_post_meta( get_the_ID(), 'alb_store_list', $settings['storelist_repeater'] ); // update post meta store list
		
		}

		if (isset($settings['hide_track_market']) && function_exists( 'run_sonaar_music_pro' )){
			$playlist_hide_track_market = (($settings['hide_track_market']=="yes") ? 'false' : 'true');
			$shortcode .= 'show_track_market="' . $playlist_hide_track_market . '" ';
		}else{
			$shortcode .= 'show_track_market="true" ';
		}
		if (isset($settings['track_artwork_show']) && $settings['track_artwork_show'] == 'yes'){
			$shortcode .= 'track_artwork="true" ';
		}
		if (isset($settings['scrollbar']) && $settings['scrollbar'] == '1' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'scrollbar="true" ';
		}
		if (isset($settings['title_soundwave_show']) && $settings['title_soundwave_show']=='yes' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'hide_track_title="true" ';
		}
		if (isset($settings['playlist_title_soundwave_show']) && $settings['playlist_title_soundwave_show']=='yes' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'hide_player_title="true" ';
		}
		if (isset($settings['use_play_label'])){
			$shortcode .= 'use_play_label="'. $settings['use_play_label'] .'" ';
		}
		if (isset($settings['duration_soundwave_show']) && $settings['duration_soundwave_show']=='yes' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'hide_times="true" ';
		}
		if (isset($settings['soundwave_show']) && $settings['soundwave_show']=='yes' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'hide_progressbar="true" ';
		}
		if (isset($settings['progressbar_inline']) && $settings['progressbar_inline']=='yes' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'progressbar_inline="true" ';
		}
		if (isset($settings['store_title_text']) && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'store_title_text="' . $settings['store_title_text'] . '" ';
		}
		if (isset($settings['album_store_position']) && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'album_store_position="' . $settings['album_store_position'] . '" ';
		}
		if ($settings['sr_player_on_artwork']){
			$shortcode .= 'display_control_artwork="true" ';
		}
		if (isset($settings['no_track_skip']) && $settings['no_track_skip']=='yes' && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'notrackskip="true" ';
		}
		
		if (isset($settings['hide_trackdesc']) && $settings['hide_trackdesc'] == '1'){
			$shortcode .= 'hide_trackdesc="'. true .'" ';
		}
		
		if (isset($settings['strip_html_track_desc']) && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'strip_html_track_desc="'. $settings['strip_html_track_desc'] .'" ';
		}
		if (isset($settings['track_desc_lenght']) && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'track_desc_lenght="'. $settings['track_desc_lenght'] .'" ';
		}
		if (isset($settings['show_track_publish_date']) && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'show_track_publish_date="'. $settings['show_track_publish_date'] .'" ';
		}
		if (isset($settings['track_list_linked']) && function_exists( 'run_sonaar_music_pro' )){
			$shortcode .= 'post_link="'. $settings['track_list_linked'] .'" ';
		}
		if ($settings['album_img']){
			//WIP test this.
			$attachImg = wp_get_attachment_image_src( $settings['album_img']['id'], 'large' );
			$album_img = (is_array($attachImg)) ? $attachImg[0] : '';
			$shortcode .= 'artwork="' .  $album_img . '" ';
			update_post_meta( get_the_ID(), 'srmp3_elementor_artwork', $album_img); // update post meta to retrieve data in json later
		}
		if ($settings['play_current_id']=='yes' || $settings['playlist_source']=='from_current_post'){ //If "Play its own Post ID track" option is enable
			$postid = get_the_ID();
			$shortcode .= 'albums="' . $postid . '" ';
		}else{
			$display_playlist_ar = $settings['playlist_list'];
			$display_playlist_cat_ar = (isset($settings['playlist_list_cat'])) ? $settings['playlist_list_cat'] : null;
			if(is_array($display_playlist_ar)){
				$display_playlist_ar = implode(", ", $display_playlist_ar); 
			}
			if(is_array($display_playlist_cat_ar)){
				$display_playlist_cat_ar = implode(", ", $display_playlist_cat_ar); 
			}
			if(!$display_playlist_cat_ar && $settings['playlist_source'] == 'from_cat'){
				$shortcode .= 'category="all" ';
				$shortcode .= (isset($settings['posts_per_page'])) ? 'posts_per_page="' . $settings['posts_per_page'] . '" ' : '';
			}elseif($display_playlist_cat_ar && $settings['playlist_source'] == 'from_cat'){
				$shortcode .= 'category="'. $display_playlist_cat_ar . '" ';
				$shortcode .= (isset($settings['posts_per_page'])) ? 'posts_per_page="' . $settings['posts_per_page'] . '" ' : '';
			}
	
			if (!$display_playlist_ar) { //If no playlist is selected, play the latest playlist
				if($settings['playlist_source'] == 'from_cpt' ){
					$shortcode .= 'play-latest="true" ';
				}
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					if ($settings['playlist_source'] == 'from_elementor'  && !$settings['feed_repeater'] ){
						echo esc_html__('Add tracks in the widget settings.<br>', 'sonaar-music');
					}
				}
			}else{
				$shortcode .= 'albums="' . $display_playlist_ar . '" ';
			}
		
		}
		$shortcode .= ']';
		//Attention: double brackets are required if using var_dump to display a shortcode otherwise it will render it!
		//print_r("Shortcode = [" . $shortcode . "]");
		echo do_shortcode( $shortcode );



	}
	public function render_plain_content() {
		$settings = $this->get_settings_for_display();
		if ( function_exists( 'run_sonaar_music_pro' ) ){
			$sticky_player = $settings['enable_sticky_player'];
			$shuffle = $settings['enable_shuffle'];
			$wave_color = $settings['soundWave_bg_bar_color'];
			$wave_progress_color = $settings['soundWave_progress_bar_color'];
		}else{
			$sticky_player = false;
			$shuffle = false;
			$wave_color = false;
			$wave_progress_color = false;
		}
		
		$shortcode = '[sonaar_audioplayer titletag_soundwave="'. isset($settings['title_html_tag_soundwave']) .'" titletag_playlist="'. isset($settings['title_html_tag_playlist']) .'" store_title_text="' . isset($settings['store_title_text']) .'" hide_artwork="' . isset($playlist_playlist_hide_artwork) .'" show_playlist="' . isset($playlist_show_playlist) .'" reverse_tracklist="' . $settings['reverse_tracklist'] .'" show_track_market="' . isset($playlist_hide_track_market) .'" show_album_market="' . isset($playlist_show_album_market) .'" hide_timeline="' . isset($playlist_show_soundwave) .'" sticky_player="' . isset($sticky_player) .'" wave_color="' . isset($wave_color) .'" wave_progress_color="' . isset($wave_progress_color) .'" shuffle="' . isset($shuffle) .'" show_skip_bt="'. $settings['show_skip_bt'] .'" show_speed_bt="'. $settings['show_speed_bt'] .'" show_volume_bt="'. $settings['show_volume_bt'] .'" show_shuffle_bt="'. $settings['show_shuffle_bt'] .'" ';
		
		if ($settings['play_current_id']=='yes' || $settings['playlist_source']=='from_current_posts'){
			$postid = get_the_ID();
			$shortcode .= 'albums="' . $postid . '" ';
		}else{
			$display_playlist_ar = $settings['playlist_list'];

			if(is_array($display_playlist_ar)){
				$display_playlist_ar = implode(", ", $display_playlist_ar); 
			}
			if (!$display_playlist_ar) { //If no playlist is selected, play the latest playlist
				
				if($settings['playlist_source'] == 'from_cpt' ){
					$shortcode .= 'play-latest="true" ';
				}
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					if ($settings['playlist_source'] == 'from_elementor'  && !$settings['feed_repeater'] ){
						echo esc_html__('Add tracks in the widget settings.<br>', 'sonaar-music');
					}
				}
			}else{
				$shortcode .= 'albums="' . $display_playlist_ar . '" ';
			}
		
		}
		$shortcode .= ']';
		echo do_shortcode( $shortcode );
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new SR_Audio_Player() );