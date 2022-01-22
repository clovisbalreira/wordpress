<?php
/**
* Radio Widget Class
*
* @since 1.6.0
* @todo  - Add options
*/

class Sonaar_Music_Widget extends WP_Widget{
    /**
    * Widget Defaults
    */
    
    public static $widget_defaults;
    
    /**
    * Register widget with WordPress.
    */
    
    function __construct (){
    
        
        $widget_ops = array(
        'classname'   => 'sonaar_music_widget',
        'description' => esc_html_x('A simple radio that plays a list of songs from selected albums.', 'Widget', 'sonaar-music')
        );
        
        self::$widget_defaults = array(
            'title'        => '',
            'store_title_text' => '',
            'albums'     	 => array(),
            'show_playlist' => 0,
            'hide_artwork' => false,
            'sticky_player' => 0,
            'show_album_market' => 0,
            'show_track_market' => 0,
            //'remove_player' => 0, // deprecated and replaced by hide_timeline
            'hide_timeline' =>0,
            
            
            );
            
            if ( isset($_GET['load']) && $_GET['load'] == 'playlist.json' ) {
                $this->print_playlist_json();
        }
        
        parent::__construct('sonaar-music', esc_html_x('Sonaar: Music Player', 'Widget', 'sonaar-music'), $widget_ops);
        
    }
    
    /**
    * Front-end display of widget.
    */
    public function widget ( $args, $instance ){

        
            $instance = wp_parse_args( (array) $instance, self::$widget_defaults );
        
            $elementor_widget = (bool)( isset( $instance['hide_artwork'] ) )? true: false; //Return true if the widget is set in the elementor editor 
            $args['before_title'] = "<span class='heading-t3'></span>".$args['before_title'];
            $args['before_title'] = str_replace('h2','h3',$args['before_title']);
            $args['after_title'] = str_replace('h2','h3',$args['after_title']);
            /*$args['after_title'] = $args['after_title']."<span class='heading-b3'></span>";*/
            //if ( function_exists( 'run_sonaar_music_pro' ) ){
            $feed = ( isset( $instance['feed'] ) )? $instance['feed']: '';
            $feed_title =  ( isset( $instance['feed_title'] ) )? $instance['feed_title']: '';
            $feed_img =  ( isset( $instance['feed_img'] ) )? $instance['feed_img']: '';
            $el_widget_id = ( isset( $instance['el_widget_id'] ) )? $instance['el_widget_id']: '';
            $single_playlist = (is_single() && get_post_type() == SR_PLAYLIST_CPT) ? true : false;
            $playlatestalbum = ( isset( $instance['play-latest'] ) ) ? true : false;
            $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
            $albums = $instance['albums'];
            $terms = ( isset( $instance['category'] ) ) ? $instance['category'] : false;
            $playerWidgetTemplate = ( isset( $instance['player_layout']) && $instance['player_layout'] == 'skin_boxed_tracklist')? 'skin_boxed_tracklist' :'skin_float_tracklist';
            $posts_per_pages = (isset($instance['posts_per_page']) && $instance['posts_per_page'] !== '') ? (int)$instance['posts_per_page'] : -1;

            if( $albums == 'all' ){
                $albums = array();
                $query_args = array(
                    'post_status' => 'publish',
                    'posts_per_page' => (int)$posts_per_pages,
                    'post_type' => SR_PLAYLIST_CPT,
                );
                $i = 0;
                $r = new WP_Query( $query_args );
                if ( $r->have_posts() ){
                  
                    while ( $r->have_posts() ) : $r->the_post();
                        array_push($albums, $r->posts[$i]->ID);
                        $i++;
                    endwhile;
                    $albums = implode(",", $albums);
                    wp_reset_query();
                }else{
                    echo '<div>' . esc_html__("No Playlist Post found ", 'sonaar-music') . '</div>';
                    return;
                }
            }
            if (isset($terms) && $terms !=='' && $terms != false){
                $albums = array();
                
                $first_post_ids = get_posts( array(
                    'fields'         => 'ids', // only return post ID´s
                    'posts_per_page' => '-1',
                    'post_type'      => SR_PLAYLIST_CPT,
                ));
                $second_post_ids = get_posts( array(
                    'fields'         => 'ids', // only return post ID´s
                    'posts_per_page' => '-1',
                    'post_type'      => array('product'),
                ));
                $merged_post_ids = array_merge( $first_post_ids, $second_post_ids);

                $query_args = array(
                    'post_status' => 'publish',
                    'posts_per_page' => $posts_per_pages,
                    'post_type' => 'any', // any post type
                    'post__in'  => $merged_post_ids, // our merged queries
                );
                if( $this->getOptionValue('reverse_tracklist', $instance) ){
                    $query_args['order'] = 'ASC';
                }
                if($terms != 'all'){
                    $terms = explode(", ", $terms); 
                    $query_args += [
                        'tax_query' => array(
                            'relation' => 'OR',
                            array(
                            'taxonomy' => 'playlist-category',
                            'field'    => 'id',
                            'terms'    => $terms
                            ),
                            array(
                            'taxonomy' => 'podcast-show',
                            'field'    => 'id',
                            'terms'    => $terms
                            ),
                            array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'id',
                            'terms'    => $terms
                            ),
                    )];
                }

                $i = 0;
                $r = new WP_Query( $query_args );
                if ( $r->have_posts() ){
                  
                    while ( $r->have_posts() ) : $r->the_post();
                        array_push($albums, $r->posts[$i]->ID);
                        $i++;
                    endwhile;
                    $albums = implode(",", $albums);
                    wp_reset_query();
                }else{
                    echo '<div>' . esc_html__("Oops! No post found.", 'sonaar-music') . '</div>';
                    return;
                }
            }
            
            
            if($playlatestalbum && $terms == false){
                $recent_posts = wp_get_recent_posts(array('post_type'=>SR_PLAYLIST_CPT, 'post_status' => 'publish', 'numberposts' => 1));
                if (!empty($recent_posts)){
                    $albums = $recent_posts[0]["ID"];
                }
            }
            
            if( empty($albums) ) {
                // SHORTCODE IS DISPLAYED BUT NO ALBUMS ID ARE SET. EITHER GET INFO FROM CURRENT POST OR RETURN NO PLAYLIST SELECTED
                $trackSet = '';
                $albums = get_the_ID();
                $album_tracks =  get_post_meta( $albums, 'alb_tracklist', true);

                if (is_array($album_tracks)){
                    $fileOrStream =  $album_tracks[0]['FileOrStream'];
                       
                    switch ($fileOrStream) {
                        case 'mp3':
                            if ( isset( $album_tracks[0]["track_mp3"] ) ) {
                                $trackSet = true;
                            }
                            break;

                        case 'stream':
                            if ( isset( $album_tracks[0]["stream_link"] ) ) {
                                $trackSet = true;
                            }
                            break;
                    }
                }                
                if (isset($feed) && strlen($feed) > 1 ){
                     $trackSet = true;

                }
                if ( ($album_tracks == 0 || !$trackSet) && (!isset($feed) && strlen($feed) < 1 )){
                    echo esc_html__("No playlist selected", 'sonaar-music');
                    return;
                }
                if (!$feed && !$trackSet){
                    return;
                }
            }
            $scrollbar = ( isset( $instance['scrollbar'] ) )? $instance['scrollbar']: false;
            $show_album_market = (bool) ( isset( $instance['show_album_market'] ) )? $instance['show_album_market']: 0;
            $show_track_market = (bool) ( isset( $instance['show_track_market'] ) )? $instance['show_track_market']: 0;
            $store_title_text = $instance['store_title_text'];
            $hide_artwork = (bool)( isset( $instance['hide_artwork'] ) )? $instance['hide_artwork']: false;
            $displayControlArtwork = (bool)( isset( $instance['display_control_artwork'] ) )? $instance['display_control_artwork']: false;
            $hide_control_under = (bool)( isset( $instance['hide_control_under'] ) )? $instance['hide_control_under']: false;
            $hide_track_title = (bool)( isset( $instance['hide_track_title'] ) )? $instance['hide_track_title']: false;
            $hide_player_title = (bool)( isset( $instance['hide_player_title'] ) )? $instance['hide_player_title']: false;
            $hide_times = (bool)( isset( $instance['hide_times'] ) )? $instance['hide_times']: false;
            $artwork= (bool)( isset( $instance['artwork'] ) )? $instance['artwork']: false;
            $track_artwork = (bool)( isset( $instance['track_artwork'] ) )? $instance['track_artwork']: false;
            $remove_player = (bool) ( isset( $instance['remove_player'] ) )? $instance['remove_player']: false; // deprecated and replaced by hide_timeline. keep it for fallbacks
            $hide_timeline = (bool) ( isset( $instance['hide_timeline'] ) )? $instance['hide_timeline']: false;
            $notrackskip = (bool) ( isset( $instance['notrackskip'] ) )? $instance['notrackskip']: false;
            $progressbar_inline = (bool) ( isset( $instance['progressbar_inline'] ) )? $instance['progressbar_inline']: false;
            $sticky_player = (bool)( isset( $instance['sticky_player'] ) )? $instance['sticky_player']: false;
            $shuffle = (bool)( isset( $instance['shuffle'] ) )? $instance['shuffle']: false;
            $wave_color = (bool)( isset( $instance['wave_color'] ) )? $instance['wave_color']: false;
            $wave_progress_color = (bool)( isset( $instance['wave_progress_color'] ) )? $instance['wave_progress_color']: false;
            $show_playlist = (bool)( isset( $instance['show_playlist'] ) )? $instance['show_playlist']: false;
            $title_html_tag_playlist = ( isset( $instance['titletag_playlist'] ) )? $instance['titletag_playlist']: 'h3';
            $title_html_tag_soundwave = ( isset( $instance['titletag_soundwave'] ) )? $instance['titletag_soundwave']: 'div';
            $track_title_html_tag_soundwave = ( isset( $instance['track_titletag_soundwave'] ) && $instance['track_titletag_soundwave'] != '' )? $instance['track_titletag_soundwave']: $title_html_tag_soundwave;
            $title_html_tag_playlist = ($title_html_tag_playlist == '') ? 'div' : $title_html_tag_playlist;
            $hide_album_title = (bool)( isset( $instance['hide_album_title'] ) )? $instance['hide_album_title']: false;
            $hide_album_subtitle = (bool)( isset( $instance['hide_album_subtitle'] ) )? $instance['hide_album_subtitle']: false;
            $playlist_title = ( isset( $instance['playlist_title'] ) )? $instance['playlist_title']: false;   
            $hide_trackdesc = ( isset( $instance['hide_trackdesc'] ) &&  $instance['hide_trackdesc'] == true ) ? true : false;   
            $track_desc_lenght = ( isset( $instance['track_desc_lenght'] ) )? $instance['track_desc_lenght']: 55;
            $strip_html_track_desc = ( isset( $instance['strip_html_track_desc'] ) )? $instance['strip_html_track_desc']: true;
            $albumStorePosition = ( isset( $instance['album_store_position'] ) ) ? $instance['album_store_position'] : '' ;
            $showPublishDate = ( $this->getOptionValue('show_publish_date', $instance) && !$feed)? true : false;
            $dateFormat = (Sonaar_Music::get_option('player_date_format', 'srmp3_settings_widget_player') && Sonaar_Music::get_option('player_date_format', 'srmp3_settings_widget_player') != '' ) ? Sonaar_Music::get_option('player_date_format', 'srmp3_settings_widget_player') : '';
            if(!function_exists( 'run_sonaar_music_pro' )){
                $hide_trackdesc = true;
            }else{
                $notrackskip = apply_filters( 'srp_track_skip_attribute', $notrackskip);
            }
            if( is_single() && 
            ((function_exists('is_product') && !is_product()) || !function_exists('is_product')) ||
            is_archive()){
                $hide_progressbar = filter_var(Sonaar_Music::get_option('player_hide_progressbar', 'srmp3_settings_widget_player'), FILTER_VALIDATE_BOOLEAN);
            }else{
                $hide_progressbar = filter_var(( isset( $instance['hide_progressbar'] ) )? $instance['hide_progressbar']: false, FILTER_VALIDATE_BOOLEAN);
            }
            
            //Field validation
            $sr_html_allowed_tags = array('h1', 'h2', 'h3', 'h4','h5','h6','div','span', 'p');
            if (!in_array($title_html_tag_playlist, $sr_html_allowed_tags, true)) {
                $title_html_tag_playlist = 'h3';
            }
            if (!in_array($title_html_tag_soundwave, $sr_html_allowed_tags, true)) {
                $title_html_tag_soundwave = 'div';
            }
            if (!in_array($track_title_html_tag_soundwave, $sr_html_allowed_tags, true)) {
                $track_title_html_tag_soundwave = 'div';
            }
      
