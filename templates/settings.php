<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<div class="gn-container">
		<img  class="gn-logo" src=<?php echo GNPUB_URL . '/icon.png' ?> />
		<h1><?php _e( '<b>GN</b> Publisher', 'gn-publisher' ); ?></h1>
	</div>
<?php // don't think we need this anymore, let's test without, but leave in code for now in case
	//it needs to be reenabled - ca (11/29/2020)
/*
	<form action="" method="post">

		<table class="form-table">

			<tr>
				<th><?php _e( 'Include the featured image for a post in the feed', 'gn-publisher' ); ?></th>
				<td>
					<input type="checkbox" name="gnpub_include_featured_image" id="gnpub_include_featured_image" <?php checked( $include_featured_image, true ); ?> value="1" />
					<label for="gnpub_include_featured_image"><?php _e( 'Include featured image', 'gn-publisher' ); ?></label>
					<p class="description"><?php _e( 'Deactivate this option if images in the Publisher Center appear twice in your articles.', 'gn-publisher' ); ?></p>
				</td>
			</tr>

		</table>

		<p class="submit">
			<?php wp_nonce_field( 'save_gnpub_settings', '_wpnonce' ); ?>
			<input type="submit" name="save_gnpub_settings" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'gn-publisher' ); ?>" />
		</p>

	</form>
*/ ?>
	<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Intro')" id="defaultOpen">Intro</button>
  <button class="tablinks" onclick="openCity(event, 'google_feed')">Google News Feed</button>
  <button class="tablinks" onclick="openCity(event, 'Troubleshooting')">Troubleshooting</button>
  <button class="tablinks" onclick="openCity(event, 'Help')">Help</button>
  
</div>

<div id="Intro" class="tabcontent">
   
  <p><?php
			printf(
				__( 'Hi,</p><p style="font-size:110%%;"> I\'m Chris Andrews, a Platinum Level Product Expert on the <a href="%1$s">Google News Publisher Help forum</a>, the creator of <a href="%2$s">GN Publisher</a>, and the owner of <a href="%3$s">Andrews Consulting</a>.</p>', 'gn-publisher' ),
				'https://support.google.com/news/publisher-center/community?hl=en',
				'https://wordpress.org/plugins/gn-publisher/',
				'https://andrews.com'
			);
	?></p>

	<p><?php
			printf(
				__( 'GN Publisher is a WordPress plugin designed to output RSS feeds that comply with the <a href="%1$s">Google News RSS Feed Technical Requirements</a> for inclusion in the <a href="%2$s">Google News Publisher Center</a>.', 'gn-publisher' ),
				'https://support.google.com/news/publisher-center/answer/9545420?hl=en',
				'https://publishercenter.google.com/'
			);
	?></p>

	<p><?php _e( 'The plugin addresses common issues publishers experience when using the Google News Publisher Center, including:', 'gn-publisher' ); ?></p>
 
		<ul style="list-style-type:circle;padding-left: 40px;">
			<li><?php _e( 'Incomplete articles', 'gn-publisher' ); ?></li>
			<li><?php _e( 'Duplicate images', 'gn-publisher' ); ?></li>
			<li><?php _e( 'Missing images or media', 'gn-publisher' ); ?></li>
			<li><?php _e( 'Missing content (usually social media/Instagram embeds)', 'gn-publisher' ); ?></li>
			<li><?php _e( 'Title errors (missing or repeated title)', 'gn-publisher' ); ?></li>
			<li><?php _e( 'Cached RSS feeds causing slow updating', 'gn-publisher' ); ?></li>
			<li><?php _e( 'Delayed crawling by Google', 'gn-publisher' ); ?></li>
		</ul>
</div>

