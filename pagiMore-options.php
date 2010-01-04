<?php
### Variables
$base_name = plugin_basename('wp-pagiMore/pagiMore-options.php');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);
$pagiMore_settings = array('pagiMore_options');

### Form Processing 
// Update Options
if(!empty($_POST['Submit'])) {
	$pagiMore_options = array();
	$pagiMore_options['current_text'] = addslashes($_POST['pagiMore_current_text']);
	$pagiMore_options['page_text'] = addslashes($_POST['pagiMore_page_text']);
	$update_pagiMore_queries = array();
	$update_pagiMore_text = array();
	$update_pagiMore_queries[] = update_option('pagiMore_options', $pagiMore_options);
	$update_pagiMore_text[] = __('pagiMore options', 'wp-pagiMore');
	$i=0;
	$text = '';
	foreach($update_pagiMore_queries as $update_pagiMore_query) {
		if($update_pagiMore_query) {
			$text .= '<font color="green">'.$update_pagiMore_text[$i].' '.__('Updated', 'wp-pagiMore').'</font><br />';
		}
		$i++;
	}
	if(empty($text)) {
		$text = '<font color="red">'.__('pagiMore not updated', 'wp-pagiMore').'</font>';
	}
}

### Determines Which Mode It Is
switch($mode) {
	// Main Page
	default:
	$pagiMore_options = get_option('pagiMore_options');
  
if(!empty($text)) {
    echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>';
    }
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>">
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e('pagiMore options', 'wp-pagiMore'); ?></h2>
		<h3><?php _e('Page Navigation Text', 'wp-pagiMore'); ?></h3>
		<table class="form-table">
			<tr>
				<th scope="row" valign="top"><?php _e('Text for current page', 'wp-pagiMore'); ?></th>
				<td>
					<input type="text" name="pagiMore_current_text" value="<?php echo stripslashes(htmlspecialchars($pagiMore_options['current_text'])); ?>" size="30" /><br />
					%PAGE_NUMBER% - <?php _e('The page number.', 'wp-pagiMore'); ?><br />
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top"><?php _e('Text for page number', 'wp-pagiMore'); ?></th>
				<td>
					<input type="text" name="pagiMore_page_text" value="<?php echo stripslashes(htmlspecialchars($pagiMore_options['page_text'])); ?>" size="30" /><br />
					%PAGE_NUMBER% - <?php _e('The page number.', 'wp-pagiMore'); ?><br />
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'wp-pagiMore'); ?>" />
		</p>
	</div>
</form>
<?php
} // End switch($mode)
?>