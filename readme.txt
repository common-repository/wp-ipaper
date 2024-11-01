=== WP-iPaper ===
Contributors: Stuart Marsh
Tags: ipaper, scribd
Requires at least: N/K
Tested up to: 2.6.1
Stable tag: 0.2

Embed Scribd iPaper in your blog.

== Description ==

This plugin allows you to embed a Scribd iPaper into your post. You will first need to upload your document to Scribd, and then use the tag within your post as described below. You will also need to get the docId and access_key from the url for your uploaded document.

== Installation ==

1. Upload `scribdipaper.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Usage ==

There are 4 parameters for the tag:

1.  docId - get this from the Scribd document page
2.  access_key - again from the Scribd document page
3.  height - in pixels
4.  width - in pixels

example: [ipaper docId=12345 access_key=key-saksjdhaksdh height=600 width=600 /]