<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/helpers
 *	file 			- feedprocess.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

Class HelperFeedProcess{

//This is the core file to parse the feed 
//several functions are written to parse url
// it can extract video/images/music
//This is the jquery code for the FEEDPOST application
//@Author Krishna Teja G S
//@Email shaadomanthra@yahoo.com
//@Website www.krishnateja.in

	public function process($feed){
		
		$arr = $this->url_extractor($feed);
		$string = $arr['string'];
		$links = $arr['matches'];
		//$string = explode(" ", $feed);
		$single="";
		$feed_type = 'text';
		//check each piece of Feed
		$last_url = null;
		if($links){
			$last_url=$links[count($links)-1];
			$word = $this->_httpsRemove($last_url);
			$obj=$this->validateUrl($word);
			$feed_new = $obj->feed_container;
			$feed_type = $obj->feed_type;
		}

		/*
		 foreach($links as $a => $link)
		 {
			$word=$string[$i];	
			if($this->isUrl($word))
			{
				$word = $this->_httpsRemove($word);\
				$obj=$this->validateUrl($word);
				$feed_new = $obj->feed_container;
				$feed_type = $obj->feed_type;
				$word=$this->urlToLink($word);
			}
			$single=$single." ".$word;
			
		 }
		 */
		 $feedObj = new stdclass();
		 $feedObj->feed = $string;
		 $feedObj->feed_url = $last_url;
		 $feedObj->feed_type = $feed_type;

		 if(isset($feed_new))
			$feedObj->feed_container= '<div class="feed-info-box">'.$feed_new.'</div>';
		else
			$feedObj->feed_container = null;
		
		return $feedObj;
	}

	public function markUp($feedObj){
		if(!isset($feedObj->feed_container))
			$feedObj->feed_container=null;
		$feed = $feedObj->feed.$feedObj->feed_container;
		return $feed;	
	}

	public function ago($datetime, $full = false){
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
	


	public function url_extractor($text){
		   $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,5}(\/\S*)?/";
            preg_match_all($reg_exUrl, $text, $matches);
            $usedPatterns = array();
            foreach($matches[0] as $pattern){
                if(!array_key_exists($pattern, $usedPatterns)){
                    $usedPatterns[$pattern]=true;
                    $text = str_replace  ($pattern, '<a href='.$pattern.' rel="nofollow" class="feed-link" target="_blank">'.$pattern.'</a> ', $text);   
                }
            }

            $result = array();
            if(isset($matches[0]))
            	$result['matches'] = $matches[0];
        	else
        		$result['matches'] = 0;	
			$result['string'] = $text;
            return $result; 
	}

	public function isUrl($feed)
	{
		if(preg_match('@^https?://@',$feed))
			return true;
		else
			return false;
	}
	
	public function validateUrl($feed)
	{
			$obj =  new stdclass();
			$feed_type='text';
			$url=$feed;
			$feed_container =null;
			//check if the url is valid or not
			if($this->isValidUrl($url)==true)
			{
				//check if the url is a video or image or music
				//then store it in $element variable
				if($this->_isUrlVideo($url))
				{
					$feed_type = 'video';
					$element=$this->_isUrlVideo($url);	
				}
				elseif($this->_isUrlImage($url)){
					$feed_type = 'photo';
					$element=$this->_isUrlImage($url);
				}
				else{
					$feed_type='link';
					$url_info= $this->_urlInfo($url);
				}
				
				if(isset($element)&&isset($url_info))
					$feed_container= $element.$url_info; 	
				elseif(isset($element))
					$feed_container=  $element;
				elseif(isset($url_info))
					$feed_container=  $url_info;
			}
			else
				$feed_container= null;
			$obj->feed_container =$feed_container;
			$obj->feed_type = $feed_type;
			return $obj;

	}
	
	
	public function _isUrlVideo($url)
	{	

		//Checks if the Video is of youtube 
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) 
		{
			$video_id = $match[1];
			$youtube= str_replace($url,'<div class="video-container">
				<iframe width="500" height="300" 
				src="//www.youtube.com/embed/'.$video_id.'?autohide=1" frameborder="0" allowfullscreen></iframe>
				</div>',$url);
			return $youtube;
		}
		
		//Check if its a vimeo video 
		if(preg_match('/http:\/\/(www\.)*vimeo\.com\/.*/',$url))
		{
			$vimeo_no=(int) substr(parse_url($url, PHP_URL_PATH), 1);
			if($vimeo_no){
			$vimeo = str_replace($url,'<div class="video-container">
				<iframe  width= "510" height="300" src="http://player.vimeo.com/video/'.$vimeo_no.'" 
				frameborder="0" 
				allowfullscreen></iframe></div>',$url);
			return $vimeo;
			}
			return false;
		}
		else
			return false;
		
	}		
		
	public function _isUrlImage($url)
	{
		//Check if the URL is IMAGE
		$imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif");
		$urlExt = pathinfo($url, PATHINFO_EXTENSION);
		if (in_array($urlExt, $imgExts)) 
		{
			$image='<img src="'.$url.'"  class="feed-info-image"/>';
			return $image;
		}
		else
			return false;
	}	
	

		// Function to check if the url exists... 
		// if exists then get the Title and Description
		// attach image file to the feed
		public function _urlInfo($url)
		{
			if($this->isValidUrl($url)==true)
			{
				
				$file = file_get_contents($url);	
				$tags= get_meta_tags($url);
				if(preg_match("/<title>(.+)<\/title>/i",$file,$result))
				{
					if(isset($result[1]))
					{
						$info = '<div class="url-frame"><b><a href="'.$url.'" target="_blank">'
							.$result[1].'</a></b>'.'<div class="feed-info-box-url">'.$url.'</div>';
						if(isset( $tags['description']))
							$info=$info." ".substr($tags['description'], 0, 150).'</div>';
						else
							$info=$info.'</div>';

						return $info; 
					}
					else
						return "";
					
				}
			}
		}
	
	function parseVideos($videoString = null)
	{
    // return data
    $videos = array();
 
    if (!empty($videoString)) {
 
        // split on line breaks
        $videoString = stripslashes(trim($videoString));
        $videoString = explode("\n", $videoString);
        $videoString = array_filter($videoString, 'trim');
 
        // check each video for proper formatting
        foreach ($videoString as $video) {
 
            // check for iframe to get the video url
            if (strpos($video, 'iframe') !== FALSE) {
                // retrieve the video url
                $anchorRegex = '/src="(.*)?"/isU';
                $results = array();
                if (preg_match($anchorRegex, $video, $results)) {
                    $link = trim($results[1]);
                }
            } else {
                // we already have a url
                $link = $video;
            }
 
            // if we have a URL, parse it down
            if (!empty($link)) {
 
                // initial values
                $video_id = NULL;
                $videoIdRegex = NULL;
                $results = array();
 
                // check for type of youtube link
                if (strpos($link, 'youtu') !== FALSE) {
                    // works on:
                    // http://www.youtube.com/watch?v=VIDEOID
					if(strpos($link, 'youtube.com/watch') !== FALSE){
						$videoIdRegex = '/http:\/\/(?:www\.)?youtube.*watch\?v=([a-zA-Z0-9\-_]+)/';
					}
					else if (strpos($link, 'youtube.com') !== FALSE) {
                        // works on:
                        // http://www.youtube.com/embed/VIDEOID
                        // http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
                        // http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
                        $videoIdRegex = '/youtube.com\/(?:embed|v){1}\/([a-zA-Z0-9_]+)\??/i';
                    } else if (strpos($link, 'youtu.be') !== FALSE) {
                        // works on:
                        // http://youtu.be/daro6K6mym8
                        $videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
                    }
 
                    if ($videoIdRegex !== NULL) {
                        if (preg_match($videoIdRegex, $link, $results)) {
                            $video_str = 'http://www.youtube.com/v/%s?fs=1&amp;autoplay=1';
                            $thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
                            $fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
                            $video_id = $results[1];
                        }
                    }
                }
 
                // handle vimeo videos
                else if (strpos($video, 'vimeo') !== FALSE) {
                    if (strpos($video, 'player.vimeo.com') !== FALSE) {
                        // works on:
                        // http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
                        $videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
                    } else {
                        // works on:
                        // http://vimeo.com/37985580
                        $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
                    }
 
                    if ($videoIdRegex !== NULL) {
                        if (preg_match($videoIdRegex, $link, $results)) {
                            $video_id = $results[1];
 
                            // get the thumbnail
                            try {
                                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                                if (!empty($hash) && is_array($hash)) {
                                    $video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
                                    $thumbnail_str = $hash[0]['thumbnail_small'];
                                    $fullsize_str = $hash[0]['thumbnail_large'];
                                } else {
                                    // don't use, couldn't find what we need
                                    unset($video_id);
                                }
                            } catch (Exception $e) {
                                unset($video_id);
                            }
                        }
                    }
                }
 
                // check if we have a video id, if so, add the video metadata
                if (!empty($video_id)) {
                    // add to return
                    $videos[] = array(
                        'url' => sprintf($video_str, $video_id),
                        'thumbnail' => sprintf($thumbnail_str, $video_id),
                        'fullsize' => sprintf($fullsize_str, $video_id)
                    );
                }
            }
 
        }
 
    }
 
    // return array of parsed videos
    return $videos;
	}

	// function to convert url to html link
	function urlToLink($url)
	{
		if(preg_match('@^https?://@',$url))
		{
			$url = preg_replace('#^https?://#', '', $url);
			$url= str_replace($url,'<a href="http://'.$url.'" class="feed-link" target="_blank">'
				.'http://'.$url.'</a>',$url);
			return $url;
		}
		else
			return $url;
	}

	public function _httpsRemove($url){
		$url = preg_replace('#^https?://#', '', $url);
		$url= str_replace($url,"http://".$url."",$url);
		return $url;
	}

	public function isvalidUrl($url){
		if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    		return false;
		}
		else
			return true;
	}
}