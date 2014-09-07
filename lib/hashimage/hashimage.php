<?php
/***
	#IMAGE - A Simple Image Imanipulation library in php
	Author: Krishna Teja G S
	Production: PacketCode (http://packetcode.com)
	Website : www.hashimage.com
	Creation Date: 11th May 2014
	license: GNU General Public License version 2 or later
**/

class hashimage{

	//Custucting the hashimage object and setting the 
	//paramters to the current object
	function __construct(){
		$this->destinationfolder = 'images/';
		$this->name = 'hashimage.jpg';
		$this->quality = 99;
		$this->filterfolder = 'filters/';
		$this->watermark = new stdClass;
		$this->watermark->opacity = 60;
		$this->watermark->position = 'bottomright';
		$this->watermark->padding = 20;
		$this->watermark->size = 200;
		$this->watermark->x=0;
		$this->watermark->y =0;
		$this->watermark->image = $this->destinationfolder.'watermark.png';
	}
	
	// function to load the image to memory it takes 
	// filename with absolute path as parameter
	// stores the information about file in current object
	function load($filename){
		//set the filename to current object;
		$this->file= $filename;
		//get the image width and height and store in current object
		list($width, $height) = getimagesize($filename);
		$this->width = $width;
		$this->height = $height;

		//get image extension
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		switch($ext){
			case 'jpg':
			$extension= 'jpeg';
			break;
			case 'jpeg':
			$extension= 'jpeg';
			break;
			case 'png':
			$extension= 'png';
			break;
			case 'gif':
			$extension= 'gif';
			break;		
		}

		$this->extension = $extension;
		//get filename without extension
		$pieces = explode('/',$filename);
		$c = count($pieces);
		$pcs = explode('.',$pieces[$c-1]);
		$file = $pcs[0];
		$this->filename = $file;
		//load filesize
		//$this->filesize = filesize($filename);
		//create image instance and store it
		$imgcreate = 'imagecreatefrom'.$extension;

		$img = $imgcreate($filename);
		//store the image instance $this object
		$this->image = $img;

		return $this;	
	}

	function pngFilter(){

		$thumb = imagecreatetruecolor($this->width, $this->height);
		imagesavealpha($thumb, true);
		imagealphablending($thumb, false);
		$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
		imagefilledrectangle($thumb, 0, 0, $this->width, $this->height, $transparent);
		imagecopyresized($thumb, $this->image, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);
		$this->image = $thumb;
		return $this;
	}

	function savepng2jpeg($path){
		$input_file = $this->image;
		$output_file = $path;

		$input = imagecreatefrompng($input_file);
		list($width, $height) = getimagesize($input_file);
		$output = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($output,  255, 255, 255);
		imagefilledrectangle($output, 0, 0, $width, $height, $white);
		imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
		imagejpeg($output, $output_file);
	}
	// function to resize the image and by default reduces the size by 50%
	// detects %,PX,numeric values automatically 
	function resize($size=null,$on =null)
	{
		//get the resize value 
		if($size ==null )
			$size = '50%';
		//if second parameter is not defined take it as width
		if($on==null)
			$on = 'width';

		//get the constraint new width and height
		if(!$this->percent($on)){
			if($on!='square'){
				$percent = $this->percent($size,$this->$on);
				$newwidth = $this->width * $percent;
				$newheight = $this->height * $percent;
			}
			else{
				$percent = $this->percent($size,$this->width);
				$newwidth = $newheight = $this->width * $percent;
			}
		}else{
			$newwidth = $this->width * $this->percent($size,$this->width);
			$newheight = $this->height * $this->percent($on,$this->height);		
		}

		
		//create the new image container
		$thumb = imagecreatetruecolor($newwidth, $newheight);

		//if its png make the background transparent
		if($this->extension =='png'){
		imagesavealpha($thumb, true);
		imagealphablending($thumb, false);
		$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
		imagefilledrectangle($thumb, 0, 0, $newwidth, $newheight, $transparent);
		}
	
		// Resize to conatiner
		imagecopyresized($thumb, $this->image, 0, 0, 0, 0, $newwidth, $newheight, $this->width, $this->height);
		
		//update the current object
		$this->width = $newwidth;
		$this->height = $newheight;
		$this->image = $thumb;
		return $this;
	}

