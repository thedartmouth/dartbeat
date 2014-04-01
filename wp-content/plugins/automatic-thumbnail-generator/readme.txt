=== Plugin Name ===
Contributors: iuk
Tags: thumbnail, image, posts 
Requires at least: 3.0.1
Tested up to: 3.0.1
Stable tag: 0.1

Automated on-demand generation of posts thumbnails.

== Description ==

This plugin will scan your thumbnail-less posts and look for a suitable image to use as a thumbnail.
It will look for images linked in the post content and will download and add them to the local library.
Post scanning is performed only when `the_post_thumbnail` or `get_the_post_thumbnail` are called for 
that particular post.

So you designed your new thumbnail-based template, but you have tons of thumbnail-less posts and
don't want to spend too much time on scraping your old posts for a thumbnail picture. Maybe you
think you will probably forget to set a thumbnail for your new posts. Maybe both, as was my case :). 

When a thumbnail for a post is queried and nothing is found this plugin will scrape the post for 
an `<img>` tag and its `href` property. Once a suitabile image is found (based on the configured 
settings), it will be downloaded ad set as the post thumbnail. If no suitable image is found, 
a default one will be used.

This plugin is still in early development state. It just covers my needs (see the "To do" section
for more details). It has been tested only with wordpress 3.0.1, but should work also with 2.9,
since I used similar code with 2.9 (even if it was included in my template's `functions.php`).

The plugin is not supported. This doesn't mean that I will not look into submitted bugs. Anyway,
don't expect prompt answers, since this is done in my spare time. 
 
== Installation ==

1. Upload `auto-thumbnail-generator` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Just use the default `the_post_thumbnail` or `get_the_post_thumbnail` template tags

After installation, you can find plugin settings in the media settings page. The following settings
are available:

* Ignore previously scanned: when checked, previously scanned posts will be re-scanned on each 
request if no thumbnail is linked to the post
* Uknown image: name of the image which shall be used if no thumbnail can be found for a post 
(must match the media library name of an image)
* Minimum Width and Minimum Height: minium width and height for the selected thumbnails (no contraints
if set to null or 0)
* Aspect ratio: aspect ratio (width/height) for the selected thumbnails (e.g. 1.5 for 3:2 ratio,
no contraints if set to null or 0)
* Aspect ratio tolerance: tolerance to aspect ratio for selected thumbnails (percentage of aspect ratio,
e.g. 0.1 tolerance with aspect ratio set to 1.5 will select images with aspect ratio raging from
1.35 to 1.65)  

== Changelog ==

= 0.1  =
* Very first version. Just covers my immediate needs.

== To do ==

Many things should be done in future releases. Here are some:

* Current version always downloads selected linked images. This works good with images hosted on external sites.
If your posts link to images hosted in your media library, you will end up with two images.
* A more user friendly name should be used for images added to the library (e.g. Thumbnail for post ...)
* Somewhere, a button to reset the "previously scanned" status of all posts should be provided (on current version,
you cas set or reset it for single posts in the edit page.
* "previously scanned" status should probably be reset (or at least you should be asked to) when publishing a 
updating an existing post

More ideas are wellcome.