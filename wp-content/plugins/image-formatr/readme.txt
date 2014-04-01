=== Image Formatr ===
Contributors: huntermaster
Tags: images, caption, formatting, post, page
Requires at least: 2.7
Tested up to: 3.2.1
Donate link: http://www.channel-ai.com/blog/donate.php?plugin=image-formatr
Stable tag: 0.9.7.5

Formats all content images on a page / post giving them borders and captions.

== Description ==

Image Formatr is a simple plugin that goes through all the content
images on a post/page:

  1. gives them a standardized thumbnail format using CSS
  2. puts a caption underneath each one using the title
  3. makes them linked so they popup in full size

Thumbnails are not generated, the actual image is displayed in a smaller
size by telling the browser the preferred display dimensions.

*Note: **Flickr** support is slated for the next release, version 0.9.8.*

I would love your feedback!
sroth77 is now at gmail.com
http://warriorself.com/blog/contact/
thanks.

= Usage =

*This only applies to the images you put in your content, not theme graphics.*

    <img
      src="/images/picture.jpg"
      class="alignright"
      title="A sample caption"
      link="http://example.com/"
      hint="Image borrowed from example.com"
    />

After the plugin runs, the output to the browser looks like:

    <div class="img alignright" style="width: 140px;">
    <a
      href="/images/picture.jpg"
      class="highslide"
      onclick="return hs.expand(this, { slideshowGroup: 'main' })"
    ><img
      src="/images/picture.jpg"
      title="Image borrowed from example.com" alt=""
      width="140" height="90"
    ></a>
    <div style="width: 100%;">
      <a href="http://example.com/" target="_blank">A sample caption</a>
    </div>
    </div>

&nbsp;

= Requirements =

No external requirements are needed.  The Highslide JavaScript library is
now packaged in the Image-formatr plugin itself.  The Highslide Integration
plugin used in previous versions of Image-formatr is no longer needed.

