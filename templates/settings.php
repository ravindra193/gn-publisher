<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<div class="gn-container">
  
		<h1><a href="https://gnpublisher.com/" target="_blank"><img  class="gn-logo" src=<?php echo GNPUB_URL . '/assets/images/logo.png' ?> title="<?php _e( '<b>GN</b> Publisher', 'gn-publisher' ); ?>"/></a></h1>
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
*/ 
?>
	<div class="gn-tab">
  <button class="gn-tablinks" onclick="openTab(event, 'gn-intro')" id="defaultOpen">Dashboard</button>
  <button class="gn-tablinks" onclick="openTab(event, 'gn-google-feed')" id="gn-feed">Google News Feed Setup</button>
  <button class="gn-tablinks" onclick="openTab(event, 'gn-troubleshooting')">Troubleshooting</button>
  <button class="gn-tablinks" onclick="openTab(event, 'gn-help')">Help &amp; Support</button>
  <button class="gn-tablinks" onclick="openTab(event, 'gn-services')">Services</button>
  
</div>

<div id="gn-intro" class="gn-tabcontent">
   
  <p><?php
			printf(
				__( '<p> This plugin was created by Chris Andrews, a Platinum Level Product Expert on the Google News Publisher Help forum, the original creator of <a href="%1$s" target="_blank">GN Publisher</a>.</p>', 'gn-publisher' ),
				'https://gnpublisher.com/'
			);
	?></p>

	<p><?php
			printf(
				__( 'GN Publisher is a WordPress plugin designed to output RSS feeds that comply with the <a href="%1$s" target="_blank">Google News RSS Feed Technical Requirements</a> for inclusion in the <a href="%2$s" target="_blank">Google News Publisher Center</a>.', 'gn-publisher' ),
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

<div id="gn-google-feed" class="gn-tabcontent">
   
   <p><?php _e( 'Once installed and activated, you can find your GN Publisher RSS feeds at:', 'gn-publisher' ); ?></p>

		<ul>
 		<?php 

	/////// display feed urls, @since 1.0.2 -ca ///////////////////
			$permalinks_enabled = ! empty( get_option( 'permalink_structure' ) );
      $feed_url=esc_url( $permalinks_enabled ? trailingslashit( home_url() ) . 'feed/gn' : add_query_arg( 'feed', 'gn', home_url() ) );
			echo '<li><input type="text" class="gn-input" value="'.$feed_url.'" id="gn-feed" size="60" readonly>
      <div class="gn-tooltip">
      <button class="gn-btn" onclick="gn_copy('."'gn-feed'".')" onmouseout="gn_out('."'gn-feed'".')">
        <span class="gn-tooltiptext" id="gn-feed-tooltip">Copy URL</span>
        Copy
        </button>
      </div></li>';
			
			$categories = get_categories(); 
			foreach( $categories as $category ) {
				$gn_category_link = get_category_link( $category->term_id );
				$gn_category_link = $permalinks_enabled ? trailingslashit( $gn_category_link ) . 'feed/gn' : add_query_arg( 'feed', 'gn', $gn_category_link );
        echo '<li><input type="text" class="gn-input" value="'.esc_url( $gn_category_link ).'" id="gn-feed-'.$category->term_id.'" size="60" readonly>
      <div class="gn-tooltip">
      <button class="gn-btn" onclick="gn_copy('."'gn-feed-".$category->term_id."'".')" onmouseout="gn_out('."'gn-feed-".$category->term_id."'".')">
        <span class="gn-tooltiptext" id="gn-feed-'.$category->term_id.'-tooltip">Copy URL</span>
        Copy
        </button>
      </div></li>';
			
			} 
 		?>
		</ul>

	<?php if(!defined('GNPUB_PRO_VERSION')){ ?>
    <p>
    <table class="form-table">
      <tr>
        <th><?php _e( 'Feed Content Protection', 'gn-publisher' ); ?></th>
        <td>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/downloads/gnpublisher-pro/">Upgrade to Premium</a>
        </td>
      </tr>
      </table>
      </p>
  <?php } else { 
     do_action('gnpub_pro_setup_form');
    
    } ?>



<p><?php _e( 'You are not required to use all of the feeds listed above. Just use the ones you want to include in your Publisher Center. Each feed will contain the thirty most recently updated articles in its category.', 'gn-publisher' ); ?></p>

	<p><?php _e( 'When setting up a new section in the Publisher Center, I recommend setting it up as a "Feed". For the "Feed options", select "Generate articles from feed". Under "Rendering preference", select "Use website or AMP". If you have AMP on your site, the Publisher Center will render the AMP version. If you do not have AMP available, the Publisher Center will usually generate your articles from the feed.', 'gn-publisher' ); ?></p>

	<p><?php _e( 'Be sure to click that blue "Save" button in the upper right hand corner of the Publisher Center to save your changes (it\'s surprisingly easy to miss). After saving, wait ten minutes for Google to fetch your feed and render your articles. Then reload the entire page using your browser\'s reload/refresh button before checking to see if your articles appear in the Publisher Center.', 'gn-publisher' ); ?></p>

	<p><?php _e( 'After the initial setup, GN Publisher will ping Google with an alert each time your feed is updated.', 'gn-publisher' ); ?></p>

</div>

<div id="gn-troubleshooting" class="gn-tabcontent">

<div class="gn-menu">
    <div class="gn-question">
      <input type="checkbox" id="type1" class="gn-accordion">
      <label for="type1">
        There are no articles in this section
        <div class="gn-icon">
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
    <div class="gn-question">
      <input type="checkbox" id="type2" class="gn-accordion">
      <label for="type2">
        Refreshed the page but again the same result
        <div class="gn-icon">
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
    <div class="gn-question">
      <input type="checkbox" id="type3" class="gn-accordion">
      <label for="type3">
        If the url works then what to do
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links3">
        <li>
          <?php $last_fetch=( is_null( $last_google_fetch ) ) ? __( 'None recorded.', 'gn-publisher' ) : $last_google_fetch;
         $last_websub_ping = ( is_null( $last_websub_ping ) ) ? __( 'None recorded.', 'gn-publisher' ) : $last_websub_ping; 
          ?>
         <p><?php _e( '➔ <b>Most Recent Feedfetcher Fetch: '.$last_fetch.' (if testing, refresh this page for most recent fetch time)</b><br/>&#8226; If the "Most Recent Feedfetcher fetch" is "None recorded" or the date is more than 24 hours old, it\'s likely that your host or firewall is blocking Google\'s feed crawler, Feedfetcher. Because Feedfetcher is not a well-known bot and doesn\'t follow some of the standard crawler procedures, it is often mistakenly blocked by hosting companies and firewalls. Ask your hosting company or server administrator to whitelist the user-agent "Feedfetcher-Google". Note: If you are using AWS Cloudfront, Amazon does not pass the user-agent through to GN Publisher, so the "Most Recent Feedfetcher Fetch" timestamp will not work for you.', 'gn-publisher' ); ?></p>
<p><?php _e( '➔ <b>Most Recent Update Ping Sent: '.$last_websub_ping.' (if testing, refresh this page for most recent ping time)</b><br/>&#8226; When you publish or update a post, GN Publisher pings Google to let them know there is an update to one of your feeds. The "Most Recent Update Ping" indicates when the most recent ping was sent. Google normally fetches the feed soon thereafter (often within a minute).
', 'gn-publisher' ); ?></p>
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type4" class="gn-accordion">
      <label for="type4">
        How to run RSS Feed Validator
        <div class="gn-icon">
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
    <div class="gn-question">
      <input type="checkbox" id="type5" class="gn-accordion">
      <label for="type5">
        Missing Images 
        <div class="gn-icon">
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
    <div class="gn-question">
      <input type="checkbox" id="type6" class="gn-accordion">
      <label for="type6">
        Missing Media
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links6">
        <li>
          <p><?php _e( 'Social media embeds that are included in your articles should also appear as part of the article in your Publisher Center. GN Publisher is designed to properly adjust the embeds for use in the Publisher Center. If your embeds don\'t appear as they should, please contact me through the GN Publisher support forum on WordPress.org', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type7" class="gn-accordion">
      <label for="type7">
        General Info
        <div class="gn-icon">
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

  <p>If the above information does not seems to help you can also contact us from  <a href="https://gnpublisher.com/contact-us/" target="_ blank">https://gnpublisher.com/contact-us</a></p>
</div>

<div id="gn-help" class="gn-tabcontent ">
<div class="gn-flex-container">
<div class="gn-left-side">
<p>We are dedicated to provide Technical support &amp; Help to our users. Use the below form for sending your questions. </p>
<p>You can also contact us from <a href="https://gnpublisher.com/contact-us/" target="_blank">https://gnpublisher.com/contact-us/</a>.</p>

<div class="gn_support_div_form" id="technical-form">
            <ul>
                <li>
                  <label class="gn-support-label">Email<span class="gn-star-mark">*</span></label>
                   <div class="support-input">
                   		
                   		<input type="text" id="gn_query_email" name="gn_query_email" size="47" placeholder="Enter your Email" required="">
                   </div>
                </li>
                
                <li>
                    <label class="gn-support-label">Query<span class="gn-star-mark">*</span></label>                    
                   
                    <div class="support-input"><textarea rows="5" cols="50" id="gn_query_message" name="gn_query_message" placeholder="Write your query"></textarea>
                    </div>
                
                  
                </li>
                
                <li><button class="button button-primary gn-send-query">Send Support Request</button></li>
            </ul>            
                
             
            <div class="clear"> </div>
                    <span class="gn-query-success gn-result gn-hide">Message sent successfully, Please wait we will get back to you shortly</span>
                    <span class="gn-query-error gn-result gn-hide">Message not sent. please check your network connection</span>
            </div>
</div>

<div class="gn-right-side">
<div class="gn-bio-box" id="gn_Bio">
                <h1>Vision &amp; Mission</h1>
                <p class="gn-p">We strive to provide the Google News Publisher in the world.</p>
              <p class="gn_boxdesk"> Delivering a good user experience means a lot to us, so we try our best to reply each and every question.</p>
           </div>
</div>


  </div>
 
  

	
</div>
<div id="gn-services" class="gn-tabcontent">
<div class="gn-flex-container-services">
  <div class="gn-service-card" data-url="https://gnpublisher.com/services/google-news-setup-audit-service/">
    <div class="gn-service-card-left">
    <img src="<?php echo GNPUB_URL . '/assets/images/google-news.png'?>" width="128px" height="128px">
  </div>
  <div class="gn-service-card-right">
    <h3 class="gn-service-heading">Google News Setup & Audit</h3>
  <p>You can get thousands of clicks to your site from Google News. We can set up Google news for your website and perform regular audits.</p>
  <a target="_blank" href="https://gnpublisher.com/services/google-news-setup-audit-service/#pricing" class="gn-btn-primary button button-primary">View Pricing</a><a href="https://gnpublisher.com/services/google-news-setup-audit-service/" target="_blank" class="gn-btn gn-btn-learnmore button">Learn More</a>
  </div>
  </div>
  <div class="gn-service-card" data-url="https://gnpublisher.com/services/dedicated-developer-for-website-search-console-maintenance-service/">
  <div class="gn-service-card-left">
  <img src="<?php echo GNPUB_URL . '/assets/images/support.png'?>" width="128px" height="128px">
  </div>
  <div class="gn-service-card-right">
    <h3 class="gn-service-heading">Dedicated Developer for Website</h3>
  <p>Our dedicated developers will continuously monitor your website and make sure its up and running without any issue.</p>
  <a target="_blank" href="https://gnpublisher.com/services/dedicated-developer-for-website-search-console-maintenance-service/#pricing" class="gn-btn-primary button button-primary">View Pricing</a><a href="https://gnpublisher.com/services/dedicated-developer-for-website-search-console-maintenance-service/" target="_blank" class="gn-btn gn-btn-learnmore button">Learn More</a>
  </div>
  </div>
  
  <div class="gn-service-card" data-url="https://gnpublisher.com/services/search-console-maintenance-service/">
  <div class="gn-service-card-left">
  <img src="<?php echo GNPUB_URL . '/assets/images/google.png'?>" width="128px" height="128px">
  </div>
  <div class="gn-service-card-right">
    <h3 class="gn-service-heading">Search Console
Maintenance</h3>
<p>  We will manage your all Google Search Console problems because even after a webpage gets indexed, issues can happen.</p>
<a target="_blank" href="https://gnpublisher.com/services/search-console-maintenance-service/#pricing" class="gn-btn-primary button button-primary">View Pricing</a><a href="https://gnpublisher.com/services/search-console-maintenance-service/" target="_blank" class="gn-btn gn-btn-learnmore button">Learn More</a>
  </div>
  </div>
 
  </div>
  </div>
</div>
