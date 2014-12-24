<?php

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

/*
Plugin Name: HTML5Tap Free
Plugin URI: http://www.html5tap.com
Description: HTML5Tap Players enable native audio playback within the browser. It supports all browsers i.e. iOS, Android, Firefox, Chrome, Safari, IE and Opera.
Version: 2.3
Author: SVNLabs Softwares
Author URI: http://www.html5tap.com
License: GPLv2
*/

include_once("functions.php");

// Create HTML5Tap Custom Post Type
add_action( 'init', 'create_html5tap_types' );
 
function create_html5tap_types() {
    register_post_type( 'html5tap',
        array(
            'labels' => array(
                'name' => __( 'HTML5Tap' ),
                'singular_name' => __( 'HTML5Tap' ),
                'new_item' => __( 'New HTML5Tap' ),
                'add_new_item' => __( 'Add New HTML5Tap' )
            ),
            'public' => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
            'hierarchical' => false,
            'supports' => array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
            'register_meta_box_cb' => 'add_html5tap_metaboxes' // This registers the metabox that we'll add later.
        )
    );
}


add_filter( 'manage_posts_columns', 'my_edit_html5tap_columns' ) ;
add_action('manage_posts_custom_column', 'ST4_columns_content1', 10, 2);

function my_edit_html5tap_columns( $columns ) {
global $post;
if($post->post_type == "html5tap")
{

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'HTML5Tap' ),
		'_shortcode' => __( 'Shortcode' ),
		'_version' => __( 'Album' ),
		'date' => __( 'Date' )
	);
}
	return $columns;
}

function ST4_columns_content1($column_name, $post_ID) {
global $post;


$_version = get_post_meta($post->ID, '_version', true);
$_thumbnail = get_post_meta($post->ID, '_thumbnail', true);

    if (($column_name == '_shortcode')&&($post->post_type == "html5tap")) {
	
      echo "[html5tap id=".$post->ID."]";
	 
    }
	
	if ($column_name == '_version') {
      echo $_version;
    }
	
	
	
}

//Custom Taxonomies
 
add_action( 'init', 'create_genres' );
function create_genres() {
 $labels = array(
    'name' => _x( 'Genres', 'taxonomy general name' ),
    'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Genres' ),
    'all_items' => __( 'All Genres' ),
    'parent_item' => __( 'Parent Genre' ),
    'parent_item_colon' => __( 'Parent Genre:' ),
    'edit_item' => __( 'Edit Genre' ),
    'update_item' => __( 'Update Genre' ),
    'add_new_item' => __( 'Add New Genre' ),
    'new_item_name' => __( 'New Genre' ),
  );
 
  register_taxonomy('genres','html5tap',array(
    'hierarchical' => true,
    'labels' => $labels,
    "public" => "true"
  ));
}



// Create Meta boxes
 
function add_html5tap_metaboxes() {
    add_meta_box('html5tap_info', 'HTML5Tap Information', 'html5tap_info', 'html5tap', 'normal', 'high');
	add_meta_box('html5tap_info_side', 'HTML5Tap Album', 'html5tap_info_side', 'html5tap', 'side', 'high');
	add_meta_box('metabox_sourceType', 'Source Type', 'metabox_sourceType', 'html5tap', 'normal', 'high');
	add_meta_box('metabox_playlist', 'Songs Playlist', 'metabox_playlist', 'html5tap', 'normal', 'high');
	add_meta_box('metabox_embed', 'Embed Information', 'metabox_embed', 'html5tap', 'normal', 'high');
}
 
// HTML5Tap Meta Box
function metabox_embed()
{
	 global $post;
	 
	 
	 
	$embedFull =  htmlentities(jsWidget('http://player.html5tap.com/v1/html5full.html?jdata='.urlencode(get_the_permalink($post->ID)) ) );
	
	$embedBig =  htmlentities(jsWidget('http://player.html5tap.com/v1/html5big.html?jdata='.urlencode(get_the_permalink($post->ID)), 347, 414) );
	 
    //echo '<em>Adjust iFrame Width & Height to fit on page.</em>';
    echo '<textarea cols="100" rows="3" name="embed">'.$embedFull.'</textarea>';
	echo '<textarea cols="100" rows="3" name="embed">'.$embedBig.'</textarea>';
}