            if($sticky_player){
                if ( function_exists( 'run_sonaar_music_pro' )){
                    $sticky_player = ($instance['sticky_player']=="true" || $instance['sticky_player']==1) ? : false;
                }else{
                    $sticky_player = false;
                }
            }
            if($show_playlist){
                $show_playlist = ($instance['show_playlist']=="true" || $instance['show_playlist']==1) ? : false;      
            }
            if($hide_track_title){
                $hide_track_title = ($instance['hide_track_title']=="true" || $instance['hide_track_title']==1) ? : false;      
            }
            if($show_track_market){
                $show_track_market = ($instance['show_track_market']=="true" || $instance['show_track_market']==1) ? : false;      
            }
            if($show_album_market){
                $show_album_market = ($instance['show_album_market']=="true" || $instance['show_album_market']==1) ? : false;      
            }
            if($hide_artwork){
                $hide_artwork = ($instance['hide_artwork']=="true" || $instance['hide_artwork']==1) ? : false;      
            }
            if($track_artwork){
                if ( function_exists( 'run_sonaar_music_pro' )){
                    $track_artwork = ($instance['track_artwork']=="true" || $instance['track_artwork']==1) ? : false;      
                }else{
                    $track_artwork = false;
                }
            }
            if($displayControlArtwork){
                $displayControlArtwork = ($instance['display_control_artwork']=="true" || $instance['display_control_artwork']==1) ? : false;      
            }
            if($hide_control_under){
                $hide_control_under = ($instance['hide_control_under']=="true") ? true : false;      
            }
            if($hide_player_title){
                $hide_player_title = ($instance['hide_player_title']=="true") ? true : false;      
            }
            if($hide_album_title){
                $hide_album_title = ($instance['hide_album_title']=="true") ? true : false;      
            }
            if($hide_album_subtitle){
                $hide_album_subtitle = ($instance['hide_album_subtitle']=="true") ? true : false;      
            }
            if($progressbar_inline){
                $progressbar_inline = ($instance['progressbar_inline']=="true" || $instance['progressbar_inline']==1) ? true : false;      
            }
            if($hide_times){
                $hide_times = ($instance['hide_times']=="true" || $instance['hide_times']==1) ? true : false;      
            }
            if($notrackskip && isset($instance['notrackskip'])){
                $notrackskip = ($instance['notrackskip']=="true" || $instance['notrackskip']==1) ? 'on' : false;      
            }
            if($remove_player){
                $remove_player = ($instance['remove_player']=="true" || $instance['remove_player']==1) ? true : false;      
            }

            if($hide_timeline){
                $hide_timeline = ($instance['hide_timeline']=="true" || $instance['hide_timeline']==1) ? true : false;      
            }

            $store_buttons = array();
            $all_category = (isset($instance['category']) && $instance['category']=='all') ? true : false;
           
            $playlist = $this->get_playlist($albums, $title, $feed_title, $feed, $feed_img, $el_widget_id, $artwork, $posts_per_pages, $all_category, $single_playlist, $this->getOptionValue('reverse_tracklist', $instance) );

            if (isset($playlist['tracks'][0]['poster']) =="" || !$playlist['tracks'][0]['poster'] && !$artwork ){
                $hide_artwork = true;
            }

            if ( isset($playlist['tracks']) && ! empty($playlist['tracks']) )
                $player_message = esc_html_x('Loading tracks...', 'Widget', 'sonaar-music');
            else
                $player_message = esc_html_x('No tracks founds...', 'Widget', 'sonaar-music');
            
            /***/
            
            if ( ! $playlist )
                return;
            
            if($show_playlist) {
                $args['before_widget'] = str_replace("iron_widget_radio", "iron_widget_radio playlist_enabled", $args['before_widget']);
            }
        
		/* Enqueue Sonaar Music related CSS and Js file */
		wp_enqueue_style( 'sonaar-music' );
		wp_enqueue_style( 'sonaar-music-pro' );
		wp_enqueue_script( 'sonaar-music-mp3player' );
		wp_enqueue_script( 'sonaar-music-pro-mp3player' );
		wp_enqueue_script( 'sonaar_player' );
		if ( function_exists('sonaar_player') ) {
			add_action('wp_footer','sonaar_player', 12);
		}

        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
		
		if ( is_array($albums)) {
			$albums = implode(',', $albums);
		}
        if ( FALSE === get_post_status( $albums ) || get_post_status ( $albums ) == 'trash') {
            echo esc_html__('No playlist selected. Please select a playlist', 'sonaar-music');
            return;
        }
    
        $firstAlbum = explode(',', $albums);
        $firstAlbum = $firstAlbum[0];
        
        $ironAudioClass = '';
        $ironAudioClass .= ( $show_playlist ) ? ' show-playlist' :'';
        $ironAudioClass .= ( $hide_artwork == "true" ) ? ' sonaar-no-artwork' :'';
        $ironAudioClass .= ' sr_waveform_' . Sonaar_Music::get_option('waveformType', 'srmp3_settings_general');
        $ironAudioClass .= ($displayControlArtwork) ? ' sr_player_on_artwork' : '';
        $ironAudioClass .= ( $remove_player || $hide_timeline )? ' srp_hide_player': '' ;

        $album_ids_with_show_market = ( $show_album_market )? $albums : 0 ;
        
        $format_playlist ='';

