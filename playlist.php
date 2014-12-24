<?php

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

?><br/><?php /*?><input type="checkbox" name="downloads" title="Check All" id="downloads" />&nbsp;<strong>Download All</strong><br /><?php */?>

<div id="html5tap_playlist">


<?php /*?><input type="checkbox" name="downloads" title="Check All" id="downloads" />&nbsp;<strong>Download All</strong><br /><?php */?>



<?php $ele = ''; 


$mm = 1;


//echo $_title;

/*$_title = explode(",", $_title);
$_artist = explode(",", $_artist);
$_song = explode(",", $_song);
$_artwork = explode(",", $_artwork);*/

$_title = maybe_unserialize(base64_decode($_title));
$_artist = maybe_unserialize(base64_decode($_artist));
$_song = maybe_unserialize(base64_decode($_song));
$_artwork = maybe_unserialize(base64_decode($_artwork));




$ccc = count($_title);

for($kk=0;$kk<$ccc;$kk++)
{

 $ele .= '<div id="divId' .$mm. '">';
				
	//$ele .= '<br><input type="hidden" name="_item_id['.($mm-1).']" id="item_id' .$mm. '" value="'.$mp3i.'" /><input type="checkbox" name="_download['.($mm-1).']" id="download' .$mm. '" '.$ddd.' value="1" />&nbsp;Download<br>Title:&nbsp;&nbsp;&nbsp; <input type="text" name="_title[]"	id="title' .$mm. '" value="'.MP3Title(wp_unslash($_title[$kk])).'" size="30" placeholder="title" /><br/>Artist:&nbsp; <input type="text" name="_artist[]"	id="artist' .$mm. '" value="'.wp_unslash($_artist[$kk]).'" size="30" placeholder="artist" /><br/>Song:&nbsp;&nbsp; <input type="text" size="30" name="_song[]"	id="song' .$mm. '" value="'.wp_unslash($_song[$kk]).'" placeholder="media" /><br/>Image: <input type="text" size="30" name="_artwork[]"	id="artwork' .$mm. '" value="'.wp_unslash($_artwork[$kk]).'" placeholder="artwork" />';
	
	
	$ele .= '<br><input type="hidden" name="_item_id['.($mm-1).']" id="item_id' .$mm. '" value="'.$mp3i.'" />Title:&nbsp;&nbsp;&nbsp; <input type="text" name="_title[]" id="title' .$mm. '" value="'.MP3Title(wp_unslash($_title[$kk])).'" size="30" placeholder="title" /><br/>Artist:&nbsp; <input type="text" name="_artist[]"	id="artist' .$mm. '" value="'.wp_unslash($_artist[$kk]).'" size="30" placeholder="artist" /><br/>Song:&nbsp;&nbsp; <input type="text" size="30" name="_song[]"	id="song' .$mm. '" value="'.wp_unslash($_song[$kk]).'" placeholder="media" /><br/>Image: <input type="text" size="30" name="_artwork[]"	id="artwork' .$mm. '" value="'.wp_unslash($_artwork[$kk]).'" placeholder="artwork" />';
				
				if($mm==1)
				  $ele .= '&nbsp;<a href="javascript:void(0)" onclick="return addNewElement()">+ Add More</a><br><br>';
				else
				  $ele .= '&nbsp;<a href="javascript:void(0)" onclick="return removeThisElement(' .$mm. ')">Remove This</a><br><br>';  
				  
				$ele .= '</div>';
				
				
				$mm++;

}

 

?>


<div id="more_element_area">
  
  <script type="text/javascript">
  
  var idno = <?php echo isset($mm)?$mm:'2'; ?>;
  
  </script>
  
  <?php if($ele!="") { ?>
  
  <?php echo $ele; ?>
  
  <?php }else{ ?>
  
    <input type="hidden" name="_item_id[0]" id="item_id1"  value="" /><?php /*?><input type="checkbox" name="_download[0]" id="download1"  value="1" />&nbsp;<?php */?><input type="text" name="_title[]" id="title1" value="" size="20" placeholder="title" />&nbsp;<input type="text" name="_artist[]" id="artist1" value="" size="20" placeholder="artist" />&nbsp;<input type="text" name="_song[]" id="song1" size="30" value="" placeholder="media" />&nbsp;<input type="text" name="_artwork[]" id="artwork1" size="30" value="" placeholder="artwork" />&nbsp;<a href="javascript:void(0)" onclick="return addNewElement()">+ Add More</a><br><br><br>
    
  <?php } ?>  
    
  
</div>

</div>