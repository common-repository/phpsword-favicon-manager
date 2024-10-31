<?php

// Restrict direct access to the file
if(!defined('ABSPATH')){ exit; }

// Start: Pk Favicon Manager class
class PkFaviconManager {

// Attribute to hold option values
public $pkfm_options, $default_favicon, $favicon_dir, $favicon_url;

// Constructor method
public function __construct() {
  $this->pkfm_options = get_option('pk_fmanager_options');
  $this->default_favicon = WP_PLUGIN_URL.'/phpsword-favicon-manager/images/pkfm_favicon.png';
  $this->favicon_dir = WP_PLUGIN_DIR.'/phpsword-favicon-manager/favicons/';
  $this->favicon_url = WP_PLUGIN_URL.'/phpsword-favicon-manager/favicons/';
  if(is_admin()){
	// Register settings & fields
	add_action('admin_init', array($this, 'register_settings_and_fields'));
	// Display Favicon on the website (for admin)
	add_action('admin_head', array($this, 'show_pk_fmanager_favicon'));
  }
  // Display Favicon on the website
  add_action('wp_head', array($this, 'show_pk_fmanager_favicon'));
}

// Register group, section and fields
public function register_settings_and_fields() {
register_setting('pk_fmanager_options', 'pk_fmanager_options', array($this, 'PhpswFMValidateSettings'));
add_settings_section('pkfm_section', 'Pk Favicon Manager Settings', array($this, 'pkfm_section_callback_function'), 'pk_fmanager');
add_settings_field('pk_fav_status', 'Display Favicon: ', array($this, 'FavStatusSetting'), 'pk_fmanager', 'pkfm_section');
add_settings_field('pk_fav_url1', 'Favicon Image 1: ', array($this, 'PkFavImg1Setting'), 'pk_fmanager', 'pkfm_section');
add_settings_field('pk_fav_url2', 'Favicon Image 2: ', array($this, 'PkFavImg2Setting'), 'pk_fmanager', 'pkfm_section');
add_settings_field('PkFmActiveFavicon', 'Choose Favicon: ', array($this, 'PkFmActiveFaviconSetting'), 'pk_fmanager', 'pkfm_section');
}

// pkfm_section callback function
public function pkfm_section_callback_function() {
}

// Validate submitted images and upload
public function PhpswFMValidateSettings($options) {
  $options['pk_fm_version'] = $this->pkfm_options['pk_fm_version'];
  $options['pk_fm_version_type'] = $this->pkfm_options['pk_fm_version_type'];
if(!empty($_FILES['pk_fav_url1']['tmp_name'])){
  $src_file = $_FILES['pk_fav_url1']['tmp_name'];
  $dest_file = $this->favicon_dir . $_FILES['pk_fav_url1']['name'];
  $src_file_url = $this->favicon_url . $_FILES['pk_fav_url1']['name'];
  if(move_uploaded_file($src_file, $dest_file)){
	$options['pk_fav_url1'] = $src_file_url;	
  } else { $options['pk_fav_url1'] = $this->pkfm_options['pk_fav_url1']; }
} else { $options['pk_fav_url1'] = $this->pkfm_options['pk_fav_url1']; }
if(!empty($_FILES['pk_fav_url2']['tmp_name'])) {
  $src_file = $_FILES['pk_fav_url2']['tmp_name'];
  $dest_file = $this->favicon_dir . $_FILES['pk_fav_url2']['name'];
  $src_file_url = $this->favicon_url . $_FILES['pk_fav_url2']['name'];
  if(move_uploaded_file($src_file, $dest_file)){
	$options['pk_fav_url2'] = $src_file_url;
  } else { $options['pk_fav_url2'] = $this->pkfm_options['pk_fav_url2']; }
} else { $options['pk_fav_url2'] = $this->pkfm_options['pk_fav_url2']; }
  return $options;
}

// Enable or Disable favicon field
public function FavStatusSetting(){
echo '<select name="pk_fmanager_options[pk_fav_status]">';
echo '<option value="1"';
if(!empty($this->pkfm_options['pk_fav_status']) && ($this->pkfm_options['pk_fav_status']=='1'))
{ echo ' Selected '; } echo '>Enable</option>';
echo '<option value="2"';
if(!empty($this->pkfm_options['pk_fav_status']) && ($this->pkfm_options['pk_fav_status']=='2'))
{ echo ' Selected '; } echo '>Disable</option>';
echo '</select>';
}

// Favicon image 1 upload field
public function PkFavImg1Setting(){
echo '<input type="file" name="pk_fav_url1" id="pk_fav_url1" />';
echo '&nbsp; &nbsp; &nbsp;';
if(isset($this->pkfm_options['pk_fav_url1'])){
echo "<img src=\"".$this->pkfm_options['pk_fav_url1']."\" alt=\"Favicon Image 1\" class=\"pk_fav_preview\" width=\"32\" height=\"32\" />";
} else { echo "<img src=\"{$this->default_favicon}\" alt=\"Favicon Image 1\" width=\"32\" height=\"32\" />"; }
}

// Favicon image 2 upload field
public function PkFavImg2Setting(){
echo '<input type="file" name="pk_fav_url2" id="pk_fav_url2" />';
echo '&nbsp; &nbsp; &nbsp;';
if(isset($this->pkfm_options['pk_fav_url2'])){
echo "<img src=\"".$this->pkfm_options['pk_fav_url2']."\" alt=\"Favicon Image 2\" class=\"pk_fav_preview\" width=\"32\" height=\"32\" />";
} else { echo "<img src=\"{$this->default_favicon}\" alt=\"Favicon Image 2\" width=\"32\" height=\"32\" />"; }
}

// Select favicon image field
public function PkFmActiveFaviconSetting(){
echo '<input type="radio" name="pk_fmanager_options[pk_active_favicon]" id="pk_fmanager_options[pk_active_favicon]" value="img1"';
if(isset($this->pkfm_options['pk_active_favicon']) && $this->pkfm_options['pk_active_favicon']=='img1')
{ echo ' Checked'; } echo '/> Favicon Image 1';
echo '&nbsp; &nbsp; &nbsp;';
echo '<input type="radio" name="pk_fmanager_options[pk_active_favicon]" id="pk_fmanager_options[pk_active_favicon]" value="img2"';
if(isset($this->pkfm_options['pk_active_favicon']) && $this->pkfm_options['pk_active_favicon']=='img2')
{ echo ' Checked'; } echo '/> Favicon Image 2';
}

// Update message
public function PkFmUpdateMessage(){
if( $_GET['page'] == 'pk_fmanager' && ( (isset($_GET['updated']) && $_GET['updated'] == 'true') || ( isset($_GET['settings-updated']) &&  $_GET['settings-updated'] == 'true') )){

?>
<div id="setting-error-settings_updated" class="updated settings-error">
<p><strong>Settings Saved Successfully!</strong></p>
</div>
<?php
}
}

// Display Favicon on the website
public function show_pk_fmanager_favicon(){
$pk_fm_options = $this->pkfm_options;
  // If favicon display enabled
  if($pk_fm_options['pk_fav_status'] == '1'){
	$active_favicon = $pk_fm_options['pk_active_favicon'];
	switch($active_favicon){
	case 'default': $pk_favicon_url = $this->default_favicon; break;
	case 'img1': $pk_favicon_url = $pk_fm_options['pk_fav_url1']; break;
	case 'img2': $pk_favicon_url = $pk_fm_options['pk_fav_url2']; break;
	default: $pk_favicon_url = $this->default_favicon; break;
	}
	echo '<!-- Pk Favicon Manager by pkplugins.com -->';
	echo '<link rel="shortcut icon" href="' . $pk_favicon_url . '" />';
  }
}

}
// End: Pk Favicon Manager class

// Initialize the class
$pk_fmanager = new PkFaviconManager();

?>