        if(Sonaar_Music::get_option('show_artist_name', 'srmp3_settings_general') ){
            $artistSeparator = (Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general') && Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general') != '' && Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general') != 'by')?Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general'):  esc_html__('by', 'sonaar-music');
            $artistSeparator = ' ' . $artistSeparator . ' ';
        }else{
            $artistSeparator = '';
        }
        $storeButtonPosition = [];//$storeButtonPosition[ {track index} , {store index} ] , so $storeButtonPosition[ 0, 1 ] refers to the second(1) store button from the first(0) track
        $trackIndexRelatedToItsPost = 0; //variable required to set the data-store-id. Data-store-id is used to popup the right content.
        $currentTrackId = ''; //Used to set the $trackIndexRelatedToItsPost
        $trackNumber = 0; // Dont Count Relataded track
        $trackCountFromPlaylist = 0; //Count tracks from same playlist
        $playlistID = '';
        $excerptTrimmed = '[...]';

        foreach( $playlist['tracks'] as $key1 => $track){
            $allAlbums = explode(', ', $albums);

            if( $playlistID == $track['sourcePostID'] ){
                $trackCountFromPlaylist++;
            }else{
                $playlistID = $track['sourcePostID'];
                $trackCountFromPlaylist = 0;
            }

            $relatedTrack = ( Sonaar_Music::get_option('sticky_show_related-post', 'srmp3_settings_sticky_player') != 'true' || $terms || in_array($track['sourcePostID'], $allAlbums) || $feed || $instance['albums'] == 'all' || !$single_playlist)? false : true; //True when the track is related to the selected playlist post as episode podcast from same category           
            $storeButtonPosition[$key1] = [];
            $trackdescEscapedValue = null;
            $trackUrl = $track['mp3'] ;
            $showLoading = $track['loading'] ;
            $song_store_list = '<span class="store-list">';
            if($currentTrackId != $track['sourcePostID']){ //Reset $trackIndexRelatedToItsPost counting. It is incremented at the end of the foreach.
                $currentTrackId = $track['sourcePostID'];
                $trackIndexRelatedToItsPost = 0; 
            }
            if(isset($track['album_store_list'][0])){
                $track['song_store_list'] = ( isset($track['song_store_list'][0]) ) ? array_merge($track['song_store_list'], $track['album_store_list']) : $track['album_store_list'];
                $track['has_song_store'] = true;
            }
            if ( $show_track_market && is_array($track['song_store_list']) ){
 
                if ($track['has_song_store']){
                    $song_store_list .= '<div class="song-store-list-menu"><i class="fas fa-ellipsis-v"></i><div class="song-store-list-container">';
                    
                    foreach( $track['song_store_list'] as $key2 => $store ){
                        $storeButtonPosition[$key1][$key2]=[];
                        if(isset($store['link-option']) && $store['link-option'] == 'popup'){
                            if( array_key_exists('store-content', $store) ){
                                array_push ($storeButtonPosition[$key1][$key2], $store['store-content']);
                            }
                        }
                        if(isset($store['store-icon'])){
                            $classes = 'song-store';
                            if(!isset($store['store-name'])){
                                $store['store-name']='';
                            }
                            
                            if(!isset($store['store-link'])){
                                $store['store-link']='#';
                            }
                            $href = 'href="' . esc_url($store['store-link']) . '"';
                            $download="";
                            $label = '';
                            if($store['store-icon'] == "fas fa-download"){
                                $download = ' download';
                            }
                            if(!isset($store['store-icon'])){
                                $store['store-icon']='';
                            }

                            if(!isset($store['store-target'])){
                                $store['store-target']='_blank';
                            }
                            

                            if(isset($store['link-option']) && $store['link-option'] == 'popup'){ //if Popup content
                               $classes .= ' sr-store-popup';
                               $store['store-target'] = '_self';
                               $href = '';
                            }
                            if( function_exists( 'run_sonaar_music_pro' ) ){ 
                                if( isset($store['show-label']) || Sonaar_Music::get_option('show_label', 'srmp3_settings_widget_player') == 'true' ){
                                    if ( (isset($store['show-label']) && $store['show-label'] == 'true' || (isset($store['show-label'])) && $store['show-label'] == '' && Sonaar_Music::get_option('show_label', 'srmp3_settings_widget_player') == 'true') || ( !isset($store['show-label']) ) && Sonaar_Music::get_option('show_label', 'srmp3_settings_widget_player') == 'true'){
                                        $classes .= ' sr_store_wc_round_bt';
                                        $label = $store['store-name'];
                                    }
                                }
                            }
                              
                            if(get_post_meta( $currentTrackId, 'reverse_post_tracklist', true)){
                                $countTrackFromSamePlaylist = array_count_values( array_column($playlist['tracks'], 'sourcePostID') )[$currentTrackId];
                                $trackIndex =  $countTrackFromSamePlaylist - 1 - $trackIndexRelatedToItsPost;
                            }else{
                                $trackIndex =  $trackIndexRelatedToItsPost;
                            }

                            $song_store_list .= '<a ' . $href .  esc_html($download) . ' class="' . esc_attr($classes) . '" target="' .  esc_attr($store['store-target']) . '" title="' . esc_attr($store['store-name']) . '" data-source-post-id="' . esc_attr($track['sourcePostID']) . '" data-store-id="' . esc_attr($trackIndex . '-' . $key2) . '" tabindex="1"><i class="' . esc_html($store['store-icon']) . '"></i>' . esc_attr($label) . '</a>';
                        }
                    }
                    $song_store_list .= '</div></div>';
                }
            }
            $song_store_list .= '</span>';
           
            if (!$hide_trackdesc && isset($track['description']) && $track['description'] !==false) {
                $trackdesc_allowed_html = [
                    'a'      => [
                        'href'  => [],
                        'title' => [],
                    ],
                    'br'     => [],
                    'em'     => [],
                    'strong' => [],
                    'b' => [],
                    'p' => [],
                ];
                if( $strip_html_track_desc ){
                        $trackdescEscapedValue =  force_balance_tags( wp_trim_words( strip_shortcodes( $track['description'] ) , esc_attr($track_desc_lenght), $excerptTrimmed )) ;
                }else{
                        $trackdescEscapedValue =  force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( strip_shortcodes( $track['description']   )), esc_attr($track_desc_lenght), $excerptTrimmed ) ));
                }
            }

            $playlistTrackDesc = (isset($trackdescEscapedValue)) ? '</div><div class="srp_track_description">'. wp_kses( $trackdescEscapedValue, $trackdesc_allowed_html ) .'</div>' : '</div>';
            $store_buttons = ( !empty($track["track_store"]) ) ? '<a class="button" target="_blank" href="'. esc_url( $track['track_store'] ) .'">'. esc_textarea( $track['track_buy_label'] ).'</a>' : '' ;
            $artistSeparator_string = ($track['track_artist']) ? $artistSeparator : '';//remove separator if no track doesnt have artist
            $track_image_url = (($track_artwork && isset($track['track_image_id'])) && ($track['track_image_id'] != 0)) ? wp_get_attachment_image_src($track['track_image_id'], 'thumbnail', true)[0] : $track['poster'] ;
            $track_artwork_value = ($track_artwork && $track_image_url) ? '<img src=' . esc_url( $track_image_url ) . ' class="sr_track_cover" />' : '';
            $track_date = (isset($track['sourcePostID']) ) ? get_the_date( $dateFormat, $track['sourcePostID'] ) : false;
            $trackLinkedToPost = ( isset( $track['sourcePostID'] ) && $this->getOptionValue('post_link', $instance) ) ? get_permalink($track['sourcePostID']) : false;
            $trackTitle = esc_html($track['track_title']) . esc_html($artistSeparator_string) . esc_html($track['track_artist']);
            $noteButton =  $this->addNoteButton($track['sourcePostID'], $trackCountFromPlaylist, $trackTitle, $trackdescEscapedValue, $excerptTrimmed );
            $playlistItemClass = (isset($trackdescEscapedValue) || $noteButton != null ) ? 'sr-playlist-item' : 'sr-playlist-item sr-playlist-item-flex';

            $format_playlist .= '<li 
            class="'. esc_attr($playlistItemClass) .'" 
            data-audiopath="' . esc_url( $trackUrl ) . '"
            data-showloading="' . esc_html($showLoading) .'"
            data-albumTitle="' . esc_attr( $track['album_title'] ) . '"
            data-albumArt="' . esc_url( $track['poster'] ) . '"
            data-releasedate="' . esc_attr( $track['release_date'] ) . '"
            data-date="' . esc_attr( $track_date ) . '"
            data-show-date="' . esc_attr($this->getOptionValue('show_track_publish_date', $instance)) . '"
            data-trackTitle="' . esc_html($trackTitle) . '"
            data-trackID="' . esc_html($track['id']) . '"
            data-trackTime="' . esc_html($track['lenght']) . '"
            data-relatedTrack="'. esc_html($relatedTrack) . '"
            data-post-url="'. esc_html($trackLinkedToPost) . '"
            >';
            $format_playlist .= ( isset($trackdescEscapedValue) || $noteButton != null ) ? '<div class="sr-playlist-item-flex">' : '';
            $format_playlist .= $track_artwork_value . $song_store_list;
            $format_playlist .= ($noteButton != null)? $noteButton : '';
            $format_playlist .= (isset($trackdescEscapedValue)) ? $playlistTrackDesc : '';
            $format_playlist .= '</li>';

            if(!$relatedTrack){
                $trackNumber++; //Count visible track in the tracklist (All related tracks are hidden)
            }
            $trackIndexRelatedToItsPost++;//$trackIndexRelatedToItsPost is required to set the data-store-id. Data-store-id is used to popup the right content.
        }

        $labelPlayTxt = (Sonaar_Music::get_option('labelPlayTxt', 'srmp3_settings_widget_player')) ? Sonaar_Music::get_option('labelPlayTxt', 'srmp3_settings_widget_player') : 'Play';
        $labelPauseTxt = (Sonaar_Music::get_option('labelPauseTxt', 'srmp3_settings_widget_player')) ? Sonaar_Music::get_option('labelPauseTxt', 'srmp3_settings_widget_player') : 'Pause';
        
        if( Sonaar_Music::get_option('waveformType', 'srmp3_settings_general') === 'wavesurfer' ) {
            $fakeWave = '';
        }else{
            $barHeight =(Sonaar_Music::get_option('sr_soundwave_height', 'srmp3_settings_general')) ? Sonaar_Music::get_option('sr_soundwave_height', 'srmp3_settings_general') : 70;
            $mediaElementStyle = (Sonaar_Music::get_option('waveformType', 'srmp3_settings_general') === 'mediaElement') ? 'style="height:'.esc_attr($barHeight).'px"' : '';
            $fakeWave = '
            <div class="sonaar_fake_wave" '.$mediaElementStyle.'>
                <audio src="" class="sonaar_media_element"></audio>
                <div class="sonaar_wave_base">
                    <canvas id=' . esc_attr($args["widget_id"]) . '-container' . ' class="" height="'.esc_attr($barHeight).'" width="2540"></canvas>
                    <svg></svg>
                </div>
                <div class="sonaar_wave_cut">
                    <canvas id=' . esc_attr($args["widget_id"]) . '-progress' . ' class="" height="'.esc_attr($barHeight).'" width="2540"></canvas>
                    <svg></svg>
                </div>
            </div>';
        }
        $feedurl = ($feed) ? '1' : '0';

        $hide_times_current = (!$hide_times) ? '
            <div class="currentTime"></div>
        ' : '' ;
        $hide_times_total = (!$hide_times) ? '
            <div class="totalTime"></div>
        ' : '' ;

        $wave_margin = ($hide_times) ? 'style="margin-left:0px;margin-right:0px;"': ''; // remove margin needed for the current/total time

        $progressbar = '';
        $player_style = ($hide_progressbar && $playerWidgetTemplate == 'skin_float_tracklist') ? 'style="height:33px;"': '';
        if (!$hide_progressbar){
            $progressbar = '
                ' . $hide_times_current . ' 
                <div id="'.esc_attr($args["widget_id"]). '-' . bin2hex(random_bytes(5)) . '-wave" class="wave" ' . esc_attr($wave_margin) . '>
                ' . $fakeWave . ' 
                </div>
                ' . $hide_times_total . ' 
            ';
         }else{
             // hide the progress bar
             $progressbar = '
                <div id="'.esc_attr($args["widget_id"]). '-' . bin2hex(random_bytes(5)) . '-wave" class="wave" style="display:none;">
                ' . $fakeWave . '
                </div>
                
            ';
         }
        
         if(
            $playerWidgetTemplate == 'skin_float_tracklist' &&
            !$this->getOptionValue('show_shuffle_bt', $instance) &&
            !$this->getOptionValue('show_speed_bt', $instance) &&
            !$this->getOptionValue('show_volume_bt', $instance)
         ){ 
             $main_control_xtraClass = ' srp_oneColumn';
        }else{
            $main_control_xtraClass = '';
        }
        $widgetPart_control = ($playerWidgetTemplate == 'skin_float_tracklist' || $trackNumber == 1 )?'<div class="srp_main_control'. $main_control_xtraClass .'">':'';
        $widgetPart_control .= '<div class="control">';
        if ( $this->getOptionValue('show_skip_bt', $instance) ){
            $widgetPart_control .=
            '<div class="sr_skipBackward">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  width="26" height="26" x="0px" y="0px"
                viewBox="0 0 350 350" style="enable-background:new 0 0 350 350;" xml:space="preserve">
            <path class="st0" d="M92.99,53.26c50.47-37.73,117.73-40.35,170.62-7.61l-21.94,16.61c0,0,0,0,0,0c0,0,0,0,0,0l0,0c0,0,0,0,0,0
                c-3.86,2.92-6.03,7.4-6.03,12.07c0,1.29,0.16,2.59,0.5,3.88c1.43,5.43,5.72,9.49,11.52,10.94c0,0,0,0,0,0l61.38,17.66c0,0,0,0,0,0
                c0,0,0,0,0,0l0,0c0,0,0,0,0,0c4.15,1.19,8.7,0.37,12.16-2.22c3.47-2.59,5.56-6.71,5.59-11.04c0,0,0,0,0-0.01c0,0,0,0,0-0.01
                l0.42-65.18c0-0.02,0-0.03,0-0.05c0-0.02,0-0.04,0-0.06c0.02-6-2.71-10.99-7.54-13.69c-5.23-2.93-11.7-2.48-16.5,1.14c0,0,0,0,0,0
                c0,0,0,0,0,0l-26.11,19.76c-13.29-8.89-27.71-15.81-42.95-20.6C217.39,9.61,200,7.02,182.44,7.18c-17.56,0.15-34.91,3.04-51.54,8.58
                c-17.03,5.67-32.98,14.01-47.41,24.8c-2.08,1.56-3.18,3.94-3.18,6.36c0,1.65,0.51,3.32,1.58,4.74
                C84.51,55.16,89.48,55.88,92.99,53.26z M310.96,90.86l-58.55-16.84l29.03-21.97c0.45-0.27,0.87-0.59,1.27-0.96l28.65-21.68
                L310.96,90.86z"/>
            <path class="st0" d="M36.26,139.69l1.6-6.62l3.4-10.4l3.99-10.18l4.75-9.7l5.57-9.36l6.18-8.97l6.77-8.37l7.58-8.2
                c2.97-3.22,2.78-8.23-0.44-11.21c-3.22-2.97-8.23-2.78-11.21,0.44l-7.76,8.39c-0.12,0.13-0.23,0.26-0.34,0.4l-7.13,8.81
                c-0.13,0.16-0.25,0.32-0.37,0.49l-6.5,9.44c-0.1,0.14-0.19,0.29-0.28,0.44l-5.87,9.86c-0.11,0.19-0.21,0.38-0.31,0.57l-5.03,10.28
                c-0.09,0.19-0.18,0.39-0.26,0.59l-4.2,10.7c-0.06,0.14-0.11,0.29-0.15,0.43l-3.57,10.91c-0.06,0.2-0.12,0.4-0.17,0.6l-1.68,6.92
                c-0.15,0.63-0.23,1.26-0.23,1.87c0,3.58,2.44,6.82,6.07,7.7C30.94,146.56,35.23,143.94,36.26,139.69z"/>
            <path class="st0" d="M70.09,275.38l-7.14-8.56l-6.14-8.72l-5.59-9.38l-4.99-9.79l-4.2-10l-3.59-10.18l-2.78-10.52l-1.99-10.75
                l-1.19-10.75l-0.4-10.78l0.2-7.72c0.12-4.37-3.34-8.02-7.72-8.14c-4.38-0.12-8.02,3.34-8.14,7.72l-0.21,7.97c0,0.07,0,0.14,0,0.21
                c0,0.1,0,0.2,0.01,0.29l0.42,11.33c0.01,0.19,0.02,0.39,0.04,0.58l1.26,11.33c0.02,0.19,0.05,0.38,0.08,0.57l2.1,11.33
                c0.04,0.2,0.08,0.39,0.13,0.58l2.94,11.12c0.05,0.21,0.12,0.41,0.19,0.61l3.78,10.7c0.05,0.15,0.11,0.29,0.17,0.43l4.4,10.49
                c0.08,0.18,0.16,0.36,0.25,0.53l5.24,10.28c0.08,0.15,0.16,0.31,0.25,0.45l5.87,9.86c0.1,0.17,0.21,0.34,0.33,0.51l6.5,9.23
                c0.12,0.18,0.25,0.35,0.39,0.51l7.34,8.81c2.8,3.37,7.81,3.82,11.17,1.02C72.44,283.75,72.9,278.75,70.09,275.38z"/>
            <path class="st0" d="M185.89,342.5l11.54-0.63c0.15-0.01,0.3-0.02,0.44-0.04l3.78-0.42c4.35-0.48,7.49-4.41,7.01-8.76
                c-0.48-4.35-4.41-7.49-8.76-7.01l-3.55,0.39l-10.95,0.6l-10.75-0.4l-10.82-1l-10.75-1.79l-10.6-2.6l-10.31-3.17l-9.91-4.16
                l-9.84-4.82l-9.39-5.39l-9.17-6.18l-2.71-2.13c-3.44-2.71-8.43-2.11-11.14,1.34c-1.14,1.45-1.7,3.18-1.7,4.9
                c0,2.35,1.04,4.68,3.03,6.24l2.94,2.31c0.15,0.12,0.31,0.23,0.47,0.34l9.65,6.5c0.16,0.11,0.32,0.21,0.48,0.3l9.86,5.66
                c0.15,0.09,0.31,0.17,0.46,0.25l10.28,5.03c0.14,0.07,0.28,0.13,0.42,0.19l10.49,4.41c0.24,0.1,0.49,0.19,0.74,0.27l10.91,3.36
                c0.15,0.05,0.29,0.09,0.44,0.12l11.12,2.73c0.19,0.05,0.39,0.09,0.59,0.12l11.33,1.89c0.19,0.03,0.38,0.06,0.57,0.07l11.33,1.05
                c0.15,0.01,0.29,0.02,0.44,0.03l11.33,0.42C185.41,342.52,185.65,342.52,185.89,342.5z"/>
            <path class="st0" d="M316.46,248.51l-3.87,6.52l-6.21,9.22l-6.58,8.37l-7.37,8.17l-7.77,7.37l-8.38,6.98l-8.96,6.37l-9.18,5.59
                l-9.58,4.99l-10.14,4.38l-10.19,3.46c-3.3,1.12-5.38,4.21-5.38,7.51c0,0.85,0.14,1.71,0.42,2.55c1.41,4.15,5.92,6.37,10.06,4.96
                l10.49-3.57c0.2-0.07,0.4-0.14,0.59-0.23l10.7-4.62c0.18-0.08,0.35-0.16,0.52-0.25l10.07-5.24c0.16-0.08,0.31-0.17,0.46-0.26
                l9.65-5.87c0.16-0.1,0.32-0.2,0.47-0.31l9.44-6.71c0.17-0.12,0.33-0.24,0.48-0.37l8.81-7.34c0.13-0.11,0.26-0.22,0.38-0.34
                l8.18-7.76c0.15-0.14,0.29-0.29,0.43-0.44l7.76-8.6c0.12-0.13,0.24-0.27,0.35-0.41l6.92-8.81c0.12-0.15,0.23-0.31,0.34-0.47
                l6.5-9.65c0.08-0.13,0.17-0.25,0.24-0.38l3.99-6.71c2.24-3.77,1-8.63-2.77-10.87C323.56,243.51,318.69,244.75,316.46,248.51z"/>
            </svg>
            <div class="sr_skip_number">15</div>
            </div>';
        }
        $prev_play_next_Controls = '';
        if(count($playlist['tracks']) > 1 ){
            $prev_play_next_Controls .= 
            '<div class="previous" style="opacity:0;">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="18.33" x="0px" y="0px" viewBox="0 0 10.2 11.7" style="enable-background:new 0 0 10.2 11.7;" xml:space="preserve">
                    <polygon points="10.2,0 1.4,5.3 1.4,0 0,0 0,11.7 1.4,11.7 1.4,6.2 10.2,11.7"/>
                </svg>
            </div>';
        }
            $prev_play_next_Controls .=
            '<div class="play" style="opacity:0;">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="31.47" x="0px" y="0px" viewBox="0 0 17.5 21.2" style="enable-background:new 0 0 17.5 21.2;" xml:space="preserve">
                    <path d="M0,0l17.5,10.9L0,21.2V0z"/>
                    <rect width="6" height="21.2"/>
                    <rect x="11.5" width="6" height="21.2"/>
                </svg>
            </div>';
        if(count($playlist['tracks']) > 1 ){
            $prev_play_next_Controls .=
            '<div class="next" style="opacity:0;">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="18.33" x="0px" y="0px" viewBox="0 0 10.2 11.7" style="enable-background:new 0 0 10.2 11.7;" xml:space="preserve">
                    <polygon points="0,11.7 8.8,6.4 8.8,11.7 10.2,11.7 10.2,0 8.8,0 8.8,5.6 0,0"/>
                </svg>
            </div>';
        };
        $widgetPart_control .= $prev_play_next_Controls;
       
        if ( $this->getOptionValue('show_skip_bt', $instance) ){
                $widgetPart_control .= 
                '<div class="sr_skipForward">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  width="26" height="26" x="0px" y="0px"
                viewBox="0 0 350 350" style="enable-background:new 0 0 350 350;" xml:space="preserve">
                <path class="st0" d="M92.99,53.26c50.47-37.73,117.73-40.35,170.62-7.61l-21.94,16.61c0,0,0,0,0,0c0,0,0,0,0,0l0,0c0,0,0,0,0,0
                c-3.86,2.92-6.03,7.4-6.03,12.07c0,1.29,0.16,2.59,0.5,3.88c1.43,5.43,5.72,9.49,11.52,10.94c0,0,0,0,0,0l61.38,17.66c0,0,0,0,0,0
                c0,0,0,0,0,0l0,0c0,0,0,0,0,0c4.15,1.19,8.7,0.37,12.16-2.22c3.47-2.59,5.56-6.71,5.59-11.04c0,0,0,0,0-0.01c0,0,0,0,0-0.01
                l0.42-65.18c0-0.02,0-0.03,0-0.05c0-0.02,0-0.04,0-0.06c0.02-6-2.71-10.99-7.54-13.69c-5.23-2.93-11.7-2.48-16.5,1.14c0,0,0,0,0,0
                c0,0,0,0,0,0l-26.11,19.76c-13.29-8.89-27.71-15.81-42.95-20.6C217.39,9.61,200,7.02,182.44,7.18c-17.56,0.15-34.91,3.04-51.54,8.58
                c-17.03,5.67-32.98,14.01-47.41,24.8c-2.08,1.56-3.18,3.94-3.18,6.36c0,1.65,0.51,3.32,1.58,4.74
                C84.51,55.16,89.48,55.88,92.99,53.26z M310.96,90.86l-58.55-16.84l29.03-21.97c0.45-0.27,0.87-0.59,1.27-0.96l28.65-21.68
                L310.96,90.86z"/>
                <path class="st0" d="M36.26,139.69l1.6-6.62l3.4-10.4l3.99-10.18l4.75-9.7l5.57-9.36l6.18-8.97l6.77-8.37l7.58-8.2
                c2.97-3.22,2.78-8.23-0.44-11.21c-3.22-2.97-8.23-2.78-11.21,0.44l-7.76,8.39c-0.12,0.13-0.23,0.26-0.34,0.4l-7.13,8.81
                c-0.13,0.16-0.25,0.32-0.37,0.49l-6.5,9.44c-0.1,0.14-0.19,0.29-0.28,0.44l-5.87,9.86c-0.11,0.19-0.21,0.38-0.31,0.57l-5.03,10.28
                c-0.09,0.19-0.18,0.39-0.26,0.59l-4.2,10.7c-0.06,0.14-0.11,0.29-0.15,0.43l-3.57,10.91c-0.06,0.2-0.12,0.4-0.17,0.6l-1.68,6.92
                c-0.15,0.63-0.23,1.26-0.23,1.87c0,3.58,2.44,6.82,6.07,7.7C30.94,146.56,35.23,143.94,36.26,139.69z"/>
                <path class="st0" d="M70.09,275.38l-7.14-8.56l-6.14-8.72l-5.59-9.38l-4.99-9.79l-4.2-10l-3.59-10.18l-2.78-10.52l-1.99-10.75
                l-1.19-10.75l-0.4-10.78l0.2-7.72c0.12-4.37-3.34-8.02-7.72-8.14c-4.38-0.12-8.02,3.34-8.14,7.72l-0.21,7.97c0,0.07,0,0.14,0,0.21
                c0,0.1,0,0.2,0.01,0.29l0.42,11.33c0.01,0.19,0.02,0.39,0.04,0.58l1.26,11.33c0.02,0.19,0.05,0.38,0.08,0.57l2.1,11.33
                c0.04,0.2,0.08,0.39,0.13,0.58l2.94,11.12c0.05,0.21,0.12,0.41,0.19,0.61l3.78,10.7c0.05,0.15,0.11,0.29,0.17,0.43l4.4,10.49
                c0.08,0.18,0.16,0.36,0.25,0.53l5.24,10.28c0.08,0.15,0.16,0.31,0.25,0.45l5.87,9.86c0.1,0.17,0.21,0.34,0.33,0.51l6.5,9.23
                c0.12,0.18,0.25,0.35,0.39,0.51l7.34,8.81c2.8,3.37,7.81,3.82,11.17,1.02C72.44,283.75,72.9,278.75,70.09,275.38z"/>
                <path class="st0" d="M185.89,342.5l11.54-0.63c0.15-0.01,0.3-0.02,0.44-0.04l3.78-0.42c4.35-0.48,7.49-4.41,7.01-8.76
                c-0.48-4.35-4.41-7.49-8.76-7.01l-3.55,0.39l-10.95,0.6l-10.75-0.4l-10.82-1l-10.75-1.79l-10.6-2.6l-10.31-3.17l-9.91-4.16
                l-9.84-4.82l-9.39-5.39l-9.17-6.18l-2.71-2.13c-3.44-2.71-8.43-2.11-11.14,1.34c-1.14,1.45-1.7,3.18-1.7,4.9
                c0,2.35,1.04,4.68,3.03,6.24l2.94,2.31c0.15,0.12,0.31,0.23,0.47,0.34l9.65,6.5c0.16,0.11,0.32,0.21,0.48,0.3l9.86,5.66
                c0.15,0.09,0.31,0.17,0.46,0.25l10.28,5.03c0.14,0.07,0.28,0.13,0.42,0.19l10.49,4.41c0.24,0.1,0.49,0.19,0.74,0.27l10.91,3.36
                c0.15,0.05,0.29,0.09,0.44,0.12l11.12,2.73c0.19,0.05,0.39,0.09,0.59,0.12l11.33,1.89c0.19,0.03,0.38,0.06,0.57,0.07l11.33,1.05
                c0.15,0.01,0.29,0.02,0.44,0.03l11.33,0.42C185.41,342.52,185.65,342.52,185.89,342.5z"/>
                <path class="st0" d="M316.46,248.51l-3.87,6.52l-6.21,9.22l-6.58,8.37l-7.37,8.17l-7.77,7.37l-8.38,6.98l-8.96,6.37l-9.18,5.59
                l-9.58,4.99l-10.14,4.38l-10.19,3.46c-3.3,1.12-5.38,4.21-5.38,7.51c0,0.85,0.14,1.71,0.42,2.55c1.41,4.15,5.92,6.37,10.06,4.96
                l10.49-3.57c0.2-0.07,0.4-0.14,0.59-0.23l10.7-4.62c0.18-0.08,0.35-0.16,0.52-0.25l10.07-5.24c0.16-0.08,0.31-0.17,0.46-0.26
                l9.65-5.87c0.16-0.1,0.32-0.2,0.47-0.31l9.44-6.71c0.17-0.12,0.33-0.24,0.48-0.37l8.81-7.34c0.13-0.11,0.26-0.22,0.38-0.34
                l8.18-7.76c0.15-0.14,0.29-0.29,0.43-0.44l7.76-8.6c0.12-0.13,0.24-0.27,0.35-0.41l6.92-8.81c0.12-0.15,0.23-0.31,0.34-0.47
                l6.5-9.65c0.08-0.13,0.17-0.25,0.24-0.38l3.99-6.71c2.24-3.77,1-8.63-2.77-10.87C323.56,243.51,318.69,244.75,316.46,248.51z"/>
                </svg>
                <div class="sr_skip_number">30</div>
            </div>';
            }
            $widgetPart_control .= ( $playerWidgetTemplate == 'skin_float_tracklist' )?'</div><div class="control">':'';
            if ( $this->getOptionValue('show_shuffle_bt', $instance) ){
                $widgetPart_control .= '<div class="sr_shuffle">
                <svg version="1.1" class="sr_shuffle_on" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0px" y="0px"
                viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
                    <path d="M18.2,13.2c-0.1-0.1-0.4-0.1-0.5,0c-0.1,0.1-0.1,0.4,0,0.5l2.1,2h-3.6c-0.9,0-2.1-0.6-2.7-1.3L10.9,11l2.7-3.4
                    c0.6-0.7,1.8-1.3,2.7-1.3h3.6l-2.1,2c-0.1,0.1-0.1,0.4,0,0.5c0.1,0.1,0.2,0.1,0.3,0.1c0.1,0,0.2,0,0.3-0.1L21,6.2
                    c0.1-0.1,0.1-0.2,0.1-0.3c0-0.1,0-0.2-0.1-0.3L18.2,3c-0.1-0.1-0.4-0.1-0.5,0c-0.1,0.1-0.1,0.4,0,0.5l2.1,2h-3.6
                    c-1.1,0-2.5,0.7-3.2,1.6l-2.6,3.3L7.8,7.1C7.1,6.2,5.7,5.5,4.6,5.5H1.3c-0.2,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h3.3
                    c0.9,0,2.1,0.6,2.7,1.3L9.9,11l-2.7,3.4c-0.6,0.7-1.8,1.3-2.7,1.3H1.3c-0.2,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h3.3
                    c1.1,0,2.5-0.7,3.2-1.6l2.6-3.3l2.6,3.3c0.7,0.9,2.1,1.6,3.2,1.6h3.6l-2.1,2c-0.1,0.1-0.1,0.4,0,0.5c0.1,0.1,0.2,0.1,0.3,0.1
                    c0.1,0,0.2,0,0.3-0.1l2.7-2.7c0.1-0.1,0.1-0.2,0.1-0.3c0-0.1,0-0.2-0.1-0.3L18.2,13.2z"/>
                </svg>
                <svg version="1.1" class="sr_shuffle_off" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0px" y="0px"
                viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
                    <path d="M19,15.4H3.2l2.8-2.7c0.1-0.1,0.1-0.3,0-0.5c-0.1-0.1-0.3-0.1-0.5,0l-3.3,3.3C2.1,15.5,2,15.6,2,15.7c0,0.1,0,0.2,0.1,0.2
                    l3.3,3.3c0.1,0.1,0.1,0.1,0.2,0.1c0.1,0,0.2,0,0.2-0.1c0.1-0.1,0.1-0.3,0-0.5L3.2,16H19c0.2,0,0.3-0.1,0.3-0.3
                    C19.3,15.5,19.1,15.4,19,15.4z M20.3,7.2l-3.3-3.3c-0.1-0.1-0.3-0.1-0.5,0c-0.1,0.1-0.1,0.3,0,0.5l2.8,2.7H3.5
                    c-0.2,0-0.3,0.1-0.3,0.3c0,0.2,0.1,0.3,0.3,0.3h15.8l-2.8,2.7c-0.1,0.1-0.1,0.3,0,0.5c0.1,0.1,0.1,0.1,0.2,0.1c0.1,0,0.2,0,0.2-0.1
                    l3.3-3.3c0.1-0.1,0.1-0.1,0.1-0.2C20.4,7.3,20.3,7.3,20.3,7.2z"/>
                </svg>
                </div>';
            }
        if ( $this->getOptionValue('show_speed_bt', $instance) ){
                $widgetPart_control .= '<div class="sr_speedRate"><div>1X</div></div>';
        }
        if ( $this->getOptionValue('show_volume_bt', $instance) ){
                $widgetPart_control .= '<div class="volume">
                <div class="icon">
                    <svg class="sr_mute" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0px" y="0px"
                        viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
                    <path d="M11.7,19c0,0.3-0.1,0.6-0.3,0.8c-0.2,0.2-0.5,0.3-0.8,0.3c-0.3,0-0.6-0.1-0.8-0.3l-4.1-4.1H1.1c-0.3,0-0.6-0.1-0.8-0.3
                        C0.1,15.2,0,14.9,0,14.6V8c0-0.3,0.1-0.6,0.3-0.8C0.5,7,0.8,6.9,1.1,6.9h4.7l4.1-4.1c0.2-0.2,0.5-0.3,0.8-0.3c0.3,0,0.6,0.1,0.8,0.3
                        c0.2,0.2,0.3,0.5,0.3,0.8V19z"/>
                    <g>
                        <path d="M17.2,11.2l1.7,1.7c0.1,0.1,0.1,0.2,0.1,0.4c0,0.1,0,0.3-0.1,0.4L18.5,14c-0.1,0.1-0.2,0.1-0.4,0.1c-0.1,0-0.3,0-0.4-0.1
                        l-1.7-1.7L14.4,14c-0.1,0.1-0.2,0.1-0.4,0.1c-0.1,0-0.3,0-0.4-0.1l-0.4-0.4c-0.1-0.1-0.1-0.2-0.1-0.4c0-0.1,0-0.3,0.1-0.4l1.7-1.7
                        l-1.7-1.7c-0.1-0.1-0.1-0.2-0.1-0.4c0-0.1,0-0.3,0.1-0.4l0.4-0.4c0.1-0.1,0.2-0.1,0.4-0.1c0.1,0,0.3,0,0.4,0.1l1.7,1.7l1.7-1.7
                        c0.1-0.1,0.2-0.1,0.4-0.1c0.1,0,0.3,0,0.4,0.1l0.4,0.4C18.9,8.9,19,9.1,19,9.2c0,0.1,0,0.3-0.1,0.4L17.2,11.2z"/>
                    </g>
                    </svg>
                    <svg class="sr_unmute" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0px" y="0px"
                    viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
                    <g>
                        <path d="M11.7,19c0,0.3-0.1,0.6-0.3,0.8c-0.2,0.2-0.5,0.3-0.8,0.3c-0.3,0-0.6-0.1-0.8-0.3l-4.1-4.1H1.1c-0.3,0-0.6-0.1-0.8-0.3
                        C0.1,15.2,0,14.9,0,14.6V8c0-0.3,0.1-0.6,0.3-0.8C0.5,7,0.8,6.9,1.1,6.9h4.7l4.1-4.1c0.2-0.2,0.5-0.3,0.8-0.3
                        c0.3,0,0.6,0.1,0.8,0.3c0.2,0.2,0.3,0.5,0.3,0.8V19z M17.1,9.2c-0.4-0.7-0.9-1.2-1.6-1.6c-0.3-0.2-0.7-0.3-1.1-0.2
                        C14,7.5,13.7,7.7,13.5,8c-0.2,0.4-0.3,0.7-0.2,1.1c0.1,0.4,0.3,0.7,0.7,0.9c0.5,0.3,0.7,0.7,0.7,1.2c0,0.5-0.2,0.9-0.6,1.2
                        c-0.3,0.2-0.5,0.6-0.6,1s0,0.8,0.3,1.1c0.2,0.3,0.5,0.5,0.9,0.6c0.4,0.1,0.8,0,1.1-0.2c0.6-0.4,1-1,1.4-1.6c0.3-0.6,0.5-1.3,0.5-2
                        C17.6,10.6,17.4,9.8,17.1,9.2z M20.9,7c-0.8-1.3-1.8-2.4-3.1-3.2c-0.3-0.2-0.7-0.3-1.1-0.2c-0.4,0.1-0.7,0.3-0.9,0.7
                        c-0.2,0.4-0.3,0.7-0.2,1.1c0.1,0.4,0.3,0.7,0.7,0.9c0.9,0.5,1.5,1.2,2,2.1c0.5,0.9,0.8,1.8,0.8,2.9c0,0.9-0.2,1.8-0.7,2.7
                        c-0.4,0.9-1.1,1.6-1.9,2.1c-0.3,0.2-0.5,0.6-0.6,1c-0.1,0.4,0,0.8,0.3,1.1c0.3,0.4,0.7,0.6,1.2,0.6c0.3,0,0.6-0.1,0.8-0.3
                        c1.2-0.8,2.1-1.9,2.8-3.2c0.7-1.3,1-2.6,1-4.1C22,9.8,21.6,8.3,20.9,7z"/>
                    </g>
                    </svg>
                    <div class="slider-container">
                    <div class="slide"></div>
                </div>
                </div>
                </div>';
            }

        $widgetPart_control .= ($playerWidgetTemplate == 'skin_boxed_tracklist' && $trackNumber == 1 )? '<div class="srp_track_cta"></div>': '';
        $widgetPart_control .= '</div>'; //End DIV .control
        $widgetPart_control .= ($playerWidgetTemplate == 'skin_boxed_tracklist' && $trackNumber == 1)? $this->addNoteButton( $albums, '0', $trackTitle) :'';
        $widgetPart_control .= ($playerWidgetTemplate == 'skin_float_tracklist' ||  $trackNumber == 1 )?'</div>':''; //End DIV .srp_main_control
        
        $class_player ='player ';
        $class_player .=($progressbar_inline) ? 'sr_player__inline ' : '';
        $controlArtwork = ($displayControlArtwork) ? $prev_play_next_Controls : '';
        $displayControlUnder = ($hide_control_under || $playerWidgetTemplate == 'skin_boxed_tracklist') ? '' : $widgetPart_control;
        $notrackskip = ($notrackskip == false) ? get_post_meta($albums, 'no_track_skip', true) : $notrackskip;
        $playerType = $this->get_playerType($firstAlbum);
        $widgetPart_artwork = (!$hide_artwork || $hide_artwork!="true" ?
                '<div class="sonaar-Artwort-box">
                <div class="control">
                    ' . $controlArtwork . '
                </div>
                    <div class="album">
                        <div class="album-art">
                            <img alt="album-art">
                        </div>
                    </div>
                </div>'
            : '');
        
        $widgetPart_title =  '<'.esc_attr($title_html_tag_playlist).' class="sr_it-playlist-title">'. esc_attr($playlist_title) .'</'.esc_attr($title_html_tag_playlist).'>';

        
        $widgetPart_subtitle =  '<div class="srp_subtitle">'. ( ( get_post_meta( $firstAlbum, 'alb_release_date', true ) )? esc_html(get_post_meta($firstAlbum, 'alb_release_date', true )) : '' ) . '</div>'; //'alb_release_date' field is now used for the subtitle

        $wpkses_arr = array( 'br' => array(), 'p' => array(), 'strong' => array(), 'a' => array('href' => array(), 'title' => array()));
        $widgetPart_cat_description =  ( $this->getOptionValue('show_cat_description', $instance) && $terms) ? '<div class="srp_podcast_rss_description">' . wp_kses(category_description((int)$terms[0]),$wpkses_arr) . '</div>' : '';

        $widgetPart_meta = '<div class="srp_player_meta">';
        $widgetPart_meta .= ($showPublishDate)?'<div class="sr_it-playlist-publish-date">'. esc_html(get_the_date( $dateFormat, $albums )) .'</div>':'';
        $widgetPart_meta .= ($this->getOptionValue('show_tracks_count', $instance)  && $trackNumber > 1 )?'<div class="srp_trackCount">'. esc_attr($trackNumber) . ' ' . esc_html(Sonaar_Music::get_option('player_show_tracks_count_label', 'srmp3_settings_widget_player')) .'</div>':'';
        $widgetPart_meta .= ($this->getOptionValue('show_meta_duration', $instance))?'<div class="srp_playlist_duration" data-hours-label="'. esc_html(Sonaar_Music::get_option('player_hours_label', 'srmp3_settings_widget_player')) .'" data-minutes-label="'. esc_html(Sonaar_Music::get_option('player_minutes_label', 'srmp3_settings_widget_player')) .'"></div>':'';
        $widgetPart_meta .= '</div>';
        
        $widgetPart_tracklist =  ($playerWidgetTemplate == 'skin_boxed_tracklist' && $trackNumber > 1 || $playerWidgetTemplate == 'skin_float_tracklist' )?'<div class="playlist">':'<div class="playlist" style="display:none;">';
        $widgetPart_tracklist .= (!$hide_album_title && $playerWidgetTemplate == 'skin_float_tracklist') ? $widgetPart_title : '' ;
        $widgetPart_tracklist .= ($hide_album_subtitle || $playerWidgetTemplate == 'skin_boxed_tracklist') ? '' : $widgetPart_subtitle;
        $widgetPart_tracklist .= ( ($showPublishDate || $this->getOptionValue('show_meta_duration', $instance) || $this->getOptionValue('show_tracks_count', $instance)) && $playerWidgetTemplate == 'skin_float_tracklist') ? $widgetPart_meta : '';
        $widgetPart_tracklist .= ( $playerWidgetTemplate == 'skin_float_tracklist' ) ? $widgetPart_cat_description : '';
        $widgetPart_tracklist .= '<div class="srp_tracklist"><ul class"">' . $format_playlist . '</ul></div></div>';
       
        $widgetPart_albumStore = '<div class="album-store">' . $this->get_market( $store_title_text, $album_ids_with_show_market, $feedurl, $el_widget_id, $terms) . '</div>';
        
        if($displayControlArtwork){
            $widgetPart_playButton = '';
        }else{
            $widgetPart_playButton = ( $this->getOptionValue('use_play_label', $instance ) ) ? '
            <div class="srp-play-button play srp-play-button-label-container" href="#">
                <div class="srp-play-button-label">' . esc_html($labelPlayTxt) .'</div>
                <div class="srp-pause-button-label">' . esc_html($labelPauseTxt) .'</div>
            </div>'
            :'
            <div class="srp-play-button play" href="#">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" x="0px" y="0px" viewBox="0 0 17.5 21.2" xml:space="preserve" class="srp-play-icon">
                    <path d="M0,0l17.5,10.9L0,21.2V0z"></path>
                    <rect width="6" height="21.2"></rect>
                    <rect x="11.5" width="6" height="21.2"></rect>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="srp-play-circle" width="79.19" height="79.19">
                    <circle r="40%" fill="none" stroke="black" stroke-width="6" cx="50%" cy="50%"></circle>
                </svg>
            </div>';
        }
        
        $widgetPart_main = '<div class="album-player">';
        $widgetPart_main .= ( ( ($trackNumber == 1 || !$show_playlist) && $playerWidgetTemplate == 'skin_boxed_tracklist' ) || ($show_playlist && $playerWidgetTemplate == 'skin_float_tracklist') || $hide_player_title || (!$show_playlist && $hide_album_title && $playerWidgetTemplate == 'skin_float_tracklist'))?'':'<'. esc_attr($title_html_tag_soundwave) .' class="album-title"></'. esc_attr($title_html_tag_soundwave) .'>'; 
        $widgetPart_main .= ( !$hide_track_title && $playerWidgetTemplate == 'skin_float_tracklist' || (!$hide_player_title && $playerWidgetTemplate == 'skin_boxed_tracklist' && ($trackNumber == 1 || !$show_playlist)))? '<'. esc_attr($track_title_html_tag_soundwave).' class="track-title"></'. esc_attr($track_title_html_tag_soundwave).'>' : '';
        $widgetPart_main .= ( $playerWidgetTemplate == 'skin_boxed_tracklist' )? $widgetPart_subtitle . $widgetPart_meta . '<div class="srp_control_box">'. $widgetPart_playButton .'<div class="srp_wave_box">' : '';
        $widgetPart_main .= ' <div class="' . esc_attr($class_player) . '" ' . esc_attr($player_style) . '><div class="sr_progressbar">' . $progressbar . ' </div>' . $displayControlUnder . '</div>';
        if($playerWidgetTemplate == 'skin_boxed_tracklist'){
            $widgetPart_main .= ( $this->getOptionValue('use_play_label', $instance ) )?  '</div></div>'. $widgetPart_control :   $widgetPart_control . '</div></div>';
        }
        $albums = str_replace(' ', '', $albums);

        $output = '<div class="iron-audioplayer ' . esc_attr($ironAudioClass) . '" id="'. esc_attr( $args["widget_id"] ) .'-' . bin2hex(random_bytes(5)) . '" data-id="' . esc_attr( $args["widget_id"]) .'" data-albums="'. esc_attr( $albums) .'"data-url-playlist="' . esc_url(home_url('?load=playlist.json&amp;title='.$title.'&amp;albums='.$albums.'&amp;feed_title='.$feed_title.'&amp;feed='.$feed.'&amp;feed_img='.$feed_img.'&amp;el_widget_id='.$el_widget_id.'&amp;artwork='.$artwork .'&amp;posts_per_pages='.$posts_per_pages .'&amp;all_category='.$all_category .'&amp;single_playlist='.$single_playlist .'&amp;reverse_tracklist='. $this->getOptionValue('reverse_tracklist', $instance) )) . '" data-sticky-player="'. esc_attr($sticky_player) . '" data-shuffle="'. esc_attr($shuffle) . '" data-playlist_title="'. esc_html($playlist_title) . '" data-scrollbar="'. esc_attr($scrollbar) . '" data-wave-color="'. esc_attr($wave_color) .'" data-wave-progress-color="'. esc_attr($wave_progress_color) . '" data-no-wave="'. esc_attr($hide_timeline) . '" data-hide-progressbar="'. esc_attr($hide_progressbar) . '" data-feedurl="'. esc_attr($feedurl) .'" data-notrackskip="'. esc_attr($notrackskip) .'" data-playertype="'. esc_attr($playerType) .'" data-playertemplate ="'. esc_attr($playerWidgetTemplate) .'" data-hide-artwork ="'. esc_attr($hide_artwork) .'" data-speedrate="1" style="opacity:0;">';
        if($playerWidgetTemplate == 'skin_boxed_tracklist'){ // Boxed skin
            $output .= ($widgetPart_cat_description == '')?'<div class="srp_player_boxed srp_player_grid">':'<div class="srp_player_boxed"><div class="srp_player_grid">';
            $output .= $widgetPart_artwork . $widgetPart_main;// . $widgetPart_albumStore .'</div></div>';
            $output .= ( isset ($albumStorePosition) && $albumStorePosition == 'top') ? $widgetPart_albumStore : '';
            $output .= '</div></div>';
            $output .= ($widgetPart_cat_description == '')?'': $widgetPart_cat_description  . '</div>';
            $output .= $widgetPart_tracklist;
            $output .= ( isset ($albumStorePosition) && $albumStorePosition !== 'top') ? $widgetPart_albumStore : '';
        }else{ // Floated skin
            $inlineSyle = ($widgetPart_artwork == '' &&  !$show_playlist)? 'style="display:none;"':''; //hide sonaar-grid and its background if it is empty
            $output .= '<div class="sonaar-grid" '. esc_html($inlineSyle) . '>'. $widgetPart_artwork . $widgetPart_tracklist .'</div>'. $widgetPart_main . '</div>' . $widgetPart_albumStore;
        }   
        $output .= '</div>'; 

        echo $output;
        
        //Temp. removed: Not required
        // echo $action;
        echo $args['after_widget'];
    }

    /* Return the notebutton HTML or NULL */
    private function addNoteButton($postID, $trackPosition, $trackTitle, $trackdescEscapedValue = null, $excerptTrimmed = null){
        /*parameters:
        -$postID: playlist post ID
        -$trackPosition: track position in the playlist post, not in the track list.
        -$trackTitle: The track title: Required to display it in the Note content
        -$trackdescEscapedValue: (OPTIONAL) The Excerpt content. We have to check if the "note" is cuted by the "$excerptTrimmed"("[...]").
        -$excerptTrimmed: (OPTIONAL) [...]
        */
        $returnValue = null;
        if( function_exists( 'run_sonaar_music_pro' ) ){ 
            $trackFields = get_post_meta($postID, 'alb_tracklist', true );
            if( isset($trackFields[$trackPosition]['track_description']) && $trackFields[$trackPosition]['track_description'] != ''){
                if ( ($trackdescEscapedValue && substr(strip_tags($trackdescEscapedValue), -1 * (strlen($excerptTrimmed))) == $excerptTrimmed) || $trackdescEscapedValue == null ){ // Check if the Excerpt display the whole description or if it is cuted/ended by the $excerptTrimmed[...].
                    $returnValue = '<div class="srp_noteButton"><i class="sricon-info"  data-source-post-id="' . esc_attr( $postID ) . '" data-track-position="' . esc_attr( $trackPosition ) . '" data-track-title="' . esc_attr( $trackTitle ) . '"></i></div>';
                }
            }
        }
        return $returnValue;
    }
    
    /*E.g. Return the value from "show_skip_bt" (shortcode) or "player_show_skip_bt" (plugin settings) */
    private function getOptionValue($optionID, $instance, $proRequired = true, $defaultValue = false){
        /*parameters:
        -$optionID: the option id from the plugins settings has to have the prefix "player_" add to the shortcode id (E.g. "player_show_skip_bt" for "show_skip_bt" )
        -$instance: The $instance variable
        -$proRequired: (OPTIONAL) We have to set this false if the option is available with the free plugin
        -$defaultValue: (OPTIONAL) If the setting is not saved return this value.
        */
        if($proRequired && !function_exists( 'run_sonaar_music_pro' ) ){ 
            return false;
        }
        if( isset($instance[$optionID]) && $instance[$optionID] != 'default') {
            return filter_var($instance[$optionID], FILTER_VALIDATE_BOOLEAN); //get value from the shortcode
        }else if(Sonaar_Music::get_option('player_' . $optionID, 'srmp3_settings_widget_player') != null){
            return filter_var(Sonaar_Music::get_option('player_' . $optionID, 'srmp3_settings_widget_player'), FILTER_VALIDATE_BOOLEAN); //get value from the plugin settings
        }else{
            return $defaultValue;
        }
    }
    
    private function wc_add_to_cart($id = null){
       
        if ( $id == null || ( !defined( 'WC_VERSION' ) && get_site_option('SRMP3_ecommerce') != '1' ) ){
            return false;
        }

        return get_post_meta($id, 'wc_add_to_cart', true);
    }
    private function wc_buynow_bt($id = null){
        if ($id == null || ( !defined( 'WC_VERSION' ) && get_site_option('SRMP3_ecommerce') != '1' )){
            return false;
        }

        return get_post_meta($id, 'wc_buynow_bt', true);
    }
    private function get_market($store_title_text, $album_id = 0, $feedurl = 0, $el_widget_id = null, $terms = null){
        
        if( $album_id == 0 && !$feedurl)
        return;

        if (!$feedurl){ // source if from albumid
            $firstAlbum = explode(',', $album_id);
            $firstAlbum = $firstAlbum[0];
            $storeList = get_post_meta($firstAlbum, 'alb_store_list', true);

            $wc_add_to_cart =  $this->wc_add_to_cart($firstAlbum);
            $wc_buynow_bt =  $this->wc_buynow_bt($firstAlbum);
            $is_variable_product = ($wc_add_to_cart == 'true' || $wc_buynow_bt == 'true' ) ? $this->is_variable_product($firstAlbum) : '';
            
            //check to add woocommerce icons for external links
            $album_store_list = ($wc_add_to_cart == 'true' || $wc_buynow_bt == 'true') ? $this->push_woocart_in_storelist(get_post($firstAlbum), $is_variable_product, $wc_add_to_cart, $wc_buynow_bt) : false;
          
            if ( is_singular( SR_PLAYLIST_CPT ) && Sonaar_Music::get_option('player_type', 'srmp3_settings_general') == 'podcast' ) {
                if ($terms == null) {
                    //no terms variable is passed manually. So check if post has terms 
                    $terms = get_the_terms(  get_the_ID(), 'podcast-show' ); 
                    $terms = ($terms == false) ? null : $terms[0]->term_id;
                }
            }

            //check to add category icons for external links
            $album_cat_store_list = ($terms) ? $this->push_caticons_in_storelist( get_post($firstAlbum), $terms ) : null;
           
            // merge arrays temporary
            $album_store_list = (isset($album_store_list) && is_array($album_store_list) && count($album_store_list) > 0 && is_array($album_cat_store_list)) ? array_merge($album_store_list,  $album_cat_store_list ) : $album_cat_store_list;
        
        } else if($feedurl = 1) {
             // source if from elementor widget
            if (!$el_widget_id)
            return;

            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                //__A. WE ARE IN EDITOR SO USE CURRENT POST META SOURCE TO UPDATE THE WIDGET LIVE OTHERWISE IT WONT UPDATE WITH LIVE DATA
                $storeList =  get_post_meta( $album_id, 'alb_store_list', true);
                if($storeList == ''){
                    return;
                }   
            }else{
                //__B. WE ARE IN FRONT-END SO USE SAVED POST META SOURCE
                $elementorData = get_post_meta( $album_id, '_elementor_data', true);
                $elementorData = json_decode($elementorData, true);
                $id = $el_widget_id;
                $results=[];

                if($elementorData){
                   $this->findData( $elementorData, $id, $results );
                   $storeList = (!empty($results['settings']['storelist_repeater'])) ? $results['settings']['storelist_repeater'] : '';
                }else{
                    return;
                } 
            }
        }
        if(isset($album_store_list) && is_array($album_store_list) && count($album_store_list) > 0){

            $storeList = (is_array($storeList)) ? array_merge($storeList,$album_store_list ): $album_store_list;
        }
            if ( is_array($storeList) && $storeList ){
                $output = '
                <div class="buttons-block">
                    <div class="ctnButton-block">
                        <div class="available-now">';
                            $output .= ( $store_title_text == NULL ) ? esc_html__("Available now on:", 'sonaar-music') : esc_html__($store_title_text);
                            $output .=  '
                        </div>
                        <ul class="store-list">';
                        if ($feedurl){
                            foreach ($storeList as $store ) {
                                if(!isset($store['store_name'])){
                                    $store['store_name']="";
                                }
                                if(!isset($store['store_link'])){
                                    $store['store_link']="";
                                }

                                if(array_key_exists ( 'store_icon' , $store )){
                                    $icon = ( $store['store_icon']['value'] )? '<i class="' . esc_html($store['store_icon']['value']) . '"></i>': '';
                                }else{
                                    $icon ='';
                                }
                                $output .= '<li><a class="button" href="' . esc_url( $store['store_link'] ) . '" target="_blank">'. $icon . $store['store_name'] . '</a></li>';
                            }
                        }else{
                            foreach ($storeList as $key => $store ) {
                                if(!isset($store['store-name'])){
                                    $store['store-name']="";
                                }
                                if(!isset($store['store-link'])){
                                    $store['store-link']="";
                                }
                                if(!isset($store['store-target'])){
                                    $store['store-target']='_blank';
                                }

                                if(array_key_exists ( 'store-icon' , $store )){
                                    $icon = ( $store['store-icon'] )? '<i class="' . esc_html($store['store-icon']) . '"></i>': '';
                                }else{
                                    $icon ='';
                                }
                                $classes = 'button';

                                $href = 'href="' . esc_url($store['store-link']) . '"';
                                if(isset($store['link-option']) && $store['link-option'] == 'popup'){ 
                                    $classes .= ' sr-store-popup';
                                    $store['store-target'] = '_self';
                                    $href = '';
                                }
                                $output .= '<li><a class="'. esc_attr($classes) .'" data-source-post-id="' . esc_attr($firstAlbum) .'" data-store-id="a-'. esc_attr($key) .'" '. $href .' target="' . $store['store-target'] . '">'. $icon . $store['store-name'] . '</a></li>';
                            }
                        }

                        $output .= '
                        </ul>
                    </div>
                </div>';
                
                return $output;
            }        
    }

    /**
    * Back-end widget form.
    */
    
    public function form ( $instance ){
        $instance = wp_parse_args( (array) $instance, self::$widget_defaults );
            
            $title = esc_attr( $instance['title'] );
            $albums = $instance['albums'];
            $show_playlist = (bool)$instance['show_playlist'];
            $sticky_player = (bool)$instance['sticky_player'];
            $hide_artwork = (bool)$instance['hide_artwork'];
            $show_album_market = (bool)$instance['show_album_market'];
            $show_track_market = (bool)$instance['show_track_market'];
            //$remove_player = (bool)$instance['remove_player']; // deprecated and replaced by hide_timeline
            $hide_timeline = (bool)$instance['hide_timeline'];
            
            $all_albums = get_posts(array(
            'post_type' => SR_PLAYLIST_CPT
            , 'posts_per_page' => -1
            , 'no_found_rows'  => true
            ));
            
            if ( !empty( $all_albums ) ) :?>

  <p>
    <label for="<?php echo esc_html($this->get_field_id('title')); ?>">
      <?php _ex('Title:', 'Widget', 'sonaar-music'); ?>
    </label>
    <input type="text" class="widefat" id="<?php echo esc_html($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" placeholder="<?php _e('Popular Songs', 'sonaar-music'); ?>" />
  </p>
  <p>
    <label for="<?php echo esc_html($this->get_field_id('albums')); ?>">
      <?php esc_html_e('Album:', 'Widget', 'sonaar-music'); ?>
    </label>
    <select class="widefat" id="<?php echo esc_attr($this->get_field_id('albums')); ?>" name="<?php echo esc_attr($this->get_field_name('albums')); ?>[]" multiple="multiple">
      <?php foreach($all_albums as $a): ?>

        <option value="<?php echo esc_attr($a->ID); ?>" <?php echo ( is_array($albums) && in_array($a->ID, $albums) ? ' selected="selected"' : ''); ?>>
          <?php echo esc_attr($a->post_title); ?>
        </option>

        <?php endforeach; ?>
    </select>
  </p>
<?php if ( function_exists( 'run_sonaar_music_pro' ) ): ?>
  <p>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('sticky_player')); ?>" name="<?php echo esc_attr($this->get_field_name('sticky_player')); ?>" <?php checked( esc_attr($sticky_player) ); ?> />
    <label for="<?php echo esc_attr($this->get_field_id('sticky_player')); ?>">
      <?php esc_html_e( 'Enable Sticky Audio Player', 'sonaar-music'); ?>
    </label>
    <br />
  </p>
