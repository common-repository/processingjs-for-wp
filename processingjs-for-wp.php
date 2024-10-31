<?php
/*
Plugin Name: ProcessingJS for WP
Plugin URI: http://cagewebdev.com/pjs4wp
Description: Directly write Processing.js code in your post / page or include an existing .pde sketch
Version: 1.2.2
Date: 06/21/2018
Author: Rolf van Gelder
Author URI: http://cagewebdev.com/
License: GPL2
*/

/***********************************************************************************************
 *
 *	USAGE:
 *
 *	You can use the shorttag [pjs4wp] ... [/pjs4wp] in two different ways:
 *
 *	1) Put the actual ProcessingJS code directly in a post or page, for instance:
 *
 *	[pjs4wp]
 *	void setup()
 *	{
 *		size(200, 200);
 *		text("Hello world!", 50, 50);
 * 	}
 * 	[/pjs4wp]
 *
 *	2) Use an existing ProcessingJS .pde sketch like this:
 *
 *	[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#000"][/pjs4wp]
 ***********************************************************************************************/


/***********************************************************************************************
 *
 * 	MAIN CLASS
 *
 ***********************************************************************************************/
global $pjs4wp_class;
$pjs4wp_class = new Pjs4wp;
 
class Pjs4wp {
	/*******************************************************************************************
	 *
	 * 	PROPERTIES
	 *
	 *******************************************************************************************/	
	// VERSION
	var $pjs4wp_version      = '1.2.2';
	var $pjs4wp_release_date = '06/21/2018';
	
	// MINIFYING?
	var $odb_minify;	
		