<div id="google_feed" class="tabcontent">
   
   <p><?php _e( 'Once installed and activated, you can find your GN Publisher RSS feeds at:', 'gn-publisher' ); ?></p>

		<ul style="padding-left:40px">
 		<?php 

	/////// display feed urls, @since 1.0.2 -ca ///////////////////
			$permalinks_enabled = ! empty( get_option( 'permalink_structure' ) );

			echo '<li>' . esc_url( $permalinks_enabled ? trailingslashit( site_url() ) . 'feed/gn' : add_query_arg( 'feed', 'gn', site_url() ) ) . '</li>';
			
			$categories = get_categories(); 
			foreach( $categories as $category ) {
				$gn_category_link = get_category_link( $category->term_id );
				$gn_category_link = $permalinks_enabled ? trailingslashit( $gn_category_link ) . 'feed/gn' : add_query_arg( 'feed', 'gn', $gn_category_link );
				echo '<li>' . esc_url( $gn_category_link ) . '</li>';
			} 
 		?>
		</ul>

	<p><?php _e( 'You are not required to use all of the feeds listed above. Just use the ones you want to include in your Publisher Center. Each feed will contain the thirty most recently updated articles in its category.', 'gn-publisher' ); ?></p>

	<p><?php _e( 'When setting up a new section in the Publisher Center, I recommend setting it up as a "Feed". For the "Feed options", select "Generate articles from feed". Under "Rendering preference", select "Use website or AMP". If you have AMP on your site, the Publisher Center will render the AMP version. If you do not have AMP available, the Publisher Center will usually generate your articles from the feed.', 'gn-publisher' ); ?></p>

	<p><?php _e( 'Be sure to click that blue "Save" button in the upper right hand corner of the Publisher Center to save your changes (it\'s surprisingly easy to miss). After saving, wait ten minutes for Google to fetch your feed and render your articles. Then reload the entire page using your browser\'s reload/refresh button before checking to see if your articles appear in the Publisher Center.', 'gn-publisher' ); ?></p>

	<p><?php _e( 'After the initial setup, GN Publisher will ping Google with an alert each time your feed is updated.', 'gn-publisher' ); ?></p>

</div>

<div id="Troubleshooting" class="tabcontent">

<div class="menu">
    <div class="question">
      <input type="checkbox" id="type1" class="accordion">
      <label for="type1">
        There are no articles in this section
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links1">
        <li>
          <p><?php _e( 'If you are getting the dreaded "There are no articles in this section" message in the Publisher Center:', 'gn-publisher' ); ?></p>
           <p><?php _e( 'Refresh the section in the Publisher Center. Wait 10 to 15 minutes, then reload the entire page using your browser\'s "reload" button and recheck to see if articles appear.', 'gn-publisher' ); ?></p>
        </li>
      </ul>
    </div>
    <div class="question">
      <input type="checkbox" id="type2" class="accordion">
      <label for="type2">
        Refreshed the page but again the same result
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links2">
        <li>
          <p><?php _e( 'If you\'ve refreshed the page in the Publisher Center and continue to get the same results, visit the URL you entered for the section and make sure there are articles included in the feed.', 'gn-publisher' ); ?></p>
           <p><?php _e( 'If you get a 404 or "missing" page when visiting the feed url, please review the notes in the "feed urls" section above and If there are no articles in the feed, please make sure there are articles published in that section (category) within the last 30 days.', 'gn-publisher' ); ?></p>
        </li>
      </ul>
    </div>
    <div class="question">
      <input type="checkbox" id="type3" class="accordion">
      <label for="type3">
        If the url works then what to do
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links3">
        <li>
         <p><?php _e( '➔ Most Recent Feedfetcher Fetch: None recorded. (if testing, refresh this page for most recent fetch time)<br/>&#8226; If the "Most Recent Feedfetcher fetch" is "None recorded" or the date is more than 24 hours old, it\'s likely that your host or firewall is blocking Google\'s feed crawler, Feedfetcher. Because Feedfetcher is not a well-known bot and doesn\'t follow some of the standard crawler procedures, it is often mistakenly blocked by hosting companies and firewalls. Ask your hosting company or server administrator to whitelist the user-agent "Feedfetcher-Google". Note: If you are using AWS Cloudfront, Amazon does not pass the user-agent through to GN Publisher, so the "Most Recent Feedfetcher Fetch" timestamp will not work for you.', 'gn-publisher' ); ?></p>