<?php endif ?>
  <p>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('show_playlist')); ?>" name="<?php echo esc_attr($this->get_field_name('show_playlist')); ?>" <?php checked( esc_attr($show_playlist) ); ?> />
    <label for="<?php echo esc_attr($this->get_field_id('show_playlist')); ?>">
      <?php esc_html_e( 'Show Playlist', 'sonaar-music'); ?>
    </label>
    <br />
  </p>

  <p>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('show_album_market')); ?>" name="<?php echo esc_attr($this->get_field_name('show_album_market')); ?>" <?php checked( esc_attr($show_album_market) ); ?> />
    <label for="<?php echo esc_attr($this->get_field_id('show_album_market')); ?>">
      <?php esc_html_e( 'Show Album store', 'sonaar-music'); ?>
    </label>
    <br />
  </p>
  <p>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_artwork')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_artwork')); ?>" <?php checked( esc_attr($hide_artwork )); ?> />
    <label for="<?php echo esc_attr($this->get_field_id('hide_artwork')); ?>">
      <?php esc_html_e( 'Hide Album Cover', 'sonaar-music'); ?>
    </label>
    <br />
  </p>
  <p>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('show_track_market')); ?>" name="<?php echo esc_attr($this->get_field_name('show_track_market')); ?>" <?php checked( esc_attr($show_track_market )); ?> />
    <label for="<?php echo esc_attr($this->get_field_id('show_track_market')); ?>">
      <?php esc_html_e( 'Show Track store', 'sonaar-music'); ?>
    </label>
    <br />
  </p>
  </p>
  <p>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_timeline')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_timeline')); ?>" <?php checked( esc_attr($hide_timeline )); ?> />
    <label for="<?php echo esc_attr($this->get_field_id('hide_timeline')); ?>">
      <?php esc_html_e( 'Remove Visual Timeline', 'sonaar-music'); ?>
    </label>
    <br />
  </p>

  <?php
            else:
                
            echo wp_kses_post( '<p>'. sprintf( _x('No albums have been created yet. <a href="%s">Create some</a>.', 'Widget', 'sonaar-music'), esc_url(admin_url('edit.php?post_type=' . SR_PLAYLIST_CPT)) ) .'</p>' );
            
            endif;
    }
    
    
    
    
    
    
    /**
    * Sanitize widget form values as they are saved.
    */
    
    public function update ( $new_instance, $old_instance )
    {
        $instance = wp_parse_args( $old_instance, self::$widget_defaults );
            
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
            $instance['albums'] = $new_instance['albums'];
            $instance['show_playlist']  = (bool)$new_instance['show_playlist'];
            $instance['hide_artwork']  = (bool)$new_instance['hide_artwork'];
            $instance['sticky_player']  = (bool)$new_instance['sticky_player'];
            $instance['show_album_market']  = (bool)$new_instance['show_album_market'];
            $instance['show_track_market']  = (bool)$new_instance['show_track_market'];
            //$instance['remove_player']  = (bool)$new_instance['remove_player']; deprecated and replaced by hide_timeline
            $instance['hide_timeline']  = (bool)$new_instance['hide_timeline'];
            
            return $instance;
    }
    
    
    private function print_playlist_json() {
        $jsonData = array();

        if ( ! empty($_GET["albums"]) ){
            $re = '/^\d+(?:,\d+)*$/';
            if ( preg_match($re, $_GET["albums"]) )
                $albums = sanitize_text_field($_GET["albums"]);
            else
                $albums = array();
        }else{
            $albums = array();
        }
       
        if(!empty($_GET["el_widget_id"]) && ctype_alnum($_GET["el_widget_id"])){
            $el_widget_id = sanitize_text_field($_GET["el_widget_id"]);
        }else{
            $el_widget_id = null;
        }

        $single_playlist = !empty($_GET["single_playlist"]) ? rest_sanitize_boolean($_GET["single_playlist"]) : false;
        $title = !empty($_GET["title"]) ? sanitize_text_field($_GET["title"]) : null;
        $feed_title = !empty($_GET["feed_title"]) ? sanitize_text_field($_GET["feed_title"]) : null;
        $feed = !empty($_GET["feed"]) ? sanitize_text_field($_GET["feed"]) : null; 
        $feed_img = !empty($_GET["feed_img"]) ? sanitize_url($_GET["feed_img"]) : null;
        $artwork =  !empty($_GET["artwork"]) ? sanitize_url($_GET["artwork"]) : null;
        $posts_per_pages = !empty($_GET["posts_per_pages"]) ? intval($_GET["posts_per_pages"]) : null;
        $all_category = !empty($_GET["all_category"]) ? true : null;
        $reverse_tracklist = !empty($_GET["reverse_tracklist"]) ? true : false;
        $playlist = $this->get_playlist($albums, $title, $feed_title, $feed, $feed_img, $el_widget_id, $artwork, $posts_per_pages, $all_category, $single_playlist, $reverse_tracklist);
        if(!is_array($playlist) || empty($playlist['tracks']))
        return;
        
        wp_send_json($playlist);
        
    }
    private function findData($arr, $id, &$results = []){
        foreach ($arr as $data) {           
            if ( is_array($data) ){
                if (array_key_exists('id', $data)) {
                    if($data['id'] == $id){
                        $results = $data;
                    }
                }
                $this->findData( $data, $id, $results);     
            }
        }
        return false ;
    }
    private function get_wc_price($id){
        if ( !defined( 'WC_VERSION' ) ){
            return;
        }
       
        $currency = get_woocommerce_currency_symbol();
        $currency_pos = get_option('woocommerce_currency_pos');
       
        $product_price = get_post_meta( $id, '_price', true );
        
        if ($product_price == ''){
            $product_price = esc_html__("Free", 'sonaar-music');
            return $product_price;
        }
        
        if ($product_price != ''){
            if ( $currency_pos == 'left' ){
                return html_entity_decode($currency . $product_price);
            } else if ( $currency_pos == 'left_space' ) {
                return html_entity_decode($currency . ' ' . $product_price);
            }else if( $currency_pos == 'right' ){
                return html_entity_decode($product_price . $currency);
            }else{
                return html_entity_decode($product_price . ' ' . $currency);
            }
        }
    }
    private function is_variable_product($id){
        $product_attributes = get_post_meta( $id, '_product_attributes', false );

        if (!is_array($product_attributes) || count($product_attributes) ==0 ){
            return false;
        }
        $prod_has_attributes = array_column($product_attributes[0], 'is_variation');
        foreach($prod_has_attributes as $a){
            if ($a == 1){
                return true;
            }
        }
        return false;
    }