	/*******************************************************************************************
	 *
	 * 	CONSTRUCTOR
	 *
	 *******************************************************************************************/
	function __construct() {
		// USE THE NON-MINIFIED VERSION OF SCRIPTS AND STYLE SHEETS WHILE DEBUGGING
		$this->pjs4wp_minify = (defined('WP_DEBUG') && WP_DEBUG) ? '' : '.min';		
		
		if($this->pjs4wp_is_fontend_page()) {
			// FRONTEND
			add_action('init', array($this, 'pjs4wp_load_scripts'));
			// ADD SHORTCODE
			add_shortcode('pjs4wp', array($this, 'pjs4wp_add_code'));
			// NO SMART QUOTES AND SUCH...		
			remove_filter('the_content', 'wptexturize');
			add_filter('the_content', 'wptexturize', 99);			
		} else {
			// BACKEND
			add_action('init', array($this, 'pjs4wp_load_styles'));			
			// ADD A LINK TO THE INSTRUCTIONS PAGE ON THE PLUGINS MAIN PAGE
			add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'pjs4wp_settings_link'));
			// ADD A (HIDDEN) LINK TO THE ADMIN MENU (to create the http://.../wp-admin/options-general.php?page=pjs4wp_instructions page)
			add_action('admin_menu', array($this, 'pjs4wp_instructions_link'));
		} // if($this->pjs4wp_is_fontend_page())
	} // __construct()


	/*******************************************************************************************
	 *
	 *	LOAD THE SCRIPTS
	 *
	 *******************************************************************************************/ 
	function pjs4wp_load_scripts() {
		wp_deregister_script('pjs4wp');
		wp_enqueue_script('pjs4wp', plugins_url('/js/processing.min.js', __FILE__ ), false, '1.4.8');	
	} // pjs4wp_load_scripts()


	/*******************************************************************************************
	 *
	 *	LOAD THE STYLES
	 *
	 *******************************************************************************************/ 
	function pjs4wp_load_styles() {
		wp_register_style('pjs4wp-style'.$this->pjs4wp_version, plugins_url('css/style'.$this->pjs4wp_minify.'.css', __FILE__));
		wp_enqueue_style('pjs4wp-style'.$this->pjs4wp_version);			
	}

	/*******************************************************************************************
	 *
	 *	SHOW A LINK TO THE INSTRUCTIONS PAGE ON THE MAIN PLUGINS PAGE
	 *
	 *******************************************************************************************/ 
	function pjs4wp_settings_link($links) { 
	  array_unshift($links, '<a href="options-general.php?page=pjs4wp_instructions">'.__('Instructions', 'pjs4wp').'</a>'); 
	  return $links;
	} // pjs4wp_settings_link()
	

	/*******************************************************************************************
	 *
	 * 	IS THIS A FRONTEND PAGE?
	 *
	 *******************************************************************************************/
	function pjs4wp_is_fontend_page() {
		if (isset($GLOBALS['pagenow']))
			return !is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
		else
			return !is_admin();
	} // pjs4wp_is_regular_page()


	/*******************************************************************************************
	 *
	 *	ADD THE INSTRUCTIONS TO THE SETTINGS MENU
	 *
	 *******************************************************************************************/ 
	function pjs4wp_instructions_link() {
		if (function_exists('add_options_page'))
			add_options_page(
				__('ProcessingJS for WPe', 'pjs4wp'),	// page title
				__('ProcessingJS for WP', 'pjs4wp'),	// menu title
				'manage_options',						// capability
				'pjs4wp_instructions',					// menu slug
				array(&$this, 'pjs4wp_instructions')	// function
			);
	} // pjs4wp_instructions_link()


	/*******************************************************************************************
	 *
	 *	ADD THE PROCESSING CODE TO THE POST / PAGE
	 *
	 *******************************************************************************************/ 
	function pjs4wp_add_code($atts, $content) {
		if(!isset($atts['url'])) {
			// PROCESSING.JS CODE IS IN POST / PAGE
			// v1.2.2
			$content = str_replace("<br />", "", $content);
			$content = str_replace("<br>", "", $content);
			$content = str_replace("<BR />", "", $content);
			$content = str_replace("<BR>", "", $content);			
			$output = '	
<script type="text/processing" data-processing-target="pjs4wpcanvas_'.get_the_ID().'">
'.$content.'
</script>
<canvas id="pjs4wpcanvas_'.get_the_ID().'"></canvas>
			';
		} else {
			// FROM EXISTING .pde SKETCH
			if(isset($atts['bordercolor'])) $bordercolor = 'style="border:solid 1px '.$atts['bordercolor'].';"';
			
			$output = '
<canvas id="pjs4wp_'.get_the_ID().'" '.$bordercolor.' data-processing-sources="'.$atts['url'].'">
</canvas>
			';
		} // if(!isset($atts['url']))
		return $output;
	} // pjs4wp_add_code()
	
	/*******************************************************************************************
	 *
	 *	PRINT INSTRUCTIONS
	 *
	 *******************************************************************************************/	
	function pjs4wp_instructions() {
	?>
<div id="pjs4wp-header" class="pjs4wp-padding-left">
  <div id="pjs4wp-options-opening">
    <div class="pjs4wp-title-bar">
      <h1>
        <?php _e('ProcessingJS for WP','pjs4wp')?>
      </h1>
    </div>
    <div class="pjs4wp-subheader-container">
      <div class="pjs4wp-subheader-left">
        <h3>With this plugin you can embed a <a href="http://processingjs.org" target="_blank">ProcessingJS</a> sketch in your post or page.</h3>
        <span class="pjs4wp-bold">Plugin version: v<?php echo $this->pjs4wp_version?> [<?php echo $this->pjs4wp_release_date?>]<br>
        <a href="http://cagewebdev.com/processingjs-for-wordpress/" target="_blank">Plugin page</a> - <a href="https://wordpress.org/plugins/processingjs-for-wp/" target="_blank">Download page</a> - <a href="http://rvg.cage.nl/" target="_blank">Author</a> - <a href="http://cagewebdev.com/" target="_blank">Company</a> </span> </div>
      <div class="pjs4wp-subheader-right" title="Click here to make your donation!">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="hosted_button_id" value="S9BNZ7D2H2CV2">
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
      </div>
      <!-- odb-subheader-right --> 
    </div>
    <!-- pjs4wp-subheader-container --> 
  </div>
  <!-- pjs4wp-options-opening --> 
</div>
<!-- pjs4wp-header -->
<div class="pjs4wp-title-bar">
  <h1><?php _e('Instructions','pjs4wp')?></h1>
</div>
<br clear="all">
<div class="pjs4wp-container">
  <p>You can use the shorttag <strong>[pjs4wp] ... [/pjs4wp]</strong> in two different ways:<br>
    <br>
    <strong>1) Put the actual ProcessingJS code directly in a post or page, for instance:</strong><br>
    <br>
    <code>[pjs4wp]<br>
    void setup()<br>
    {<br>
    &nbsp;&nbsp;size(200, 200);<br>
    &nbsp;&nbsp;text("Hello world!", 50, 50);<br>
    }<br>
    [/pjs4wp]</code><br>
    <br>
    <strong>2) Use an existing ProcessingJS .pde sketch like this:</strong><br>
    <br>
    <code>[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#000"][/pjs4wp]</code><br>
    <br>
    <strong>IMPORTANT:</strong><br>
    RENAME YOUR <strong>.pde</strong> FILE TO <strong>.js</strong> BEFORE UPLOADING!<br>
    So in the example: rename your original <strong>my_sketch.pde</strong> file to <strong>my_sketch.js</strong>!<br>
    Some servers / browsers are not happy with the .pde extension, that's why...</p>
</div>
<?php
	} // pjs4wp_instructions()	
} // Pjs4wp
?>
