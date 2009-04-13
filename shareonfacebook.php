<?php
/*
Plugin Name: Share On Facebook
Version: 1.1
Plugin URI: http://nothing.golddave.com/?page_id=680
Description: Adds a footer link to add the current post or page to as a Facebook link.
Author: David Goldstein
Author URI: http://nothing.golddave.com/
*/

/*
Change Log

1.1
  * Fixed bug in template tag implementation.

1.0
  * First public release.
*/ 

function share_on_facebook($data){
	global $post;
	$current_options = get_option('share_on_facebook_options');
	$linktype = $current_options['link_type'];
	switch ($linktype) {
		case "link":
			$data=$data."<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)."\" onclick=\"return fbs_click()\" target=\"_blank\">Share on Facebook</a>";
			break;
		case "icon":
			$data=$data."<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)." \"onclick=\"return fbs_click()\" target=\"_blank\"><img src=\"http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981\" alt=\"\" /></a>";
			break;
		case "both":
			$data=$data."<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'_blank','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_link { padding:2px 0 0 20px; height:16px; background:url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top left; }</style><a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)." \" onclick=\"return fbs_click()\" target=\"_blank\" class=\"fb_share_link\">Share on Facebook</a>";
			break;
		case "button":
			$data=$data."<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_button { display: -moz-inline-block; display:inline-block; padding:1px 20px 0 5px; height:15px; border:1px solid #d8dfea; background:url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top right; } html .fb_share_button:hover { color:#fff; border-color:#295582; background:#3b5998 url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top right; text-decoration:none; } </style> <a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)." \" class=\"fb_share_button\" onclick=\"return fbs_click()\" target=\"_blank\" style=\"text-decoration:none;\">Share</a>";
			break;
		}
		echo $data;
}

function activate_share_on_facebook(){
	global $post;
	$current_options = get_option('share_on_facebook_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype != 'template'){
		add_filter('the_content', 'share_on_facebook', 10);
		add_filter('the_excerpt', 'share_on_facebook', 10);
	}
}

activate_share_on_facebook();

function shareonfacebook(){
	global $post;
	$current_options = get_option('share_on_facebook_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype != 'auto'){
		$linktype = $current_options['link_type'];
		switch ($linktype) {
			case "link":
				echo "<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)."\" onclick=\"return fbs_click()\" target=\"_blank\">Share on Facebook</a>";
				break;
			case "icon":
				echo "<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)." \"onclick=\"return fbs_click()\" target=\"_blank\"><img src=\"http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981\" alt=\"\" /></a>";
				break;
			case "both":
				echo "<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'_blank','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_link { padding:2px 0 0 20px; height:16px; background:url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top left; }</style><a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)." \" onclick=\"return fbs_click()\" target=\"_blank\" class=\"fb_share_link\">Share on Facebook</a>";
				break;
			case "button":
				echo "<script>function fbs_click() {u=".get_permalink($post->ID).";t=".get_post($post->ID)->post_title.";window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_button { display: -moz-inline-block; display:inline-block; padding:1px 20px 0 5px; height:15px; border:1px solid #d8dfea; background:url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top right; } html .fb_share_button:hover { color:#fff; border-color:#295582; background:#3b5998 url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif?8:26981) no-repeat top right; text-decoration:none; } </style> <a href=\"http://www.facebook.com/share.php?u=".get_permalink($post->ID)." \" class=\"fb_share_button\" onclick=\"return fbs_click()\" target=\"_blank\" style=\"text-decoration:none;\">Share</a>";
				break;
			}
		}
		return $data;
}

// Create the options page
function share_on_facebook_options_page() { 
	$current_options = get_option('share_on_facebook_options');
	$link = $current_options["link_type"];
	$insert = $current_options["insertion_type"];
	if ($_POST['action']){ ?>
		<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
	<?php } ?>
	<div class="wrap" id="share-on-facebook-options">
		<h2>Share on Facebook Options</h2>
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				<legend>Options:</legend>
				<input type="hidden" name="action" value="save_share_on_facebook_options" />
				<table width="100%" cellspacing="2" cellpadding="5" class="editform">
					<tr>
						<th valign="top" scope="row"><label for="link_type">Link Type:</label></th>
						<td><select name="link_type">
						<option value ="link"<?php if ($link == "link") { print " selected"; } ?>>Link Only</option>
						<option value ="icon"<?php if ($link == "icon") { print " selected"; } ?>>Icon Only</option>
						<option value ="both"<?php if ($link == "both") { print " selected"; } ?>>Link and Icon</option>
						<option value ="button"<?php if ($link == "button") { print " selected"; } ?>>Share Button</option>
						</select></td>
					</tr>
					<tr>
						<th valign="top" scope="row"><label for="insertion_type">Insertion Type:</label></th>
						<td><select name="insertion_type">
						<option value ="auto"<?php if ($insert == "auto") { print " selected"; } ?>>Auto</option>
						<option value ="template"<?php if ($insert == "template") { print " selected"; } ?>>Template</option>
						</select></td>
					</tr>
				</table>
			</fieldset>
			<p class="submit">
				<input type="submit" name="Submit" value="Update Options &raquo;" />
			</p>
		</form>
	</div>
<?php 
}

function share_on_facebook_add_options_page() {
	// Add a new menu under Options:
	add_options_page('Share on Facebook', 'Share on Facebook', 10, __FILE__, 'share_on_facebook_options_page');
}

function share_on_facebook_save_options() {
	// create array
	$share_on_facebook_options["link_type"] = $_POST["link_type"];
	$share_on_facebook_options["insertion_type"] = $_POST["insertion_type"];
	
	update_option('share_on_facebook_options', $share_on_facebook_options);
	$options_saved = true;
}

add_action('admin_menu', 'share_on_facebook_add_options_page');

if (!get_option('share_on_facebook_options')){
	// create default options
	$share_on_facebook_options["link_type"] = 'link';
	$share_on_facebook_options["insertion_type"] = 'auto';
	
	update_option('share_on_facebook_options', $share_on_facebook_options);
}

if ($_POST['action'] == 'save_share_on_facebook_options'){
	share_on_facebook_save_options();
}
?>