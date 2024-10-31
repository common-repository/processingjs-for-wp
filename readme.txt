=== ProcessingJS for WordPress ===
Contributors: CAGE Web Design | Rolf van Gelder
Donate link: http://cagewebdev.com/donations-pjs4wp/
Plugin Name: PJS4WP (ProcessingJS for WordPress)
Plugin URI: http://cagewebdev.com/processingjs-for-wordpress
Tags: processing, processing.org, processingjs, html5, javascript, jQuery, pjs4wp
Author URI: http://rvg.cage.nl
Author: CAGE Web Design | Rolf van Gelder, Eindhoven, The Netherlands
Requires at least: 2.8
Tested up to: 6.0
Stable tag: 1.2.2
Version: 1.2.2
License: GPLv2 or later

== Description ==
= Embed a ProcessingJS sketch (http://processingjs.org) in your post or page with this plugin =
You can use the shorttag (<strong>[pjs4wp]...[/pjs4wp]</strong>) in two different ways:<br>
<br>
<strong>1) Put the actual ProcessingJS code in a post or page, for instance:</strong><br>
<br>
[pjs4wp]<br>
void setup()<br>
{<br>
&nbsp;&nbsp;size(200, 200);<br>
&nbsp;&nbsp;text("Hello world!", 50, 50);<br>
}<br>
[/pjs4wp]<br>
<br>
<strong>2) Use an existing ProcessingJS .pde sketch like this:</strong><br>
<br>
[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#000"][/pjs4wp]<br>
<br>
<strong>IMPORTANT:</strong><br>
RENAME YOUR <strong>.pde</strong> FILE TO <strong>.js</strong> BEFORE UPLOADING!<br>
So in the example: rename your original <strong>my_sketch.pde</strong> file to <strong>my_sketch.js</strong>!<br>
Some servers / browsers are not happy with the .pde extension, that's why...

= Example =
See a live example here:<br>
http://rvg.cage.nl/rvglife-internet-2014/

= Author =
CAGE Web Design | Rolf van Gelder, Eindhoven, The Netherlands - http://cagewebdev.com - http://rvg.cage.nl

= Plugin URL =
http://cagewebdev.com/processingjs-for-wordpress

= Download URL =
http://wordpress.org/plugins/processingjs-for-wordpress

= Disclaimer =
NO WARRANTY, USE IT AT YOUR OWN RISK!

= Plugins by CAGE Web Design | Rolf van Gelder =
WordPress plugins created by CAGE Web Design | Rolf van Gelder<br>
http://cagewebdev.com/category/news-tech-art/wordpress/

== Installation ==

* Upload the Plugin to the '/wp-content/plugins/' directory
* Activate the plugin in the WP Admin Panel &raquo; Plugins 

== Frequently asked questions ==

= How can I change the settings of this plugin? =
* This plugin doesn't need any settings

= How do I use this plugin? =

This plugin uses the <strong>[pjs4wp]</strong> shorttag<br>
<br>
You can use the shorttag in two different ways<br>
<br>
<strong>1) Put the actual ProcessingJS code in a post or page, for instance:</strong><br>
<br>
[pjs4wp]<br>
void setup()<br>
{<br>
&nbsp;&nbsp;size(200, 200);<br>
&nbsp;&nbsp;text("Hello world!", 50, 50);<br>
}<br>
[/pjs4wp]<br>
<br>
<strong>2) Use an existing ProcessingJS .pde sketch like this:</strong><br>
<br>
[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#000"][/pjs4wp]<br>
<br>
<strong>IMPORTANT:</strong><br>
RENAME YOUR <strong>.pde</strong> FILE TO <strong>.js</strong> BEFORE UPLOADING!<br>
So in the example: rename your original <strong>my_sketch.pde</strong> file to <strong>my_sketch.js</strong>!<br>
Some servers / browsers are not happy with the .pde extension, that's why...

== Changelog ==
= v1.2.2 [06/21/2018] =
* BUG FIX: Bug fix for entering the code directly into the post / post

= v1.2.1 [06/19/2018] =
* CHANGE: Several minor changes

= v1.2 [06/15/2015] =
* CHANGE: Code has been revamped

= v1.1 [04/26/2015] =
* NEW: Instructions page added (from plugins page)

= v1.0 [04/24/2015] =
* Initial release
