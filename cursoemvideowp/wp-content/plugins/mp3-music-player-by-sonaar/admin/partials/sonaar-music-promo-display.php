<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       sonaar.io
 * @since      1.0.0
 *
 * @package    Sonaar_Music
 * @subpackage Sonaar_Music/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="sonaar_music">
  <b-jumbotron class="text-center" bg-variant="dark" text-variant="white">
  <div class="logo"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../img/sonaar-music-logo-white.png')?>"></div>
  <div class="headertxt">
    <h1>Why MP3 Player Pro</h1>
    <div><p class="text-center tagline">Stunning Sticky Player. Full Support for Elementor Page Builder & WooCommerce. Useful Statistic delivered directly in your dashboard ! It's the most advanced Audio Player plugin for WordPress. </p></div>
  </div>
  	</b-jumbotron>

	<b-card-group deck>
		<b-card 
				title="Features you get with Pro version"
				bg-variant="dark"
				text-variant="white"
		        img-alt="Image"
		        img-top
		        tag="article"
		        class="text-center">
		        <div class="sr_it_listgroup">
					<ul>
						<li>Sticky footer audio player with soundwave​</li>
						<li>Continuous audio playback / persistent player</li>
						<li>Keep your RSS Feed and Podcast Show synched with your current Podcast distributor to get new episodes automatically</li>
						<li>15 seconds / 30 seconds episode skip button</li>
						<li>Display playlist from specific categories instead of adding them one by one.</li>
						<li>Volume Control</li>
						<li>Playback Speed and Speed Rate control</li>
						<li>Show track description for each track</li>
						<li>Show Podcast Notes for each episode</li>
						<li>Show published dates for each posts and tracks</li>
						<li>Show number of tracks for each playlist</li>
						<li>Show total time duration for each playlist</li>
						<li>Full WooCommerce support</li>
						<li>Elementor widget with 70+ styling options​</li>
						<li>Display thumbnnail images beside each tracks</li>
						<li>Tool to bulk import/create playlist​</li>
						<li>Statistic reports for admin (listen counts, top chart, etc.)</li>
						<li>Get insights reports directly in your dashboard.</li>
						<li>Stunning charts with numbers of plays filtered by days, weeks and months.</li>
						<li>Volume control​</li>
						<li>Shuffle tracks</li>
						<li>Scrollbar options within tracklist</li>
						<li>Option to automatically stop player when track is complete</li>
						<li>1 year of premium support via live chat</li>
						<li>1 year of automatic updates</li>
			         </ul>
		      	</div>
		      	

		        <em slot="footer"><div><a role="button" class="btn btn-primary btn-lg" href="https://sonaar.io/free-mp3-music-player-plugin-for-wordpress/?utm_source=Sonaar+Music+Free+Plugin&utm_medium=plugin">Learn More</a></div></em>
		    	
		</b-card>
	</b-card-group deck>
</div>
