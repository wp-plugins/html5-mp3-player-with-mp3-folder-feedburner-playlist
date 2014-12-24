<?php 
//include("config.php");

function readFolder($url)
{

$url = stripslashes(preg_replace('/ /i', '%20', $url)); 

$html = getContents($url); 

if($html=="") echo "<strong>Player could not read MP3 files...</strong><br><strong>Download <a target='_blank' href='http://html5mp3folder.svnlabs.com/list.phps'>'list.phps'</a> then rename this file to 'list.php' and upload to private MP3 Folder, so player can read MP3 files index URLs. http://domain.com/mp3/list.php</strong>";

$mp3s = array();

$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

//$tRows = $xpath->query("//a[ends-with(@href,'.mp3')]");

$tRows = $xpath->query('//a[contains(@href, ".mp3")]//@href');

//print_r($tRows->nodeValue);

foreach ($tRows as $row) {
    // fetch all 'tds' inside this 'tr'
    //$td = $xpath->query('td', $row);
	
	if(preg_match('#http#', $row->nodeValue))
	 $nodeValue = $row->nodeValue; 
	else
	 $nodeValue = str_replace("list.php", "", $url).$row->nodeValue;
	
	//echo $row->textContent."<br>";
	//echo $nodeValue."<br>";
	
	//$mp3ss[] = $nodeValue;
	
	$mp3s[] = $nodeValue;
	
}	

return $mp3s;

}	




function readFeed($url)
{

$mp3s = array();

$html = getContents($url); 

if($html=="") echo "<strong>Player could not read MP3 files...</strong>";

//libxml_use_internal_errors( true);
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadXML( $html);

$xpath = new DOMXpath( $doc);


$images = $doc->getElementsByTagName('image');

foreach($images as $image) {

$title = $xpath->query( 'title', $image)->item(0)->nodeValue;
$url = $xpath->query( 'url', $image)->item(0)->nodeValue;
$link = $xpath->query( 'link', $image)->item(0)->nodeValue;

//echo "$title - $url - $link\n";

}

$pic = $url;


$items = $doc->getElementsByTagName('item');


foreach($items as $item) 
{

  $title = $xpath->query( 'title', $item)->item(0)->nodeValue;
  $author = $xpath->query( 'itunes:author', $item)->item(0)->nodeValue;
  $enclosure = $xpath->query( 'enclosure', $item)->item(0);
  $url = $enclosure->attributes->getNamedItem('url')->value;
  
  $mp3s[] = array("title" => MP3Title($title), "artist" => $author, "url" => $url, "pic" => $pic);
  
  
}  

return $mp3s;

}	



function readSoundCloud($url, $clientid, $clientsecret)
{

ini_set("user_agent", "SCPHP"); 
//header("Content-Type: text/html;charset=ISO-8859-1"); 

// get track data from track url 
//$track = resolve_sc_track('http://soundcloud.com/trance/sets/magix-revolta-2/');

$track = resolve_sc_track($url, $clientid, $clientsecret);

$tt = array();

foreach($track['tracks'] as $t)
{

if($t['stream_url']!="")
{
 $tt[] = array("id" => $t['id'], "title" => MP3Title($t['title']), "genre" => $t['genre'], "user" => $t['user']['username'], "permalink_url" => $t['permalink_url'], "artwork_url" => $t['artwork_url'], "stream_url" => $t['stream_url']."?consumer_key=".$clientid, "download_url" => $t['download_url']."?consumer_key=".$clientid, "playback_count" => $t['playback_count']);
}

}

//echo "<br />"; print_r($tt);

return $tt;



}	

function resolve_sc_track($url, $clientid, $clientsecret){ 
return json_decode(getContents("http://api.soundcloud.com/resolve?client_id=".$clientid."&format=json&url=".$url), true); 
} 	

 


function dotdot($html, $limit)
{

if (strlen($html) > $limit)
{
    return substr($html, 0, $limit)."...";
}
else
{
    return $html;
}  

}

function MP3Title($s)
{

$t = str_replace(".mp3", "", urldecode($s));
$t = str_replace(".MP3", "", $t);

return $t;

}


function getContent($url) {
    $curlHandler = curl_init();
    curl_setopt($curlHandler, CURLOPT_URL, $url);
    curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlHandler, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $content = curl_exec($curlHandler);
    curl_close($curlHandler);
    return $content;
}



function getContents($url) {

return file_get_contents($url);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_USERAGENT, userAgent() );
$html = curl_exec($curl) or curl_error($curl);
curl_close($curl);

if (!$html) {
    die("CURL PHP extension missing!");
}

return $html;
}


function userAgent()
{


$agents = array('Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6',
'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11',
'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)',
'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)',
'Mozilla/4.0 (compatible; MSIE 5.0; Windows NT 5.1; .NET CLR 1.1.4322)',
'Opera/9.20 (Windows NT 6.0; U; en)',
'Opera/9.00 (Windows NT 5.1; U; en)',
'Avant Browser/1.2.789rel1 (http://www.avantbrowser.com)',
'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12',
'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.10',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9',
'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)',
'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/522.11 (KHTML, like Gecko) Safari/3.0.2',
'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)',
'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/532.5 (KHTML, like Gecko) Chrome/4.0.249.0 Safari/532.5',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US) AppleWebKit/532.9 (KHTML, like Gecko) Chrome/5.0.310.0 Safari/532.9',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.7 (KHTML, like Gecko) Chrome/7.0.514.0 Safari/534.7',
'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/534.14 (KHTML, like Gecko) Chrome/9.0.601.0 Safari/534.14',
'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.20 (KHTML, like Gecko) Chrome/11.0.672.2 Safari/534.20',
'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.27 (KHTML, like Gecko) Chrome/12.0.712.0 Safari/534.27',
'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/13.0.782.24 Safari/535.1',
'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'
);


if (is_array($agents)) {
  $agent = $agents[rand(0,count($agents)-1)];
} else {
  $agent = $agents;
}


//return $agent;

return $_SERVER['HTTP_USER_AGENT'];

}


function jsWidget($u, $w=586, $h=227)
{

$jsw = '<iframe src="'.$u.'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" width="'.$w.'" height="'.$h.'"></iframe>';

return $jsw;


}

?>