	//function to crop images and its takes source coordinates 
	//and distination dimensions
	function crop($src_x,$src_y,$dst_w,$dst_h){
		$imgdest = ImageCreateTrueColor( $dst_w, $dst_h);
		    //if its png make the background transparent
		if($this->extension =='png'){
		imagesavealpha($imgdest, true);
		imagealphablending($imgdest, false);
		$transparent = imagecolorallocatealpha($imgdest, 255, 255, 255, 127);
		imagefilledrectangle($imgdest, 0, 0, $dst_w, $dst_h, $transparent);
		}
		imagecopyresampled($imgdest,$this->image,0,0,$src_x,$src_y,$dst_w,$dst_h,$dst_w,$dst_h);
		$this->image = $imgdest;
		$this->width = $dst_w;
		$this->height = $dst_h;
		return $this;
	}

	//function to overlay layer on image
	function overlay($type, $amount){
		//get image dimensions
		$width = $this->width;
		$height = $this->height;

		//create a transparent layer
		$filter = imagecreatetruecolor($width, $height);
		imagealphablending($filter, false);
		imagesavealpha($filter, true);
		$transparent = imagecolorallocatealpha($filter, 255, 255, 255, 127);
		imagefilledrectangle($filter, 0, 0, $width, $height, $transparent);
		
		//get the filter and copy it to the layer
		$overlay = $this->filterfolder . $type . '.png';
		list($w, $h) = getimagesize($overlay);
		$png = imagecreatefrompng($overlay);
		imagecopyresampled($filter, $png, 0, 0, 0, 0, $width, $height, $w, $h);
		
		//merge the layer to image
		$comp = imagecreatetruecolor($width, $height);
		imagecopy($comp, $this->image, 0, 0, 0, 0, $width, $height);
		imagecopy($comp, $filter, 0, 0, 0, 0, $width, $height);
		imagecopymerge($this->image, $comp, 0, 0, 0, 0, $width, $height, $amount);
		imagedestroy($comp);
		
		return $this;
	}
	
	//function to add waltermark to image 
	// take a anonymous function as parameter
	function watermark($fun=null){

		//check if the function is defined
		if($fun)
		$fun($this->watermark);

		//get the values from the current object
		$overlay = $this->watermark->image;
		$amount = $this->watermark->opacity;
		$size = $this->watermark->size;
		$padding = $this->watermark->padding;
		$position = $this->watermark->position;

		//load the defaults and create a filter
		$width = $this->width;
		$height = $this->height;
		$filter = imagecreatetruecolor($width, $height);
		
		//set options to make the background transparent
		imagealphablending($filter, false);
		imagesavealpha($filter, true);
		
		//get the filter size and calculate the percentages
		list($w, $h) = getimagesize($overlay);
		$percent =$this->percent($size,$w);
		$newwidth = $w * $percent; 
		$newheight = $h * $percent;	

		//create a watermark image 
		$watermark = new hashimage();
		$png = $watermark->load($overlay)->image;
		//get its position
		$this->watermarkPosition($newwidth,$newheight);

		//make the background transparent and copy the filter to frame with opacity
		$transparent = imagecolorallocatealpha($filter, 255, 255, 255, 127);
		imagefilledrectangle($filter, 0, 0, $width, $height, $transparent);
		imagecopyresampled($filter, $png, $this->watermark->x, $this->watermark->y, 0, 0, $newwidth, $newheight, $w, $h);
		
		//merge the images
		$comp = imagecreatetruecolor($width, $height);
		imagecopy($comp, $this->image, 0, 0, 0, 0, $width, $height);
		imagecopy($comp, $filter, 0, 0, 0, 0, $width, $height);
		imagecopymerge($this->image, $comp, 0, 0, 0, 0, $width, $height, $amount);
		//remove the image from memory
		imagedestroy($comp);
		return $this;
	}