function metabox_playlist()
{

	global $post;
	
	$_title = get_post_meta($post->ID, '_title', true);
	$_artist = get_post_meta($post->ID, '_artist', true);
	$_song = get_post_meta($post->ID, '_song', true);
	$_artwork = get_post_meta($post->ID, '_artwork', true);
	
	include(dirname( __FILE__ ) . "/playlist.php");

}

function metabox_sourceType()
{
	
	global $post;
	$sourceurl = get_post_meta($post->ID, '_sourceurl', true);
	$sourcetype = get_post_meta($post->ID, '_sourcetype', true);
	$clientid = get_post_meta($post->ID, '_clientid', true);
	$clientsecret = get_post_meta($post->ID, '_clientsecret', true);
	
	?>
Source Type:	<select name="_sourcetype" id="_sourcetype" onchange="sel_source(this.value);">
	<option value="default" <?php if($sourcetype=="default"){ ?>selected="selected"<?php } ?>>Default Playlist</option>
	<option value="folder" <?php if($sourcetype=="folder"){ ?>selected="selected"<?php } ?>>MP3 Folder URL</option>
	<option value="feed" <?php if($sourcetype=="feed"){ ?>selected="selected"<?php } ?>>Feedburner URL</option>
	<option value="soundcloud" <?php if($sourcetype=="soundcloud"){ ?>selected="selected"<?php } ?>>SoundCloud Sets URL</option>
	</select>	
	

	

    
    <br /><br />

	

<div id="other" style="display:<?php if($sourcetype == "folder" || $sourcetype == "feed" || $sourcetype == "soundcloud") { ?>block<?php } else { ?>none<?php } ?>">

Source URL:&nbsp;&nbsp;<input type="text" id="_sourceurl" name="_sourceurl" value="<?php echo $sourceurl; ?>" size="100" /><br /><br />

</div>


<div id="soundcloud" style="display:<?php if($sourcetype == "soundcloud") { ?>block<?php } else { ?>none<?php } ?>">

<?php /*?>SoundCloud Set URL: <input type="text" id="sourceurl" name="sourceurl" value="<?php echo $sourceurl; ?>" size="100" /><br /><br /><?php */?>

Client ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="_clientid" id="_clientid" class="regular-text" value="<?php echo $clientid; ?>"> <br /><br />

Client Secret: <input type="text" name="_clientsecret" id="_clientsecret" class="regular-text" value="<?php echo $clientsecret; ?>"> <br /><br />

</div>

<input name="Submit" type="button" value="Capture"  onClick="playlistSourceType()" />


<?php 

wp_register_script('html5tapfree', plugins_url( '/html5tapfree.js', __FILE__ ), false, '1.6', false );
//wp_register_script('radioforge1');

wp_localize_script( 'html5tapfree', 'plugin_dir_url', plugin_dir_url(__FILE__) );
wp_enqueue_script( 'html5tapfree' );

	
}


function html5tap_info_side() {
global $post;

//echo "Side Goes Here.....";
$_version = get_post_meta($post->ID, '_version', true);

echo '<input class="widefat" name="_version" type="text" value="' . $_version  . '" />';

}
 
function html5tap_info() {
    global $post;
 
    // Noncename needed to verify where the data originated
    echo '<input id="html5tapmeta_noncename" name="html5tapmeta_noncename" type="hidden" value="' .     wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
 
    // Get the data if its already been entered
    $date = get_post_meta($post->ID, '_date', true);
    $seriesimg = get_post_meta($post->ID, '_seriesimg', true);
    $thumbnail = get_post_meta($post->ID, '_thumbnail', true);
    $description = get_post_meta($post->ID, '_description', true);
	$sourceurl = get_post_meta($post->ID, '_sourceurl', true);
	$sourcetype = get_post_meta($post->ID, '_sourcetype', true);
	$clientid = get_post_meta($post->ID, '_clientid', true);
	$clientsecret = get_post_meta($post->ID, '_clientsecret', true);
 
    // Echo out the field
	echo '<strong>Date</strong><br /><em>Enter the Date the html5tap was preached.</em>';
	echo '<input class="widefat" name="_date" type="text" value="' . $date  . '" />';
	echo '<strong>Series Image</strong><br /><em>Add a series image. Images can be uploaded using the "Add an Image" box above the editing window. <strong>Images should be 200x112 pixels</strong></em>';
	echo '<input class="widefat" name="_seriesimg" type="text" value="' . $seriesimg  . '" />';
	echo '<strong>Thumbnail</strong><br /><em>Enter the thumbnail image you\'d like to display on the media archives list. Images can be uploaded using the "Add an Image" box above the editing window.<strong>Images should be 100x56 pixels</strong></em>';
	echo '<input class="widefat" name="_thumbnail" type="text" value="' . $thumbnail  . '" />';
	echo '<strong>Description</strong><br /><em>Enter the text you\'d like to display as a description on the media archives list.</em>';
	echo '<input class="widefat" name="_description" type="text" value="' . $description  . '" />';
	
 
}
 
