<?php
add_filter( "the_content_feed", "gnpub_feed_content_function" );
add_filter('the_excerpt_rss', 'gnpub_feed_content_function');
/**
* @param  $content Content of post
* @return string
*/
function gnpub_feed_content_function($content)
{
    $default_options   = array('gnpub_enable_copy_protection'=>false,'gnpub_show_upto_value'=>1,'gnpub_show_upto_unit'=>'paragraph');
    $gnpub_options     = get_option( 'gnpub_new_options', $default_options );

    $gnpub_enable_copy_protection = $gnpub_options['gnpub_enable_copy_protection'];
    $gnpub_show_upto_value 		  = intval($gnpub_options['gnpub_show_upto_value']);
    $gnpub_show_upto_unit 		  = $gnpub_options['gnpub_show_upto_unit'];
    $is_admin_user                = current_user_can('administrator');

    if($gnpub_enable_copy_protection && (!$is_admin_user || !gnpub_check_useragent()))
    {
        if(!$content){
            return $content;
        }

        if($gnpub_show_upto_unit=='paragraph')
        {
            $tmp_content = explode ('</p>', $content);
            if($content && $tmp_content && count($tmp_content)>=$gnpub_show_upto_value)
            {
                $tmp_content_2 = array_slice($tmp_content,0,$gnpub_show_upto_value );
                return implode('</p>',$tmp_content_2).'</p>';
            }
            else
            {
                return wp_trim_words($content,25,''); // if there are no paragraph in post then display only 25 words
            }
        }
        else if($gnpub_show_upto_unit=='word')
        {
			 return wp_trim_words($content,$gnpub_show_upto_value ,'');
        }
        else if($gnpub_show_upto_unit=='character')
        {
            return substr($content, 0,$gnpub_show_upto_value);
        }

        else{
            return wp_trim_words($content,25,''); // if no condition are met then display only 25 words
        }

    }
    return $content;
}


function gnpub_check_useragent()
{

    $allowed_useragent=[
                        'APIs-Google',
                        'AdsBot-Google-Mobile',
                        'AdsBot-Google-Mobile',
                        'AdsBot-Google',
                        'Mediapartners-Google',
                        'Googlebot-Image',
                        'Googlebot',
                        'Googlebot-News',
                        'Googlebot-Video',
                        'Mediapartners-Google',
                        'AdsBot-Google-Mobile-Apps',
                        'FeedFetcher-Google',
                        'Google-Read-Aloud',
                        'DuplexWeb-Google',
                        'googleweblight',
                        'Storebot-Google' 
    ];

    $agent = $_SERVER["HTTP_USER_AGENT"];

    if(isset($agent) && !empty($agent))
    {
        foreach($allowed_useragent as $useragent)
        {
            if( preg_match('/'.$useragent.'/', $agent) )
            {
                return true;
            }    
        }

    }
    return false;
}