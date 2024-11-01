<?php
/*
Plugin Name: WP iPaper
Plugin URI: http://www.beardygeek.com
Description: Embed Scibd iPaper in a post
Version: 0.2
Author: Stuart Marsh
Author URI: http://www.beardygeek.com

iPaper plugin for Wordpress Copyright 2008  Stuart Marsh  (email : stuart@beardygeek.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $site_url;
$site_url = get_option('siteurl');
global $docId;
$docId = '';
global $access_key;
$access_key = '';
global $height;
$height = 0;
global $width;
$width = 0;

function ipaper_parse($content)
{
	$content = preg_replace_callback("/\[ipaper ([^]]*)\/\]/i", "ipaper_render", $content);
	return $content;
}

function ipaper_render($matches)
{
	global $site_url, $docId, $access_key, $height, $width;
	
	$matches[1] = str_replace(array('&#8221;','&#8243;'), '', $matches[1]);
	preg_match_all('/(\w*)=(.*?) /i', $matches[1], $attributes);
	$arguments = array();

	foreach ( (array) $attributes[1] as $key => $value ) {
		$arguments[$value] = $attributes[2][$key];
	}
	
	if (!array_key_exists('docId', $arguments))
	{
		return '<div style="background-color:#f99; padding:10px;">Error: Required parameter "docId" is missing!</div>';
		exit;
	}
	else
	{
		$docId = $arguments['docId'];
	}
	
	if (!array_key_exists('access_key', $arguments))
	{
		return '<div style="background-color:#f99; padding:10px;">Error: Required parameter "access_key" is missing!</div>';
		exit;
	}
	else
	{
		$access_key = $arguments['access_key'];
	}
	
	if (array_key_exists('height', $arguments))
	{
		$height = $arguments['height'];
	}
	else
	{
		$height = 600;
	}
	
	if (array_key_exists('width', $arguments))
	{
		$width = $arguments['width'];
	}
	else
	{
		$width = 400;
	}
	
	$output = '';
	$output = "\n".'<p id="embedded_flash" style="text-align: center;"><a href="http://www.scribd.com">Scribd</a></p>'."\n";
	$output .= '<script type="text/javascript">iPaper('.$docId.', \''.$access_key.'\', '.$height.', '.$width.');</script>'."\n";
	
	return $output;
}

function ipaper_head()
{
	global $docId, $access_key, $height, $width;
	
	echo '<script type="text/javascript" src="http://www.scribd.com/javascripts/view.js"></script>'."\n";
	echo '<script type="text/javascript">'."\n";
	echo '<!--'."\n";
	echo 'function iPaper(docId, access_key, height, width) {'."\n";
	echo 'var scribd_doc = scribd.Document.getDoc(docId, access_key);'."\n";
	echo 'scribd_doc.addParam(\'height\', height);'."\n";
	echo 'scribd_doc.addParam(\'width\', width);'."\n";
	echo 'scribd_doc.write(\'embedded_flash\');'."\n";
	echo '}'."\n";
	echo '//-->'."\n";
	echo '</script>';
}


add_filter('the_content', 'ipaper_parse');
add_action('wp_head', 'ipaper_head');
?>