<p><?php _e( '➔ Most Recent Update Ping Sent: None recorded. (if testing, refresh this page for most recent ping time)<br/>&#8226; When you publish or update a post, GN Publisher pings Google to let them know there is an update to one of your feeds. The "Most Recent Update Ping" indicates when the most recent ping was sent. Google normally fetches the feed soon thereafter (often within a minute).
', 'gn-publisher' ); ?></p>
        </li>
      </ul>
    </div>
    <div class="question">
      <input type="checkbox" id="type4" class="accordion">
      <label for="type4">
        How to run RSS Feed Validator
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links4">
        <li>
          <p><?php _e( '➔ The validator may validate but warn about iframe and script tags - those are okay for our purposes.<br/>
➔ If the validator does not validate, or validates but warns of "invalid html" (for example, a "missing p tag"), those issues can cause the crawler to not accept the feed. These errors are sometimes caused by poorly coded themes or plugins and require further investigation to correct. The p tag issue is a common one that is often caused by a figure tag or blockquote tag (or other block level element) being inside a paragraph, which is not valid html.<br/>
➔ If some Publisher Center sections are being fetched okay and others are reporting "no articles" - it\'s likely an html error that is included in an article on the specific feed that isn\'t loading properly in the Publisher Center.', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
    <div class="question">
      <input type="checkbox" id="type5" class="accordion">
      <label for="type5">
        Missing Images 
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links5">
        <li>
          <p><?php _e( 'The Publisher Center requires that large images be used as the featured image - at least 800px on the shortest side. GN Publisher will try to use your original image, which is generally the largest. If you upload a featured image that is smaller than 800px on its shortest side, it might not appear with the article in the Publisher Center.<br/>Note - the Publisher Center preview pane can only display .jpg and .png image files. If you are using a CDN like CloudFlare or KeyCDN, even if you have the images set up correctly, the CDN may serve them as WebP files. That will cause the images to not be displayed, or be displayed inconsistently, in the preview pane. If you are experiencing this, go the the "Review and Publish" tab in the Publisher Center, subscribe to your publication if you haven\'t already, and then click on link for your publication and make sure the images are displayed correctly there. If they are displayed on your publication in Google News, you can ignore them not being in the preview pane.

', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
    <div class="question">
      <input type="checkbox" id="type6" class="accordion">
      <label for="type6">
        Missing Media
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links6">
        <li>
          <p><?php _e( 'Social media embeds that are included in your articles should also appear as part of the article in your Publisher Center. GN Publisher is designed to properly adjust the embeds for use in the Publisher Center. If your embeds don\'t appear as they should, please contact me through the GN Publisher support forum on WordPress.org', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
    <div class="question">
      <input type="checkbox" id="type7" class="accordion">
      <label for="type7">
        General Info
        <div id="icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links7">
        <li>
          <p><?php _e( '➔ Be aware that Google has certain Content Policies for sites included on Google News properties. More information about applying is available on the Google News Publisher Help Center.<br/>

➔ You\'ll need to meet additional requirements in the Publisher Center, such as verifying your domain, selecting an appropriate publication name, and setting up your logos correctly.<br/>

➔ Because of the huge number of ways that publishers, plugins, and themes can manipulate WordPress posts, I can\'t guarantee that this plugin will result in the technical requirements being met.

', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
  </div>
</div>

<div id="Help" class="tabcontent">
   
 <p style="font-size:15px;padding-left:10px;">&#8211;  <?php _e( 'Free', 'gn-publisher' ); ?></p>

		<p><?php
			printf(
				__( 'If you need help with the GN Publisher plugin or anything related to the RSS feeds that are created, please ask on the official <a href="%1$s">WordPress GN Publisher plugin support forum</a>.', 'gn-publisher' ),
				'https://wordpress.org/support/plugin/gn-publisher/'
			);
		?></p>

	<p><?php
			printf(
				__( 'If you need general help as a Google News publisher, or help with the Google News Publisher Center, please ask for help in the official <a href="%1$s">Google News Publisher Help Forum</a>. I or some of the other regulars on the forum will try to help.', 'gn-publisher' ),
				'https://support.google.com/news/publisher-center/threads?hl=en'
			);
		?></p>

	<p><?php
			printf(
				__( 'You can also find help on my <a href="%1$s">YouTube channel</a>.', 'gn-publisher' ),
				'http://www.youtube.com/c/ChrisAndrews1'
			);
	?></p>

		<p style="font-size:15px;padding-left:10px;">&#8211;  <?php _e( 'Private Consulting', 'gn-publisher' ); ?></p>

	<p><?php _e( 'I work with a small number of news publishers on a year-round basis. My consulting focuses on discoverability and optimization for surfacing on Google News, Newsstand, Top Stories, Discover, Articles for You, and other Google related (and emerging) properties. Consultations include regular technical SEO audits, advice on content and readership development, a quarterly newsletter with advice, recommendations and updates on what\'s going on with Google News and related properties and how to best use them to gain more exposure.', 'gn-publisher' ); ?></p>
</div>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
</div>