private function push_caticons_in_storelist($post, $terms = null){
    $terms = (is_array($terms)) ? $terms[0] : $terms;
    $store_list =  array();
    $post_id = $post->ID;

    $default_args = array(
        'post_type'           => SR_PLAYLIST_CPT,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'posts_per_page'      => -1,
        'ignore_sticky_posts' => true,
    );   
    
    $default_args['tax_query'] = array(
            array(
                'taxonomy' => 'podcast-show',
                'field'    => 'term_id',
                'terms'    => $terms
            )
    );
    
    $query_args = apply_filters( 'sonaar_podcast_feed_query_args', $default_args );
    $qry = new WP_Query( $query_args );
    $options = Sonaar_Music_Admin::getPodcastPlatforms();
    $stores = get_term_meta($terms, 'podcast_rss_url', true);
    
    if (isset($stores) && is_array($stores)){
        foreach ( $stores as $store ) {
            if ( isset($store['srpodcast_url'] )){
                $store['name'] = $options[ $store['srpodcast_url_icon'] ];
                array_push($store_list, [
                    'store-icon'    => $store['srpodcast_url_icon'],
                    'store-link'    => $store['srpodcast_url'],
                    'store-name'    => $store['name'],
                    'store-target'  => '_blank',
                    'show-label'    => true
                ]);
            }
        }
    }    
    return $store_list;

}
    private function push_woocart_in_storelist($post, $is_variable_product = null, $wc_add_to_cart = false, $wc_buynow_bt = false){
        if (  !defined( 'WC_VERSION' ) || ( defined( 'WC_VERSION' ) && !function_exists( 'run_sonaar_music_pro' ) && get_site_option('SRMP3_ecommerce') != '1' ) ){
            return false;
		}

        $wc_bt_type = Sonaar_Music::get_option('wc_bt_type', 'srmp3_settings_woocommerce');
        $store_list =  array();
        
        if ( $wc_bt_type == 'wc_bt_type_inactive' ){
            return $store_list;
        }
        
        $post_id = $post->ID;
        $slug = $post->post_name;
        
    
        $homeurl = esc_url( home_url() );
        $product_permalink = get_option('woocommerce_permalinks')['product_base'];
        $product_slug = $slug;
        $checkout_url = ( defined( 'WC_VERSION' ) ) ? wc_get_checkout_url() : '';
        $product_price = ( $wc_bt_type !='wc_bt_type_label' ) ? $this->get_wc_price($post_id) : '';
    
        if( $wc_add_to_cart == 'true' ){
            $label = (Sonaar_Music::get_option('wc_add_to_cart_text', 'srmp3_settings_woocommerce') && Sonaar_Music::get_option('wc_add_to_cart_text', 'srmp3_settings_woocommerce') != '' && Sonaar_Music::get_option('wc_add_to_cart_text', 'srmp3_settings_woocommerce') != 'Add to Cart') ? Sonaar_Music::get_option('wc_add_to_cart_text', 'srmp3_settings_woocommerce') : esc_html__('Add to Cart', 'sonaar-music');
            $label = ($wc_bt_type == 'wc_bt_type_price') ? '' : $label . ' '; 
            $url_if_variation = $homeurl . $product_permalink . '/' . $product_slug; //no add to cart since its a variation and user must choose variation from the single page
            $url_if_no_variation = get_permalink(get_the_ID()) . '?add-to-cart=' . $post_id;
            $storeicon = ( Sonaar_Music::get_option('wc_bt_show_icon', 'srmp3_settings_woocommerce') =='true' ) ? 'fas fa-cart-plus' : '';
            $pageUrl = ($is_variable_product == 1) ? $url_if_variation : $url_if_no_variation ;

            array_push($store_list, [
                'store-icon'    => $storeicon,
                'store-link'    => $pageUrl,
                'store-name'    => $label . $product_price,
                'store-target'  => '_self',
                'show-label'    => true
            ]);
        }
        if( $wc_buynow_bt == 'true' ){
            $label = (Sonaar_Music::get_option('wc_buynow_text', 'srmp3_settings_woocommerce') && Sonaar_Music::get_option('wc_buynow_text', 'srmp3_settings_woocommerce') != '' && Sonaar_Music::get_option('wc_buynow_text', 'srmp3_settings_woocommerce') != 'Buy Now' ) ? Sonaar_Music::get_option('wc_buynow_text', 'srmp3_settings_woocommerce') : esc_html__('Buy Now', 'sonaar-music');
            $label = ($wc_bt_type == 'wc_bt_type_price') ? '' : $label . ' '; 
            $url_if_variation = $homeurl . $product_permalink . '/' . $product_slug; //no add to cart since its a variation and user must choose variation from the single page;
            $url_if_no_variation = $checkout_url . '?add-to-cart=' . $post_id;
            $storeicon = ( Sonaar_Music::get_option('wc_bt_show_icon', 'srmp3_settings_woocommerce') == 'true' ) ? 'fas fa-shopping-cart' : '';
            $pageUrl = ($is_variable_product == 1) ? $url_if_variation : $url_if_no_variation ;

            array_push($store_list, [
                'store-icon'    => $storeicon,
                'store-link'    => $pageUrl,
                'store-name'    =>  $label . $product_price,
                'store-target'  => '_self',
                'show-label'    => true
            ]);
        }
        return $store_list;
    }
    private function checkACF($field, $ids, $loop = true){
        if (substr( $field, 0, 3 ) === "acf") { 
            if (!function_exists('get_field')) return $field;
            if (empty($ids[0])){
                // make sure to get current post id if no album id has been specified so we can run the checkACF function.
                $ids[0] = get_post(get_the_ID());
            }
            $strings = '';
            foreach ( $ids as $a ) {
                if (!$loop){
                    $strings .= get_field( $field,  $a->ID );
                    return $strings;
                }
                $separator = ($a != end($ids)) ? " || " : '';
                $strings .= get_field( $field,  $a->ID ) . $separator;
            }
            return $strings;
        }
        return $field;
    }
    private function get_playerType($playlistID){
        if(get_post_meta($playlistID, 'post_player_type', true)=='default') {
            return Sonaar_Music::get_option('player_widget_type', 'srmp3_settings_general');
        }else{
            return get_post_meta($playlistID, 'post_player_type', true);
        };
    }

    private function get_playlist($album_ids = array(), $title = null, $feed_title = null, $feed = null, $feed_img = null, $el_widget_id = null, $artwork = null, $posts_per_pages = null, $all_category = null, $single_playlist = false, $reverse_tracklist = false) {
        global $post;
        $playlist = array();
        $tracks = array();
        $albums = '';

        if(!is_array($album_ids)) {
            $album_ids = explode(",", $album_ids);
        }

        if( function_exists( 'run_sonaar_music_pro' ) && Sonaar_Music::get_option('sticky_show_related-post', 'srmp3_settings_sticky_player') == 'true' && !$all_category && $single_playlist){            
            $args =  array(
                'post_status'=> 'publish',
                'order' => 'DESC',
                'orderby' => 'date',
                'post_type'=> ( Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') != null ) ? Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') : SR_PLAYLIST_CPT,
                'posts_per_page' => $posts_per_pages
            ); 
            $get_podcastshow_terms = [];
            $get_playlistcat_terms = [];
           
            foreach ($album_ids as $value) {
                if( is_array( get_the_terms( $value, 'playlist-category' ) ) && get_the_terms( $value, 'playlist-category') ){
                    if (!in_array(get_the_terms( $value, 'playlist-category')[0]->term_id, $get_playlistcat_terms)){
                        array_push( $get_playlistcat_terms, get_the_terms( $value, 'playlist-category')[0]->term_id);
                    }
                    
                }

                if( is_array( get_the_terms( $value, 'podcast-show' ) ) && get_the_terms( $value, 'podcast-show') ){
                    if (!in_array(get_the_terms( $value, 'podcast-show')[0]->term_id, $get_podcastshow_terms)){
                        array_push( $get_podcastshow_terms, get_the_terms( $value, 'podcast-show')[0]->term_id);
                    }
                }
            }
            if($get_podcastshow_terms || $get_playlistcat_terms){
                $args['tax_query']= array();
                if( $get_podcastshow_terms && $get_playlistcat_terms ){
                    $args['tax_query'] = array('relation' => 'OR');
                }
                if($get_podcastshow_terms){
                    array_push($args['tax_query'] , array(
                        array(
                        'taxonomy' => 'podcast-show',
                        'field'    => 'id',
                        'terms'    =>  $get_podcastshow_terms
                        ),
                    ));
                }
                if($get_playlistcat_terms){
                    array_push($args['tax_query'], array(
                        array(
                        'taxonomy' => 'playlist-category',
                        'field'    => 'id',
                        'terms'    =>  $get_playlistcat_terms
                        ),
                    ));
                }
              }else{
                $args['post__in'] = $album_ids;
              }
        }else{
            $args = array(
                'posts_per_page' => $posts_per_pages,
                'post_type' => ( Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') != null ) ? Sonaar_Music::get_option('srmp3_posttypes', 'srmp3_settings_general') : SR_PLAYLIST_CPT,//array(SR_PLAYLIST_CPT, 'post', 'product'),
                'post__in' => $album_ids
            );
        }
        $albums = get_posts($args);
       

        if(Sonaar_Music::get_option('show_artist_name', 'srmp3_settings_general') ){
            $artistSeparator = (Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general') && Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general') != '' && Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general') != 'by' )?Sonaar_Music::get_option('artist_separator', 'srmp3_settings_general'): esc_html__('by', 'sonaar-music');
            $artistSeparator = ' ' . $artistSeparator . ' ';
        }else{
            $artistSeparator = '';
        }

        if( $feed == '1' ){
            //001. FEED = 1 MEANS ITS A FEED BUILT WITH ELEMENTOR AND USE TRACKS UPLOAD. IF A PREDEFINED PLAYLIST IS SET, GO TO 003. FEED = 1 VALUE IS SET IN THE SR-MUSIC-PLAYER.PHP
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                //__A. WE ARE IN EDITOR SO USE CURRENT POST META SOURCE TO UPDATE THE WIDGET LIVE OTHERWISE IT WONT UPDATE WITH LIVE DATA
                $album_tracks =  get_post_meta( $album_ids[0], 'srmp3_elementor_tracks', true);
                if($album_tracks == ''){
                    return;
                }   
            }else{
                //__B. WE ARE IN FRONT-END SO USE SAVED POST META SOURCE
                $elementorData = get_post_meta( $album_ids[0], '_elementor_data', true);
                $elementorData = (is_string($elementorData)) ? json_decode($elementorData, true) : ''; // make sure json_decode is parsing a string
                if(empty($elementorData)){
                    return;
                }
                
                $id = $el_widget_id;
                $results=[];

                $this->findData( $elementorData, $id, $results );

                $album_tracks = $results['settings']['feed_repeater'];

                $artwork = ( isset($results['settings']['album_img']['id'] ) && !empty($results['settings']['album_img']['id'] )) ? wp_get_attachment_image_src( $results['settings']['album_img']['id'], 'large' )[0] : '';
            }
        
            $num = 1;
            for($i = 0 ; $i < count($album_tracks) ; $i++) {

                $track_title = ( isset($album_tracks[$i]['feed_track_title'] )) ? $album_tracks[$i]['feed_track_title'] : false;
                $track_length = false;
                $album_title = false;

                if ( isset( $album_tracks[$i]['feed_track_img']['id'] ) && $album_tracks[$i]['feed_track_img']['id'] != ''){
                    $thumb_url = wp_get_attachment_image_src( $album_tracks[$i]['feed_track_img']['id'], 'large' )[0];
                    $thumb_id = $album_tracks[$i]['feed_track_img']['id'];
                }else{
                   $thumb_url = $artwork;
                }
                

                if( isset( $album_tracks[$i]['feed_source_file']['url'] ) ){
                    // TRACK SOURCE IS FROM MEDIA LIBRARY
                    $audioSrc = $album_tracks[$i]['feed_source_file']['url'];
                    $mp3_id = $album_tracks[$i]['feed_source_file']['id'];
                    $mp3_metadata = wp_get_attachment_metadata( $mp3_id );
                    $track_length = ( isset( $mp3_metadata['length_formatted'] ) && $mp3_metadata['length_formatted'] !== '' )? $mp3_metadata['length_formatted'] : false;
                    $album_title = ( isset( $mp3_metadata['album'] ) && $mp3_metadata['album'] !== '' )? $mp3_metadata['album'] : false;
                    $track_artist = ( isset( $mp3_metadata['artist'] ) && $mp3_metadata['artist'] !== '' && Sonaar_Music::get_option('show_artist_name', 'srmp3_settings_general') )? $mp3_metadata['artist'] : false;
                    $track_title = ( isset( $mp3_metadata["title"] ) && $mp3_metadata["title"] !== '' )? $mp3_metadata["title"] : false ;
                    //todo description below
                    if ( function_exists( 'run_sonaar_music_pro' ) ){
                        $media_post = get_post( $mp3_id );
                        $track_description = ( isset( $media_post->post_content ) && $media_post->post_content !== '' )? $media_post->post_content : false ;
                    }else{
                        $track_description = '';
                    }
                    $track_title = ( get_the_title( $mp3_id ) !== '' && $track_title !== get_the_title( $mp3_id ) ) ? get_the_title( $mp3_id ) : $track_title;
                    $track_title = html_entity_decode( $track_title, ENT_COMPAT, 'UTF-8' );


                }else if( isset( $album_tracks[$i]['feed_source_external_url']['url'] ) ){
                     // TRACK SOURCE IS AN EXTERNAL LINK
                    $audioSrc = $album_tracks[$i]['feed_source_external_url']['url'];
                }else{
                    $audioSrc = '';
                }
                $showLoading = true;

                ////////
                
                $album_tracks[$i] = array();
                $album_tracks[$i]["id"] = '';
                $album_tracks[$i]["mp3"] = $audioSrc;
                $album_tracks[$i]["loading"] = $showLoading;
                $album_tracks[$i]["track_title"] = ( $track_title )? $track_title : "Track ". $num;
                $album_tracks[$i]["track_artist"] = ( isset( $track_artist ) && $track_artist != '' )? $track_artist : '';
                $album_tracks[$i]["lenght"] = $track_length;
                $album_tracks[$i]["album_title"] = ( $album_title )? $album_title : '';
                $album_tracks[$i]["poster"] = ( $thumb_url )? urldecode($thumb_url) : null;
                if(isset($thumb_id)){
                    $album_tracks[$i]["track_image_id"] = $thumb_id;    
                }
                
                $album_tracks[$i]["release_date"] = false;
                $album_tracks[$i]["song_store_list"] ='';
                $album_tracks[$i]["has_song_store"] = false;
                $album_tracks[$i]['sourcePostID'] = null;
                $album_tracks[$i]['description'] = (isset($track_description)) ? $track_description : null;
                $thumb_id = null;
                $num++;
            }
                $tracks = array_merge($tracks, $album_tracks);

        }else if ( $feed && $feed != '1'){
            // 002. FEED MEANS SOURCE IS USED DIRECTLY IN THE SHORTCODE ATTRIBUTE
            $feed = $this->checkACF($feed, $albums);
            $feed_title = $this->checkACF($feed_title, $albums);
            $feed_img = $this->checkACF($feed_img, $albums);
            $artwork = $this->checkACF($artwork, $albums, false); 

            $thealbum = array();

            $feed_ar = explode('||', $feed);
            $feed_title_ar = explode('||', $feed_title);
            $feed_img_ar = explode('||', $feed_img);

            $thealbum = [$feed_ar];
            
            foreach($thealbum as $a) {
                $album_tracks = $feed_ar;
                $num = 1;
                for($i = 0 ; $i < count($feed_ar) ; $i++) {
                    $track_title = ( isset( $feed_title_ar[$i] )) ? $feed_title_ar[$i] : false;

                    if ( isset($feed_img_ar[$i]) ){
                        $thumb_url = $feed_img_ar[$i];
                    }else{
                       $thumb_url = $artwork;
                    }
                    
                    ////////
                    $audioSrc = $feed_ar[$i];
                    $showLoading = true;
                    ////////
                    $album_tracks[$i] = array();
                    $album_tracks[$i]["id"] = '';
                    $album_tracks[$i]["mp3"] = $audioSrc;
                    $album_tracks[$i]["loading"] = $showLoading;
                    $album_tracks[$i]["track_title"] = ( $track_title )? $track_title : "Track ". $num;
                    $album_tracks[$i]["track_artist"] = ( isset( $track_artist ) && $track_artist != '' )? $track_artist : '';
                    $album_tracks[$i]["lenght"] = false;
                    $album_tracks[$i]["album_title"] = '';
                    $album_tracks[$i]["poster"] = ( $thumb_url )? urldecode($thumb_url) : $artwork;
                    $album_tracks[$i]["release_date"] = false;
                    $album_tracks[$i]["song_store_list"] ='';
                    $album_tracks[$i]["has_song_store"] = false;
                    $album_tracks[$i]['sourcePostID'] = null;
                    $num++;
                }

                $tracks = array_merge($tracks, $album_tracks);
            }     
        } else {
            // 003. FEED SOURCE IS A POSTID -> ALB_TRACKLIST POST META

            foreach ( $albums as $a ) {
                $album_tracks =  get_post_meta( $a->ID, 'alb_tracklist', true);
                $wc_add_to_cart = $this->wc_add_to_cart($a->ID);
                $wc_buynow_bt =  $this->wc_buynow_bt($a->ID);
                $is_variable_product = ($wc_add_to_cart == 'true' || $wc_buynow_bt == 'true' ) ? $this->is_variable_product($a->ID) : '';
              
                if ( get_post_meta( $a->ID, 'reverse_post_tracklist', true) ){
                    $album_tracks = array_reverse($album_tracks); //reverse tracklist order POST option
                }
                
                if ($album_tracks!=''){ 
                    for($i = 0 ; $i < count($album_tracks) ; $i++) {

                       
                        $fileOrStream =  $album_tracks[$i]['FileOrStream'];
                        $thumb_id = get_post_thumbnail_id($a->ID);
                        if(isset($album_tracks[$i]["track_image_id"]) && $album_tracks[$i]["track_image_id"] != ''){
                            $thumb_id = $album_tracks[$i]["track_image_id"];
                        }
                        
                        $thumb_url = ( $thumb_id )? wp_get_attachment_image_src($thumb_id, Sonaar_Music::get_option('music_player_coverSize', 'srmp3_settings_widget_player'), true)[0] : false ;
                        if ($artwork){ //means artwork is set in the shortcode so prioritize this image instead of the the post featured image.
                            $thumb_url = $artwork;
                        }
                        //$store_array = array();
                        $track_title = false;
                        $album_title = false;
                        $mp3_id = false;
                        $media_post = false;
                        $track_description = false;
                        $audioSrc = '';
                        $song_store_list = isset($album_tracks[$i]["song_store_list"]) ? $album_tracks[$i]["song_store_list"] : '' ;
                        $album_store_list = ($wc_add_to_cart == 'true' || $wc_buynow_bt == 'true') ? $this->push_woocart_in_storelist($a, $is_variable_product, $wc_add_to_cart, $wc_buynow_bt) : false;
                        $has_song_store =false;
                        if (isset($song_store_list[0])){
                            $has_song_store = true; 
                        }
                        
                        $showLoading = false;
                        $track_length = false;

                        switch ($fileOrStream) {
                            case 'mp3':
                                if ( isset( $album_tracks[$i]["track_mp3"] ) ) {
                                    $mp3_id = $album_tracks[$i]["track_mp3_id"];
                                    $mp3_metadata = wp_get_attachment_metadata( $mp3_id );
                                    $track_title = ( isset( $mp3_metadata["title"] ) && $mp3_metadata["title"] !== '' )? $mp3_metadata["title"] : false ;
                                    $track_title = ( get_the_title($mp3_id) !== '' && $track_title !== get_the_title($mp3_id))? get_the_title($mp3_id): $track_title;
                                    $track_title = html_entity_decode($track_title, ENT_COMPAT, 'UTF-8');
                                    $track_artist = ( isset( $mp3_metadata['artist'] ) && $mp3_metadata['artist'] !== '' && Sonaar_Music::get_option('show_artist_name', 'srmp3_settings_general') )? $mp3_metadata['artist'] : false;
                                    $album_title = ( isset( $mp3_metadata['album'] ) && $mp3_metadata['album'] !== '' )? $mp3_metadata['album'] : false;
                                    $track_length = ( isset( $mp3_metadata['length_formatted'] ) && $mp3_metadata['length_formatted'] !== '' )? $mp3_metadata['length_formatted'] : false;
                                    $media_post = get_post( $mp3_id );
                                    $track_description = ( isset ($album_tracks[$i]["track_description"]) && $album_tracks[$i]["track_description"] !== '' )? $album_tracks[$i]["track_description"] : false;
                                    $audioSrc = wp_get_attachment_url($mp3_id);
                                    $showLoading = true;
                                }
                                break;

                            case 'stream':
                                
                                $audioSrc = ( array_key_exists ( "stream_link" , $album_tracks[$i] ) && $album_tracks[$i]["stream_link"] !== '' )? $album_tracks[$i]["stream_link"] : false;
                                $track_title = (  array_key_exists ( 'stream_title' , $album_tracks[$i] ) && $album_tracks[$i]["stream_title"] !== '' )? $album_tracks[$i]["stream_title"] : false;
                                $album_title = ( isset ($album_tracks[$i]["stream_album"]) && $album_tracks[$i]["stream_album"] !== '' )? $album_tracks[$i]["stream_album"] : false;
                                $showLoading = true;
                                $track_description = ( isset ($album_tracks[$i]["track_description"]) && $album_tracks[$i]["track_description"] !== '' )? $album_tracks[$i]["track_description"] : false;
                                $track_length = ( isset( $album_tracks[$i]["stream_lenght"] ) && $album_tracks[$i]["stream_lenght"] !== '' ) ? $album_tracks[$i]["stream_lenght"] : false;
                                break;
                            
                            default:
                                $album_tracks[$i] = array();
                                break;
                        }
                
                        $num = 1;
                       
                        $album_tracks[$i] = array();
                        $album_tracks[$i]["id"] = ( $mp3_id )? $mp3_id : '' ;
                        $album_tracks[$i]["mp3"] = $audioSrc;
                        $album_tracks[$i]["loading"] = $showLoading;
                        $album_tracks[$i]["track_title"] = ( $track_title )? $track_title : "Track ". $num++;
                        $album_tracks[$i]["track_artist"] = ( isset( $track_artist ) && $track_artist != '' )? $track_artist : '';
                        $album_tracks[$i]["lenght"] = $track_length;
                        $album_tracks[$i]["album_title"] = ( $album_title )? $album_title : $a->post_title;
                        $album_tracks[$i]["poster"] = urldecode($thumb_url);
                        if(isset($thumb_id)){
                            $album_tracks[$i]["track_image_id"] = $thumb_id;    
                        }
                        $album_tracks[$i]["release_date"] = get_post_meta($a->ID, 'alb_release_date', true);
                        $album_tracks[$i]["song_store_list"] = $song_store_list;
                        $album_tracks[$i]["has_song_store"] = $has_song_store;
                        $album_tracks[$i]["album_store_list"] = $album_store_list;
                        $album_tracks[$i]['sourcePostID'] = $a->ID;
                        $album_tracks[$i]['description'] = (isset($track_description)) ? $track_description : null;
                        $thumb_id = null;
                    
                    }
            
                    $tracks = array_merge($tracks, $album_tracks);

                }

            }
            if( $reverse_tracklist ){
                $tracks = array_reverse($tracks); //reverse tracklist order option
            }
        }
        $playlist['playlist_name'] = $title;
        if ( empty($playlist['playlist_name']) ) $playlist['playlist_name'] = "";

        $playlist['artist_separator'] = $artistSeparator;

        $playlist['tracks'] = $tracks;
        if ( empty($playlist['tracks']) ) $playlist['tracks'] = array();
        return $playlist;

    }

}