	//function to understand watermark position 
	//caliculates the position considering the custom size and padding
	function watermarkPosition($newwidth,$newheight){
		$width = $this->width;
		$height = $this->height;
		$padding = $this->watermark->padding;
		$position = strtoupper($this->watermark->position);
		switch($position){
			case 'TOPLEFT':
			$this->watermark->x = $padding;
			$this->watermark->y = $padding;
			break; 
			case 'TOPCENTER':
			$this->watermark->x = ($width/2)-($newwidth/2);
			$this->watermark->y = $padding;
			break;
			case 'TOPRIGHT':
			$this->watermark->x = $width-$newwidth-$padding;
			$this->watermark->y = $padding;
			break;
			case 'CENTERLEFT':
			$this->watermark->x = $padding;
			$this->watermark->y = ($height/2)-($newheight/2);
			break; 
			case 'CENTER':
			$this->watermark->x = ($width/2)-($newwidth/2);
			$this->watermark->y = ($height/2)-($newheight/2);
			break;
			case 'CENTERRIGHT':
			$this->watermark->x = $width-$newwidth-$padding;
			$this->watermark->y = ($height/2)-($newheight/2);
			break;
			case 'BOTTOMLEFT':
			$this->watermark->x =  $padding;
			$this->watermark->y =  $height-$newheight-$padding;
			break; 
			case 'BOTTOMCENTER':
			$this->watermark->x = ($width/2)-($newwidth/2);
			$this->watermark->y =  $height-$newheight-$padding;
			break;
			case 'BOTTOMRIGHT':
			$this->watermark->x = $width-$newwidth-$padding;
			$this->watermark->y = $height-$newheight-$padding;
			break;
			case 'CUSTOM':
			break;
		}
		return $this;
	}

	//function to flip the image vertically or horizontally
	//takes the mode of flip as parameter
	function flip($mode){

		$mode = strtoupper($mode);
   	 	$width = $this->width;
   	 	$height  = $this->height;
    	$src_x = 0;
   		$src_y = 0;
   		$src_width  = $width;
    	$src_height = $height;

	    switch($mode)
	    {
	        case 'VERTICAL':
	            $src_y                =    $height;
	            $src_height           =    -$height;
	        break;
	        case 'HORIZONTAL':
	            $src_x                =    $width;
	            $src_width            =    -$width;
	        break;
	        case 'BOTH':
	            $src_x                =    $width;
	            $src_y                =    $height;
	            $src_width            =    -$width;
	            $src_height           =    -$height;
	        break;
	        default:
	            return $this;
	    }
	    $imgdest = imagecreatetruecolor ( $width, $height );
	    //if its png make the background transparent
		if($this->extension =='png'){
		imagesavealpha($imgdest, true);
		imagealphablending($imgdest, false);
		$transparent = imagecolorallocatealpha($imgdest, 255, 255, 255, 127);
		imagefilledrectangle($imgdest, 0, 0, $width, $height, $transparent);
		}
	    imagecopyresampled ( $imgdest, $this->image, 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height );
	    
	    //update the values to current obj
	    $this->width = $width;
	    $this->height = $height;
	    $this->image = $imgdest;
	    return $this;
	}

	//function to rotate the image in any angle in any direction
	//takes the roation side and angle as parameters
	function rotate($side,$angle){
		$image =$this->image;
		$transColor = imagecolorallocatealpha($image, 255, 255, 255, 127);
	
		$side = strtoupper($side);
		switch($side){
			case 'ANTICLOCKWISE':
			 	$rotatedImage = imagerotate($image, $angle, $transColor);
			break;
			case 'CLOCKWISE':
				$rotatedImage = imagerotate($image, 360-$angle, $transColor);
			break;
		}
		imagesavealpha($rotatedImage, true);

		//update the object
		$this->width = imagesx($rotatedImage);
		$this->height = imagesy($rotatedImage);
		$this->extension='png';
		$this->image = $rotatedImage;
		return $this;
	}

	//function to display the image to browser
	function show(){
		$type = $this->extension;
		$imgoutput = 'image'.$type;
		header('Content-Type: image/png') ;
		$imgoutput($this->image);
		return $this;
	}

	//function to save the image to disk
	function save($path=null){

		$file = $this->name;
		$quality = $this->quality;
		if($path == null)
			$path = $this->destinationfolder.$file.'-new-'.substr(md5(rand()), 0, 3).'.'.$this->extension;
		
		$imgoutput = 'image'.$this->extension;
		if($this->extension == 'jpg')
			$imgoutput($this->image,$path,$quality);
		if($this->extension == 'png')
		{
			$imgoutput = 'imagejpeg';
			$quality = floor($quality/10);
			$imgoutput($this->image,$path,$quality);
			//$this->savepng2jpeg($path);
		}
		else
			$imgoutput($this->image,$path);
		//echo $imgoutput;
		$this->savepath = $path;
		return $this;
	}