// Save the Meta box Data
 
function save_html5tap_meta($post_id, $post) {
 
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( @$_POST['html5tapmeta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
 
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
 
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
	
	
	$html5tap_meta['_title'] = $_POST['_title'];
	$html5tap_meta['_artist'] = $_POST['_artist'];
	$html5tap_meta['_song'] = $_POST['_song'];
	$html5tap_meta['_artwork'] = $_POST['_artwork'];
	$html5tap_meta['_sourceurl'] = $_POST['_sourceurl'];
	$html5tap_meta['_sourcetype'] = $_POST['_sourcetype'];
	$html5tap_meta['_clientid'] = $_POST['_clientid'];
	$html5tap_meta['_clientsecret'] = $_POST['_clientsecret'];
	
	
 
    $html5tap_meta['_date'] = $_POST['_date'];
	$html5tap_meta['_version'] = $_POST['_version'];
    $html5tap_meta['_thumbnail'] = $_POST['_thumbnail'];
    $html5tap_meta['_seriesimg'] = $_POST['_seriesimg'];
    $html5tap_meta['_description'] = $_POST['_description'];
	
	
    //print_r($_POST); die;
	
	
    // Add values of $html5tap_meta as custom fields
 
    foreach ($html5tap_meta as $key => $value) { // Cycle through the $html5tap_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        
		//$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		
		if(is_array($value))
		 $value = base64_encode(serialize($value)); // If $value is an array, serialize
        
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a valuesave_html5tap_meta
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		
		
		
    }
	
	
	    $_title = get_post_meta($post->ID, '_title', true);
		$_artist = get_post_meta($post->ID, '_artist', true);
		$_song = get_post_meta($post->ID, '_song', true);
		$_artwork = get_post_meta($post->ID, '_artwork', true);
		
		$pid = $post->ID;
		
		
	
	
 
}
add_action('save_post','save_html5tap_meta', 1, 2); // save the custom fields




/* Extra Menu Item */

add_action('admin_menu' , 'brdesign_enable_pages');

function brdesign_enable_pages() {
add_submenu_page('edit.php?post_type=html5tap', 'HTML5Tap Help', 'Help', 'edit_posts', 'help', 'custom_function');


}

function custom_function()
{

echo "Help Goes Here...";

}

/* Extra Menu Item */


add_filter('single_template','html5tap_template',20);

function html5tap_template($single)
{

     global $wp_query, $post;
	 
	 if ($post->post_type == "html5tap"){
 
     $single_template = dirname( __FILE__ ) . '/single.php';
     
     return $single_template;
	 
	 }
	 
	 return $single;

}




add_action( 'template_redirect', 'html5tap_my_callback' );
 
function html5tap_my_callback() {

global $post, $wpdb;

$_title = get_post_meta($post->ID, '_title', true);
$_artist = get_post_meta($post->ID, '_artist', true);
$_song = get_post_meta($post->ID, '_song', true);
$_artwork = get_post_meta($post->ID, '_artwork', true);

  if ( isset($_REQUEST['embed']) && $_REQUEST['embed']!="" ) {
    include( dirname( __FILE__ ) . '/embed.php' );
    exit();
  }
  
}



add_shortcode( 'html5tap', 'html5tapfree_player' );

function html5tapfree_player($atts = null, $content = null) {

global $wp_query, $post;
	 
if ($post->post_type != "html5tap"){


echo jsWidget('http://player.html5tap.com/v1/html5full.html?jdata='.urlencode(get_the_permalink($atts['id'])) );


}
}


$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_{$plugin}", 'upgrade_to_pro');


function upgrade_to_pro($links) { 

	if (function_exists('is_plugin_active') && !is_plugin_active('html5tap/html5tap.php')) {

		$links[] = '<a href="http://www.html5tap.com/upgrade" target="_blank">' . __("Go Pro", "metaslider") . '</a>'; 

	}

	return $links; 

}

?>