= Features =

  * Generates image captions using the image `title` or `alt`
  * Shows all content images on the blog as small thumbnails
  (does not create new thumbnail images)
  * Standardizes all thumbnails with zero post changes
  * Allows for fine-grained control of each image's format
  * Zooms image to large size when clicked using the
  [Highslide](http://highslide.com/) library
  * Outputs standard XHTML compliant markup
  * Support BBCode [img] shortcodes

== Credits ==

Image Formatr is Copyright 2011 [Steven Almeroth](sroth77@gmail.com) and
licensed under the GPL2 license

Based on: [image-caption](http://wordpress.org/extend/plugins/image-caption/)
by [Yaosan Yeo](http://www.channel-ai.com/blog/)

Highslide: The JavaScript [Image thumbnail viewer](http://highslide.com/)
library by Torstein Hønsi is licensed under a
[Creative Commons Attribution-NonCommercial 2.5 License]
(http://creativecommons.org/licenses/by-nc/2.5/). This means you need the
author's permission to use it on commercial websites.

== Overrides ==

The actions of the plugin are enabled and disabled with administration settings
but can be overridden on each individual image.

  * **`usemysize`** - true/false - *true = do not ignore an image width and height*
  * **`usemya`**    - true/false - *true = do not ignore a parent anchor tag*
  * **`nocap`**     - true/false - *true = do not create a caption*
  * **`nofx`**      - true/false - *true = no popup effect*
  * **`link`**      - string url - *make the caption a link to the url*
  * **`hint`**      - string txt - *this will be the new image title*
  * **`asis`**      - true/false - *true = don't change nuthin*
  * **`group`**     - string txt - *separate popup slideshows*
  * **`thumb`**     - string url - *image thumbnail* (version 0.9.7)
  * **`page`**      - single/!single/front/!front - *page filtering* (version 0.9.7)

If you want to surround an image with an anchor tag `<a>`, then you should add
a `usemya` attribute within the image tag or else your anchor will be ignored
and replaced.  If you do not want the popup effect at all, add a `nofx` attribute
to the image.  If you do not want any caption, you can specify `nocap`, or just
leave the title blank. And to have the plugin completely ignore an image and
output the content directly from the post, use the `asis` attribute.

**Example**

    <a href="http://www.example.com/">
    <img
      src="/images/picture.jpg"
      title="Click to visit website"
      nocap="true"
      usemya="true"
    /></a>

Note: concerning the *true/false* overrides, do not include "false" parameters
like `<img usemya="false">`, for these boolean overrides only include the attribute
if you want to designate a "true" value.

== Installation ==

*Note: versions 0.9.4/5/6 do not preserve the plugin options after deactivation.
Therefore, if you are upgrading from one of these versions then write down your
Image Formatr settings before you upgrade, log in to the Wordpress adminstration
(wp-admin), go to **Settings** and then **Image Formatr**.*

  1. Download and extract the plugin to your computer
  1. Extract the files keeping the directory structure in tact
  1. Upload the extracted directory (image-formatr) to your WordPress plugin
  directory (wp-content/plugins)
  1. Activate the plugin through the *Plugins* menu in WordPress admin

== Screenshots ==

1. Image Formatr administration screen

== Website ==

More information, including how to contact me, is available at
[warriorself.com](http://warriorself.com/blog/about/image-formatr/).

== Frequently Asked Questions ==

1. *Wordpress "smiley" emoticons like `:)` keep showing up with the other
images.  How can I prevent smileys from being effected?*

Version 0.9.6 includes a *class exclusion list* which prevents an image
from being processed by the plugin if it contains a CSS class that is in
the list.  Wordpress uses "wp-smiley" for their smileys so enter `wp-smiley`
into the exclusion classes in the Wordpress administration settings for
Image-formatr then click "Update Options".

2. *These image attributes (e.g. page, nocap, link, etc) are not XHTML
standard attributes.  Why do you use them?*

The Image Formatr *override* attributes do not get written to the browser.
They are only used by the plugin for format configuration of individual
images.  Unless you specify the `asis` attribute, all images in your content
are deconstructed then rebuilt sending only XHTML compliant markup to the
client.

3. *Is it possible to change the caption background color?*

Edit the file `image-formatr.css` around line 27 change:

    div.img div {
      background-color: auto;

to:

    div.img div {
      background-color: purple;

You can also add the following html anywhere in your theme output:

    <style>
        div.img div { background-color: purple }
    </style>

== To Do List ==

* add screenshot of output image with caption

== Current Wishlist for version 1.0 ==

* admin option to move title to alt, should it overwrite an existing alt?
* phone-home feature, activate/deactivate stats helper with version number
* support the custom CSS class for div image container
* add admin option to configure the plugin priority
* add admin option for html/xhtml &lt;img/&gt; closing tags
* add admin option for moving title attribute to alt attribute
* add admin option for name to use for default highslide slideshow group
* debug mode could show images not found and whatnots and profiling stats
* change [flickrset id="1234"] to [flickr set="1234"]
* change [flickr pid="123"] to [flickr img="123"]
* add a do_shortcode() list for before/after IF content filtering
    add_filter('the_content', 'do_shortcode', $custom_shortcode_priority, $arguments)
    do_shortcode('[ngggallery]');
    do_shortcode('[flickr]');
* show "the_content" ordering vis a vie wp-hooks-filters-flow.php
    Priority 8 :
        WP_Embed-&gt;run_shortcode()
        WP_Embed-&gt;autoembed()
    Priority 10 :
        wptexturize()
        convert_smilies()
        convert_chars()
        wpautop()
        shortcode_unautop()
        prepend_attachment()
    Priority 11 :
        capital_P_dangit()
        do_shortcode()
    Priority 20 :
        ImageFormatr-&gt;filter()

== Current Buglist ==

* bug: if you click too early, before the highslide loads, the anchor
    is still "live" and will not use ajax, i.e the new url will load
    which is the normal anchor behaviour
* bug: add_settings_field() &lt;label for="s"&gt; not &lt;label for="stdthumb"&gt;
    work-around is to only use unique single char id fields
    defined as constants
* bug: zoomin.cur is often, but not always, 404'd

== Changelog ==

= 0.9.8 =
  * [Development version](http://downloads.wordpress.org/plugin/image-formatr.zip)
  * Added: Flickr image support with [flickr pid="123"] or <img flirckr="123">
  * Added: Flickr set support with [flickrset id="123"]
  - Note: [flickrset id="123"] will become [flickr set="123"] next release

Latest stable release 0.9.7.5

= 0.9.7.5 =
  * 2011-11-03 BBCode [img] support
  * Added: support for [img]http://mydomain.com/image.jpg[/img]
  * Added: CSS image class modification options

= 0.9.7.4 =
  * 2011-07-17 Small images not upsized
  * Changed css style width to max-width

= 0.9.7.3 =
  * 2011-06-12 Internet Explorer patch
  * Fixed: JavaScript obect trailing comma removed from hs.addSlideshow() call
  * Added: Highslide library disable option if you already use Highslide
  * Changed: Auto determine orientation admin setting now defaults to off

= 0.9.7 =
  * 2011-03-21 Administration upgrage version
  * Fixed: stylesheet displayed correctly allowing height attribute without width
  * Fixed: trailing slash on image tag no longer required &lt;img/&gt;
  * Fixed: admin options for thumbnail dimensions UI bug
  * Fixed: image aspect ratio now correctly calculated
  * Added: 'thumb' attribute to show a thumbnail image
  * Added: 'page' attribute to allow for image to be excluded from certain pages
  * Added: uninstall plugin option which can clean Image Formatr out of the database
  * Changed: home page image dimensions expanded to include single page, etc.
  * Changed: admin options to serialize all settings into one table row
  * Changed: class getting kinda big so I split it up into three classes
  * Changed: admin screen updated to current Wordpress API standards
  * Removed: admin html include file no longer needed with new API

= 0.9.6 =
  * 2011-02-13 Smiley exclusion patch
  * Added: Exclude image style class list which prevents smileys from being included
  * Added: import Highslide Integration plugin settings upon Image Formatr activation
  * Added: forgot to include graphics directory in 0.9.5 release

= 0.9.5 =
  * 2011-01-18 Highslide integrated directly into Image-formatr plugin
  * Added: Admin option for the mouseover hint "Click here to enlarge"
  * Added: Admin option to use different image dimensions on the home page
  * Added: Admin option for Highslide settings
  * Added: restrict image url protocols to http, https, ftp, file
  * Added: "Group" image attribute can separate Highslide popup slideshows
  * Added: Highslide JavaScript library w/gallery (highslide.js) 4.1.9 (2010-07-05)
  * Removed: Highslide Integration plugin requirement
  * Changed: "Strip title" admin option now actually strips the title
  * Changed: "Hint" image attribute gets displayed differently

= 0.9.4 =
  * 2011-01-13 Class structure used and performance increased
  * Added: Class structure encapsulation
  * Added: Admin setting to disable image inspection (speed increase)
  * Changed: Admin setting "Thumbnail dimensions" to allow zero,
  which then calculates based on aspect ratio
  * Removed: PHP-GD library call and Snoopy call (speed increase)

= 0.9.3 =
  * 2011-01-13 Bugfix patch
  * Changed: admin settings bug fixes

= 0.9.2 =
  * 2010-04-16 Smiley/emoticon displayed
  * Changed: Smileys like :) were causing errors so I added a check to make
  sure we are not effecting emoticon graphics within the post.  Now smileys
  display fine, thanks to http://blog.andrewkinabrew.com/

= 0.9.1 =
  * 2010-03-9 Standard thumbnail dimensions
  * Changed: Allow for zero length long or short thumbnail dimension in the
  administration settings

= 0.9 =
  * 2010-01-26 Initial beta release
  * Renamed the `usemyanchor` image modifier attribute to `usemya` with no
  deprecated support for the old one
  * Fixed: caption administration setting not working
  * Added: force-root image location mangler administration setting
  * Added: administration setting to standardize all thumbnail sizes
  * Added: `usemysize` attribute to allow for individual image sizing
  * Changed: no longer supports MyCSS plugin

= 0.8 =
  * 2010-01-5 Initial alpha release

== Upgrade Notice ==

= 0.9.7.5 =
BBCode [img] support

= 0.9.7.4 =
Small images not upsized

= 0.9.7.3 =
Microsoft Internet Explorer fix

= 0.9.7 =
Wordpress version 2.7 required to use the new administration

= 0.9.6 =
Highslide Integration external helper plugin no longer required

= 0.9.4 =
Multiple speed increases

= 0.9.2 =
First stable version