	//function apply preset filters to image
	// Filters - Dreamy,velvet,monopin,chrome,lift,canvas
	//		     antique,blackwhite,boost,sepia,greyscale,vintage,blur  
	function filter($filter){
		$filter = strtoupper($filter);
		switch($filter){
			case 'DREAMY':
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 20);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -35);
			imagefilter($this->image, IMG_FILTER_COLORIZE, 60, -10, 35);
			imagefilter($this->image, IMG_FILTER_SMOOTH, 7);
			$this->overlay('scratch', 10);
			$this->overlay('vignette', 100);
			break;
			case 'VELVET':
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 5);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -25);
			imagefilter($this->image, IMG_FILTER_COLORIZE, -10, 45, 65);
			$this->overlay('noise', 45);
			$this->overlay('vignette', 100);
			break;
			case 'MONOPIN':
			imagefilter($this->image, IMG_FILTER_GRAYSCALE);
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, -15);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -15);
			$this->overlay('vignette', 100);
			break;
			case 'CHROME':
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 15);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -15);
			imagefilter($this->image, IMG_FILTER_COLORIZE, -5, -10, -15);
			$this->overlay('noise', 45);
			$this->overlay('vignette', 100);
			break;
			case 'LIFT':
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 50);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -25);
			imagefilter($this->image, IMG_FILTER_COLORIZE, 75, 0, 25);
			$this->overlay('emulsion', 100);
			break;
			case 'CANVAS':
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 25);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -25);
			imagefilter($this->image, IMG_FILTER_COLORIZE, 50, 25, -35);
			$this->overlay('canvas', 100);
			break;
			case 'ANTIQUE':			
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 0);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -30);
			imagefilter($this->image, IMG_FILTER_COLORIZE, 75, 50, 25);
			break;
			case 'BLACKWHITE':
			imagefilter($this->image, IMG_FILTER_GRAYSCALE);
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 10);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -20);
			break;
			case 'BOOST':
			imagefilter($this->image, IMG_FILTER_CONTRAST, -35);
			imagefilter($this->image, IMG_FILTER_COLORIZE, 25, 25, 25);
			break;
			case 'SEPIA':
			imagefilter($this->image, IMG_FILTER_GRAYSCALE);
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, -10);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -20);
			imagefilter($this->image, IMG_FILTER_COLORIZE, 60, 30, -15);
			break;
			case 'GRAYSCALE':
			imagefilter($this->image,IMG_FILTER_GRAYSCALE);
			break;
			case 'VINTAGE':
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS, 15);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -25);
			imagefilter($this->image, IMG_FILTER_COLORIZE, -10, -5, -15);
			imagefilter($this->image, IMG_FILTER_SMOOTH, 7);
			$this->overlay('scratch', 7);
			break;
			case 'BLUR':
			imagefilter($this->image, IMG_FILTER_SELECTIVE_BLUR);
			imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
			imagefilter($this->image, IMG_FILTER_CONTRAST, -15);
			imagefilter($this->image, IMG_FILTER_SMOOTH, -2);
			break;
		}
		return $this;
	}

	// function to alter the parameters
	function change($parameter,$pct){
		$parameter = strtoupper($parameter);
		switch($parameter){
			case 'BRIGHTNESS':
			$const= 2;
			break;
			case 'CONTRAST':
			$const= 3;
			break;
			case 'PIXELATE':
			$const= 11;
			break;
			case 'SMOOTHNESS':
			$const= 10;
			break;
		}		
		imagefilter($this->image,$const,$pct);
		return $this;
	}


	// calculates the ratio of the user given value
	// detects the value as either % or PX or numeric
	// returns 0 if its not valid
	// $r is second parameter by defualt taken as width of image 
	function percent($str,$r=null){
		if($r==null)
			$r=$this->width;
		$str = strtoupper($str);
		if(substr($str, -1) === '%')
			return (substr($str,0, strlen($str)-1)/100);
		elseif(substr($str, -2) === 'PX')
			return (substr($str,0, strlen($str)-2)/$r);
		elseif(is_numeric($str))
			return ($str/$r);
		else
			return 0;	
	}

}	

