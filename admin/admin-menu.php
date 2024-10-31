<?php
// Function to display Pk Favicon Manager admin settings page
function pk_show_fmanager_admin_page(){
  global $pk_fmanager;
  // Get option value from class attribute
  $pk_fmanager_options = $pk_fmanager->pkfm_options;
?>
<div id="wrap">
<h1>Pk Favicon Manager</h1>
(version <?php echo $pk_fmanager_options['pk_fm_version']; ?>)
<form action="options.php" method="post" id="PkFmanagerForm" enctype="multipart/form-data">
<?php
  $pk_fmanager->PkFmUpdateMessage();
  // Output option_page fields for a settings page.
  settings_fields('pk_fmanager_options');
  do_settings_sections('pk_fmanager');
?>
  <p>
  <strong>Please Note: </strong>Check the following tips before uploading a favicon image.<br />
  <strong>Standard Resolutions: </strong>16x16, 32x32, 48x48, 96x96, 180x180 OR 192x192 | <strong>Format: </strong>.png, .gif or .ico | <strong>Size: </strong>Maximum 25kb or less to minimize website loading time.<br />
  </p>
  <p><input type="submit" name="submit" class="button-primary" name="pk_fm_form_save" value="Save Changes" /></p>
</form>
<hr />
<p><strong>Thank you for installing and using Pk Favicon Manager WordPress plugin.</strong><br />
<ul>
<li>Share your experience by rating the plugin.</li>
<li>Provide your valuable feedback and suggestions to improve the quality of this plugin.</li>
<li>Test this plugin in different WordPress versions and vote in the Compatibility section, so that other users can check compatibility and download appropriate version.</li>
<li>Browse and install more <a href="https://pkplugins.com/" title="Free WordPress Plugins for your website at pkplugins.com">Free WordPress Plugins for your website.</a></li>
</ul>
</p>
</div>
<?php
}

// Display admin menu function
function pkfm_add_admin_menu(){
// Adds a main menu on left column.
add_menu_page(
'FaviconManager', 'FaviconManager',
'manage_options', 'pk_fmanager', 'pk_show_fmanager_admin_page',
'dashicons-format-image', null
);
}
// Call function to display admin menu
add_action('admin_menu','pkfm_add_admin_menu');

?>