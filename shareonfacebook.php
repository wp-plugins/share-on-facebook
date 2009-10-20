<?php
/*
Plugin Name: Share On Facebook
Version: 1.2
Plugin URI: http://nothing.golddave.com/?page_id=680
Description: Adds a footer link to add the current post or page to as a Facebook link.
Author: David Goldstein
Author URI: http://nothing.golddave.com/
*/

/*
Change Log

1.2
  * Reworked with valid XHTML.
  * Integrated redundant code.
  * Updated styles for the button.

1.1
  * Fixed bug in template tag implementation.

1.0
  * First public release.
*/ 

function share_on_facebook($data = ''){
	global $post;
	$current_options = get_option('share_on_facebook_options');
	$url = 'http://www.facebook.com/share.php?u=' . rawurlencode(get_permalink($post->ID)) . '&amp;t=' . rawurlencode(get_post($post->ID)->post_title);
	$basestyle = "font-size:11px; line-height:13px; font-family:'lucida grande',tahoma,verdana,arial,sans-serif; text-decoration:none;";
	switch ($current_options['link_type']) {
		case "link":
			$data .= <<< HTML
<a href="$url" id="facebook_share_link">Share on Facebook</a>
HTML;
			break;
		case "icon":
			$data .= <<< HTML
<a href="$url" id="facebook_share_icon" style="$basestyle"><img src="http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif" alt="Share on Facebook" /></a>
HTML;
			break;
		case "both":
			$data .= <<< HTML
<a href="$url" id="facebook_share_both" style="$basestyle padding:2px 0 0 20px; height:16px; background:url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif) no-repeat top left;">Share on Facebook</a>
HTML;
			break;
		case "button":
			$sharebuttoncode = <<< HTML
<a href="$url" id="facebook_share_button" style="$basestyle display: -moz-inline-block; display:inline-block; padding:1px 20px 0 5px; margin: 5px 0; height:15px; border:1px solid #d8dfea; color: #3B5998; background: #fff url(http://b.static.ak.fbcdn.net/images/share/facebook_share_icon.gif) no-repeat top right;">Share</a>
HTML;
$alldata=$sharebuttoncode.$data;
$data=$alldata;
			break;
		}
	$data .= <<< HTML

<script type="text/javascript">
var button = document.getElementById('facebook_share_link') || document.getElementById('facebook_share_icon') || document.getElementById('facebook_share_both') || document.getElementById('facebook_share_button');
if (button) {
	button.onclick = function(e) {
		var url = this.href.replace(/share\.php/, 'sharer.php');
		window.open(url,'sharer','toolbar=0,status=0,width=626,height=436');
		return false;
	}

	if (button.id === 'facebook_share_button') {
		button.onmouseover = function(){
			this.style.color='#fff';
			this.style.borderColor = '#295582';
			this.style.backgroundColor = '#3b5998';
		}
		button.onmouseout = function(){
			this.style.color = '#3b5998';
			this.style.borderColor = '#d8dfea';
			this.style.backgroundColor = '#fff';
		}
	}
}
</script>

HTML;
		return $data;
}

function activate_share_on_facebook(){
	global $post;
	$current_options = get_option('share_on_facebook_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype !== 'template'){
		add_filter('the_content', 'share_on_facebook', 10);
		add_filter('the_excerpt', 'share_on_facebook', 10);
	}
}

activate_share_on_facebook();

function shareonfacebook(){
	global $post;
	$current_options = get_option('share_on_facebook_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype !== 'auto'){
		echo share_on_facebook();
	}
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
						<option value="link" <?php if ($link === "link") echo 'selected="selected"';?>>Link Only</option>
						<option value="icon" <?php if ($link === "icon") echo 'selected="selected"';?>>Icon Only</option>
						<option value ="both" <?php if ($link === "both") echo 'selected="selected"';?>>Link and Icon</option>
						<option value ="button" <?php if ($link === "button") echo 'selected="selected"';?>>Share Button</option>
						</select></td>
					</tr>
					<tr>
						<th valign="top" scope="row"><label for="insertion_type">Insertion Type:</label></th>
						<td><select name="insertion_type">
						<option value ="auto" <?php if ($insert === "auto") echo 'selected="selected"';?>>Auto</option>
						<option value ="template"<?php if ($insert === "template") echo 'selected="selected"';?>>Template</option>
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