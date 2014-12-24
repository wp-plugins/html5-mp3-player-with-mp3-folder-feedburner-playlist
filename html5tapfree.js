function sel_source(v)
{

if(v == "default")
{
	
  document.getElementById("other").style.display = 'none';
  document.getElementById("_sourceurl").value = "";
  document.getElementById("soundcloud").style.display = 'none';
}
else if(v == "feed" || v == "folder")
{
  document.getElementById("other").style.display = 'block';
  document.getElementById("soundcloud").style.display = 'none';
}
else if(v == "soundcloud")
{
  document.getElementById("soundcloud").style.display = 'block';
  document.getElementById("other").style.display = 'block';
}
else if(v == "s3")
{
  document.getElementById("other").style.display = 'block';
  document.getElementById("soundcloud").style.display = 'none';
}
else
{
  document.getElementById("other").style.display = 'none';
  document.getElementById("_sourceurl").value = "";
}  


}

function playlistSourceType()
{

  jQuery("#html5tap_playlist").html('<img src="'+plugin_dir_url+'loading.gif" />');
  
  txt=jQuery("#_sourceurl").val();
  sourcetype=jQuery("#_sourcetype").val();
  pass=jQuery("#_clientid").val()+':'+jQuery("#_clientsecret").val();
  jQuery.post(plugin_dir_url+"playlistSourceType.php",{sourceurl:txt,sourcetype:sourcetype,pass:pass },function(result){
  jQuery("#html5tap_playlist").html(result);
  });

}



//var idno = <?php //echo $mm; ?>; // It start from id 2 

function addNewElement()
{
	// mainDiv is a variable to store the object of main area Div.
	var mainDiv = document.getElementById('more_element_area');
	// Create a new div 
	var innerDiv = document.createElement('div');
	// Set the attribute for created new div like here I am assigning Id attribure. 
	innerDiv.setAttribute('id', 'divId' + idno);
	
	var generatedContent = '<br><input type="hidden" name="_item_id[' + (idno-1) + ']" id="item_id' + idno + '" value="" /><input type="checkbox" name="_download[' + (idno-1) + ']" id="download' + idno + '" value="1" />&nbsp;Download<br>Title:&nbsp;&nbsp;&nbsp; <input type="text" name="_title[]"	id="title' + idno + '" value="" size="30" placeholder="title" />&nbsp;<br>Artist:&nbsp; <input type="text" name="_artist[]"	id="artist' + idno + '" value="" size="30" placeholder="artist" />&nbsp;<br>Song:&nbsp;&nbsp; <input type="text" size="30" name="_song[]"	id="song' + idno + '" value="" placeholder="media" />&nbsp;<br>Image: <input type="text" size="30" name="_artwork[]"	id="artwork' + idno + '" value="" placeholder="artwork" />&nbsp;<a href="javascript:void(0)" onclick="return removeThisElement(' + idno + ')">Remove This</a><br><br><br>';
	
	
	// Inserting content to created Div by innerHtml
	innerDiv.innerHTML = generatedContent;
	// Appending this complete div to main div area.
	mainDiv.appendChild(innerDiv);
	// increment the id number by 1.
	idno++;
}

function removeThisElement(idnum)
{
	
	if(confirm("Are you Sure?"))
	{
	// mainDiv is a variable to store the object of main area Div.
	var mainDiv = document.getElementById('more_element_area');
	// get the div object with get Id to remove from main div area.
	var innerDiv = document.getElementById('divId' + idnum);
	// Removing element from main div area.
	mainDiv.removeChild(innerDiv);
	}
 
}

     jQuery("#downloads").click(function () {
        if (jQuery("#downloads").is(':checked')) {
            jQuery("#more_element_area input[type=checkbox]").each(function () {
                jQuery(this).attr("checked", true);
            });

        } else {
            jQuery("#more_element_area input[type=checkbox]").each(function () {
                jQuery(this).attr("checked", false);
            });
        }
    });

