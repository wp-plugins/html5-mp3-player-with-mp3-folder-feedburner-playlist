<?php

if ( ! defined( 'ABSPATH' ) ) {
        //exit;
}

include("functions.php"); 

$ele = '';
$mm++;

 
if(isset($_POST['sourceurl']) && $_POST['sourceurl']!="")
{

$folderfeedlink = $_POST['sourceurl'];
$sourcetype = $_POST['sourcetype'];

if($sourcetype=="folder")
{

$ff = readFolder($folderfeedlink);

$folderfeedlink = str_replace("list.php", "", $folderfeedlink);

$mm = 1;

foreach($ff as $file)
{


	//if(isset($id3) && $id3==1)
	//$mp3_det = getMp3Info( $folderfeedlink.$file );
	
	//print_r($mp3_det);
	
	$mp3i = $mm;
	
	$mp3p = $image;						
		
	$mp3s = $file;  
	 
	$mp3t = isset($mp3_det['title'])?$mp3_det['title']:basename($file); //$title; 
	
	$mp3a = isset($mp3_det['artist'])?$mp3_det['artist']:$artist;
	
	$dlink = preg_replace('/ /i', '%20', $mp3s);
	
	$mp3t = str_replace("%20", " ", $mp3t);
	
	$mp3t = MP3Title($mp3t);
	
	$ddd = '';
	$vvv = 0;
	
	
	
	$ele .= '<div title="'.$mp3t.'" id="divId' .$mm. '">';

$ele .= '<br><input type="hidden" name="item_id['.($mm-1).']" id="item_id' .$mm. '" value="'.$mp3i.'" /><input title="download" type="checkbox" name="_download['.($mm-1).']" id="download' .$mm. '" '.$ddd.' value="1" />&nbsp;Download<br>Title:&nbsp;&nbsp;&nbsp;<input type="text" name="_title[]" id="title' .$mm. '" value="'.$mp3t.'" placeholder="title" /><br/>Artist:&nbsp;<input type="text" name="_artist[]"	id="artist' .$mm. '" value="'.$mp3a.'" placeholder="artist" /><br/>Song:&nbsp;&nbsp;<input type="text" size="30" name="_song[]"	id="song' .$mm. '" value="'.$mp3s.'" placeholder="song link" /><br/>Image:&nbsp;<input type="text" size="30" name="_artwork[]"	id="artwork' .$mm. '" value="'.$mp3p.'" placeholder="image link" />';

$ele .= '&nbsp;&nbsp;<a title="Add More" href="javascript:void(0)" onclick="return addNewElement()">+ Add More</a>&nbsp;&nbsp;<a title="Remove This" href="javascript:void(0)" onclick="return removeThisElement(' .$mm. ')">Remove This</a>';  

$ele .= '<div class="clear"></div></div>';	
	


$mm++;	
	
}	


}


if($sourcetype=="feed")
{

$ff = readFeed($folderfeedlink);

$mm = 1;

foreach($ff as $file)
{


	//if(isset($id3) && $id3==1)
	//$mp3_det = getMp3Info( $folderfeedlink.$file );
	
	//print_r($mp3_det);
	
	$mp3i = $mm;
	
	$mp3p = $mp3p = isset($file['pic'])?$file['pic']:$pimage;					
		
	$mp3s = $file['url'];  
	 
	$title = isset($file['title'])?$file['title']:$title;
	
	$title = basename($title);
	
	$artist = isset($file['artist'])?$file['artist']:$artist;				
	
	$mp3t = isset($mp3_det['title'])?$mp3_det['title']:$title; 
	
	$mp3t = basename(str_replace("%20", " ", $mp3t));
	
	$mp3a = isset($mp3_det['artist'])?$mp3_det['artist']:$artist;
	
	$mp3d = $sourcedownload;
	
	$dlink = preg_replace('/ /i', '%20', $mp3s);
	
	$mp3t = str_replace("%20", " ", $mp3t);
	
	$mp3t = MP3Title($mp3t);
	
	$ddd = '';
	$vvv = 0;
	
	
	
	$ele .= '<div title="'.$mp3t.'" id="divId' .$mm. '">';

$ele .= '<br><input type="hidden" name="item_id['.($mm-1).']" id="item_id' .$mm. '" value="'.$mp3i.'" /><input title="download" type="checkbox" name="download['.($mm-1).']" id="download' .$mm. '" '.$ddd.' value="1" />&nbsp;Download<br>Title:&nbsp;&nbsp;&nbsp;<input type="text" name="_title[]" id="title' .$mm. '" value="'.$mp3t.'" placeholder="title" /><br/>Artist:&nbsp;<input type="text" name="_artist[]"	id="artist' .$mm. '" value="'.$mp3a.'" placeholder="artist" /><br/>Song:&nbsp;&nbsp;<input type="text" size="30" name="_song[]"	id="song' .$mm. '" value="'.$mp3s.'" placeholder="song link" /><br/>Image:&nbsp;<input type="text" size="30" name="_artwork[]"	id="image' .$mm. '" value="'.$mp3p.'" placeholder="image link" />';

$ele .= '&nbsp;&nbsp;<a title="Add More" href="javascript:void(0)" onclick="return addNewElement()">+ Add More</a>&nbsp;&nbsp;<a title="Remove This" href="javascript:void(0)" onclick="return removeThisElement(' .$mm. ')">Remove This</a>';  

$ele .= '<div class="clear"></div></div>';	
	


$mm++;	
	
}	


}

if($sourcetype=="soundcloud")
{

$pass = explode(":", $_POST['pass']);

$ff = readSoundCloud($folderfeedlink, $pass[0], $pass[1]);


$mm = 1;

foreach($ff as $file)
{


	//if(isset($id3) && $id3==1)
	//$mp3_det = getMp3Info( $folderfeedlink.$file );
	
	//print_r($mp3_det);
	
	$mp3i = $mm;
	
	$mp3p = isset($file['artwork_url'])?$file['artwork_url']:$image;					
		
	$mp3s = $file['stream_url'];  
	
	$title = isset($file['title'])?$file['title']:$title;
    $artist = isset($file['user'])?$file['user']:$partist;	  
	 
	$mp3t = isset($mp3_det['title'])?$mp3_det['title']:$title; 
	$mp3t = str_replace("%20", " ", $mp3t);
	
	$mp3a = isset($mp3_det['artist'])?$mp3_det['artist']:$artist;
	
	$mp3d = $sourcedownload;
	
	$dlink = preg_replace('/ /i', '%20', $file['stream_url']);
	
	//$mp3t = str_replace("%20", " ", $mp3t);
	
	$ddd = '';
	$vvv = 0;
	
	
	
	$ele .= '<div title="'.$mp3t.'" id="divId' .$mm. '">';

$ele .= '<br><input type="hidden" name="item_id['.($mm-1).']" id="item_id' .$mm. '" value="'.$mp3i.'" /><input title="download" type="checkbox" name="download['.($mm-1).']" id="download' .$mm. '" '.$ddd.' value="1" />&nbsp;Download<br>Title:&nbsp;&nbsp;&nbsp;<input type="text" name="_title[]" id="title' .$mm. '" value="'.$mp3t.'" placeholder="title" /><br/>Artist:&nbsp;<input type="text" name="_artist[]"	id="artist' .$mm. '" value="'.$mp3a.'" placeholder="artist" /><br/>Song:&nbsp;&nbsp;<input type="text" size="30" name="_song[]"	id="song' .$mm. '" value="'.$mp3s.'" placeholder="song link" /><br/>Image:&nbsp;<input type="text" size="30" name="_artwork[]"	id="image' .$mm. '" value="'.$mp3p.'" placeholder="image link" />';

$ele .= '&nbsp;&nbsp;<a title="Add More" href="javascript:void(0)" onclick="return addNewElement()">+Add More</a>&nbsp;&nbsp;<a title="Remove This" href="javascript:void(0)" onclick="return removeThisElement(' .$mm. ')">Remove This</a>';  

$ele .= '<div class="clear"></div></div>';	
	


$mm++;	
	
}	

}


				




}

 
 
 
 if(isset($_POST['sourceurl']) && $_POST['sourceurl']!="")
{
 
?>



<div id="container">
  <div id="list">

    <div id="response"> </div>
    <div  id="more_element_area">
    

  
  <?php if($ele!="") { ?>
  
  <?php echo $ele; ?>
  
  <?php }else{ ?>
  
  <div id="divId0"><br />

  
    <input type="hidden" name="item_id[0]" id="item_id1"  value="" /><input title="download" type="checkbox" name="download[0]" id="download1"  value="1" />&nbsp;Download<br />Title:&nbsp;&nbsp;&nbsp;  <input type="text" name="title[]" id="title1" value="" placeholder="title" /><br />Artist:&nbsp; <input type="text" name="artist[]" id="artist1" value="" placeholder="artist" /><br />Song:&nbsp;&nbsp; <input type="text" size="60" name="song[]" id="song1" value="" placeholder="song link" /><br/>Image: <input type="text" name="image[]" id="image1" size="60" value="" placeholder="image link" />&nbsp;&nbsp;<a title="Add More" href="javascript:void(0)" onclick="return addNewElement()">+Add More</a>
    
    
    <div class="clear"></div>
    
    </div>
    
  <?php } ?>  

    </div>
    
    
    
  </div>
</div>
<?php } ?>