=== Easy FancyBox ===
Contributors: RavanH
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=Easy%20FancyBox&item_number=1%2e3%2e1&no_shipping=0&tax=0&bn=PP%2dDonationsBF&charset=UTF%2d8&lc=us
Tags: fancybox, lightbox, gallery, image, photo, video, flash, nextgen, overlay, youtube, vimeo, dailymotion, pdf, iframe, swf, jquery
Requires at least: 2.7
Tested up to: 3.3.1
Stable tag: 1.3.4.9

Easily enable the FancyBox 1.3.4 jQuery extension on just about all media links. Multi-Site compatible. Supports iFrame and Flash movies.

== Description ==

Easy FancyBox-in-a-Box for just about all media links gives you a flexible and aesthetic media lightbox solution for your website. Easy FancyBox uses the packed FancyBox jQuery extension and is WP 3+ Multi-Site compatible. After activation you can find a new section **FancyBox** on your **Settings > Media** admin page where you can manage the plugins options.

**Supports:**

- images (.jpg/.gif/.png and others) _and_ image maps
- WordPress Galleries 
- PDF and SWF (Flash) files
- movie sites like **Youtube**, **Vimeo** _and_ **Dailmotion**
- hidden inline content
- iframes
- popup (auto-activate) on page load

See [Screenshots](http://wordpress.org/extend/plugins/easy-fancybox/screenshots/) for an impression on how images and YouTube movies will be presented on your site as soon as you have installed and (network) activated this simple plugin.

See [FAQ's](http://wordpress.org/extend/plugins/easy-fancybox/faq/) for instructions to manage YouTube, Dailymotion and Vimeo movies (and similar services) and tips to make inline content display in a FancyBox overlay. Subscribe to [4Visions](http://4visions.nl/tag/easy-fancybox/feed/) for tips on how to get a high degree of control over what will be shown in a FancyBox overlay on your website.

Get support on the [Easy FancyBox web page](http://4visions.nl/en/wordpress-plugins/easy-fancybox/) or [WordPress forum](http://wordpress.org/tags/easy-fancybox?forum_id=10).

Visit [FancyBox](http://fancybox.net/) for more information, examples and the FancyBox Support Forum. Please consider a DONATION for continued development of the FancyBox project.

**Recommended:**
- For increased performance, simply install and activate the plugin [Use Google Libraries](http://wordpress.org/extend/plugins/use-google-libraries/) to load jQuery from Googles CDN.

= Translators =

- **Dutch** * Author: [R.A. van Hagen](http://4visions.nl), for version 1.3.4.9
- **Spanish** * Author: [David Pérez](http://www.closemarketing.es), for version: 1.3.4.9


== Installation ==

= Wordpress =

Quick installation: [Install now](http://coveredwebservices.com/wp-plugin-install/?plugin=easy-fancybox) !

 &hellip; OR &hellip;

Search for "easy fancybox" and install with that slick **Plugins > Add New** back-end page.

 &hellip; OR &hellip;

Follow these steps:

 1. Download archive.

 2. Upload the zip file via the Plugins > Add New > Upload page &hellip; OR &hellip; unpack and upload with your favourite FTP client to the /plugins/ folder.

 3. Activate the plugin on the Plug-ins page.

Done! By default, any images that are linked to directly (not to a WordPress page) from within your posts and pages, should now be opening in a FancyBox overlay :)

Not happy with the default settings? Check out the new options under **Settings > Media**.

= WordPress 3+ in Multi Site mode =

Same as above but do a **Network Activate** to activate FancyBox image overlays on each site on your network.

= Wordpress MU =

The plugin works best from the **/mu-plugins/** folder where it runs quietly in the background without bothering any blog owner with new options or the need for special knowledge about FancyBox. Just upload the complete package content to /mu-plugins/ and move the file fancybox.php from the new /mu-plugins/easy-fancybox/ to /mu-plugins/.

== Frequently Asked Questions ==

= BASIC =

= What's FancyBox? =

Basically, it is a fancy way of presenting images, movies, portable documents and inline content on your website. For example, if you have scaled-down images in your posts which are linked to the original large version, instead of opening them on a blanc page, FancyBox opens those in a smooth overlay. Visit [FancyBox](http://fancybox.net/) for more information and examples.&nbsp;


= Which version of FancyBox does this plugin use? =

The same version as this plugin has. I aim to keep close pace to FancyBox upgrades and always move to the latest and greates version. Please, let me know if I'm lagging behind and missed an upgrade!


= Where is the settings page? =

There is no new settings page but there are a few options you can change. You will find a new **FancyBox** section on **Settings > Media**. To see the default, check out the example under [Screenshots](http://wordpress.org/extend/plugins/easy-fancybox/) ...


= TROUBLE SHOOTING =

= Help! It does not work... =

If, after activation, your images do not open in a FancyBox overlay, there are several possible reasons. Some are easily solved, others are more difficult. Follow these basic checks to make sure everything is in place:

1. Make sure that thumbnail images are linked *directly* to their larger counterpart, not to a dynamic WordPress page that includes the larger image. This means when you insert an image in your posts or pages, you need to select `File URL` at the **Link** option instead of `Page URL`. You'll have to manually edit your old posts if you have always inserted images with `Page URL` before, FancyBox cannot do this for you.
1. Make sure you have all the needed media and their *Auto-detect* options activated on your **Settings > Media** admin page. If you are using images in other formats that JPG, GIF or PNG, you need to add the extensions to the Auto-detect field for Images. Please note: The image file names must actaully *end* with that extension! This means that if you have an image file that (for example) has *no* extension (does not end with .jpg or any other) even if is in JPEG compressed format, the FancyBox will not be able to detect is as an image. You will need to manually give those links the class `fancybox` to trigger FancyBox.
1. Make sure your theme is capable of placing the needed javascript and css in the page header. Open any page on your site and view the source code by right-clicking on an empty section and selecting 'View source...' (or similar) to see the page source. There you will need to check of there are any references to javascript files like `jquery.fancybox-x.x.x.pack.js?ver=x.x.x` in the `<head>` section. There should also be a `easy-fancybox.css.php?ver=x.x.x` and some javascript that starts with `<!-- Easy FancyBox 1.3.4.9 using FancyBox 1.3.4 - RavanH (http://4visions.nl/en/wordpress-plugins/easy-fancybox/) -->`... If it's not there, your theme is really out of date. Consider switching to a new theme fast!
1. Check if your theme wraps post/page content in a div with class `hentry`. If it doesn't, you might need to edit the option `Section(s)` on **Settings > Media** to reflect the class (or ID) name of the div that holds post/page content.

If you still do not get to see your images in FancyBox, ask on the [Easy FancyBox WordPress forum](http://wordpress.org/tags/easy-fancybox) or go to the [development site](http://4visions.nl/en/wordpress-plugins/easy-fancybox/)


= ADVANCED =

= Will a WordPress generated gallery be displayed in a FancyBox overlay? =

Yes, but _only_ if you used the option **Link thumbnails to: Image File** when inserting the gallery! The gallery quicktag/shortcode should look something like `[gallery link="file"]`.


= Can I make a slideshow from my gallery? =

Yes. There is an Advanced option called "Gallery Auto-rotation" for that.


= Can I exclude images or other links from auto-attribution? =

Yes. All links with class **nofancybox** that would normally get auto-enabled, will be excluded from opening in a FancyBox overlay.

`<a href="url/to/fullimg.jpg" class="nofancybox"><img src="url/to/thumbnail.jpg" /></a>`
&nbsp;

= Will a NextGen gallery be displayed in a FancyBox overlay ? =

It *can* be. Switch off any gallery overlay scripts in NextGen and either use the FancyBox Auto-detect feature (turned ON by default for jpg, gif and png files) or set the NextGen option "JavaScript Thumbnail effect" to "Custom" and fill the code line field with 
`
class="fancybox" rel="%GALLERY_NAME%"
`
&nbsp;

= Can I use ONE thumbnail to open a complete gallery ? =

It can be done manually (using the internal WordPress gallery feature, or not) _or_ in combination with NextGen Gallery.&nbsp;

**Manual**

**A.** Open your post for editing in HTML mode and insert the first image thumbnail in your post content (linking to the images file, not page) to serve as the gallery thumbnail.&nbsp;

**B.** Place the following code to start a hidden div containing all the other images that should only be visible in FancyBox:
`
<div class="fancybox-hidden">
`

**C.** Right after that starting on a new line, insert all other images you want to show in your gallery. You can even use the WordPress internal gallery feature with the shortcode `[gallery link="file"]`. NOTE: if the gallery thumbnail is attached to the post, it will be show a second time when flipping through the gallery in FancyBox. If you do not want that, use an image that is not attached to the post as gallery thumbail.

**D.** Close the hidden div with the following code on a new line:
`
</div>
`

**With NextGEN Gallery**

You can choose between two shortcodes to show a gallery that (1) limits images per gallery using the shortcode `[nggallery id=x]` or (2) per tag name (accross galleries; you need to set tag name manually => more work but more control) using the shortcode `[nggtags gallery=YourTagName,AnotherTagName]`.&nbsp;

General steps:

**A.** Place the shortcode of your choice in your page/post content.

**B.** Configure NextGen on **Gallery > Options > Gallery settings** to at least have the following options set like this:

1. Number of images per page: 1
1. Integrate slideshow: unchecked (optional but advised: use auto-rotation in the FancyBox settings instead)
1. Show first: Thumbnails
1. Show ImageBrowser: unchecked
1. Add hidden images: checked

**C.** Optional: add a new CSS rule to your theme stylesheet to hide the page browsing links below the gallery thumbnail:
`
.ngg-navigation{display:none}
`
&nbsp;

= Can I display web pages or HTML files in a FancyBox overlay? =

Yes. Place a link with either `class="fancybox-iframe"` or `class="fancybox iframe"` (notice the space instead of the hyphen) to any web page or .htm(l) file in your content.&nbsp;

NOTE: The difference between these two classes ('-' or space) is in size of the overlay window. Try it out and use the one that works best for you :)


= Can I show PDF files in a FancyBox overlay? =

Yes. Just place a link _with the URL ending in .pdf_ to your Portable Document file in the page content.

If you do'nt have *Auto-detect* checked under **PDF** on Settings > Media admin page, you will need to add `class="fancybox-pdf"` (to force pdf content recognition) to the link to enable FancyBox for it.
&nbsp;

= Can I play SWF files in a FancyBox overlay? =

Yes. Just place a link _with the URL ending in .swf_ to your Flash file in the page content.

If you do'nt have *Auto-detect* checked under **SWF** on Settings > Media admin page, you will need to add either `class="fancybox"` or `class="fancybox-swf"` (to force swf content recognition) to the link to enable FancyBox for it.


= How do I show content with different sizes? =

FancyBox tries to detect the size of the conten automatically but if it can not find a size, it will default to the settings for that particular content type as set on the Settings > Media page. You can manually override this by defining the width and height wrapped in curly brases in the class attribute of the link itself. For example, a Flash movie with different size:

`
<a class="fancybox-swf {width:1024,height:675}" href="link-to-your-swf"></a>
`
&nbsp;

= Can I play YouTube, Dailymotion and Vimeo movies in a FancyBox overlay? =

Yes. These are actually a special case of SWF files. The URL for these movies do not end in .swf so the FancyBox script will not be able to auto-detect the Flash content. This can be forced with `class="fancybox-youtube"`, `class="fancybox-swf"` or alternatively `class="fancybox-iframe"`. The difference between the three is mainly in size of the overlay window. Just choose the one that works best for you or... Just let the plugin auto-detect and auto-enable it for you! :)

For **YouTube**, place the Share URL (the plain Page URL, the Short URL or even with the HD option) to the YouTube page in your content. Add `&fs=1` to the URL so show the 'Full screen' button. If you have disabled Auto-detection, use it with `class="fancybox-youtube"` to manually enable FancyBox for it. (Note: For shortened YouTube URLs, the class does not work. Auto auto-detection needs to be enabled seperately.)

For **Vimeo**, just place a link to the Vimeo page in your content. If you have disabled Auto-detection, use it with `class="fancybox-vimeo"` to manually enable FancyBox for it.

Both YouTube and Vimeo movies can be made to auto-start when they are opened by adding the paramer `autoplay=1` to the URL. For example, a short-url YouTube link that should play in HD mode, have the full screen button and auto-start on open, would look like:
`
<a href="http://youtu.be/N_tONWXYviM?hd=1&fs=1&autoplay=1">text/thumbnail</a>
`
&nbsp;

= I want that 'Show in full-screen' button on my YouTube movies =

Append `&fs=1` to your YouTube share URL.


= The flash movie in the overlay shows BELOW some other flash content that is on the same page! =

Make sure the OTHER flash content as a **wmode** set, preferably to 'opaque' or else 'transparent' but not 'window' or missing. For example, if your embedded object looks something like:
`
<object type="application/x-shockwave-flash" width="200" height="300" data="...url...">
<param name="allowfullscreen" value="true" />
<param name="allowscriptaccess" value="always" />
<param name="movie" value="...url..." />
</object>
`
just add `<param name="wmode" value="opaque" />` among the other parameters. Or if you are using an embed like:
`
<object width="640" height="385">
<param name="movie" value="...url..."></param>
<param name="allowFullScreen" value="true"></param>
<param name="allowscriptaccess" value="always"></param>
<embed src="...url..." type="application/x-shockwave-flash" width="640" height="385" allowscriptaccess="always" allowfullscreen="true" wmode="window"></embed>
</object>
`
just change that `wmode="window"` to `wmode="opaque"` or add the tag if it is missing.


= Can I display INLINE content in a FancyBox overlay ? =

Yes. Wrap the inline content in
`
<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-1" style="width:460px;height:380px;">
...inline content here...
</div></div>
`

Then place a FancyBox link anywhere else in the post/page content to the inline content. Something like
`
<a href="#fancyboxID-1" class="fancybox">Read my inline content</a>
`

NOTE: The wrapping divs ID *must* be unique and it must correspond with the links HREF with a # in front of it. When using the above example for more FancyBox inline content (hidden div + opening link) combinations on one page, give the second one the ID  fancyboxID-2 and so on...


= Can I make an image or hidden content to pop up in FancyBox on page load? =

Yes. A link that has the ID **fancybox-auto** (Note: there can be only ONE link like that on a page!) will be triggered automatically on page load.

Use the instructions above for inline content but this time give the link also `id="fancybox-auto"` (leave the class too) and remove the anchor text to hide it. Now the hidden div content will pop up automatically when a visitor opens the page.

Same can be done with an image, flash movie, PDF or iframe link! But please remember there can be only **one** item using the ID fancybox-auto per page...


= Can I make a menu item open in a FancyBox overlay ? =

Yes. But it depends on you theme what you need to do to make it work. If you are on WordPress 3+ and your theme supports the new internal Custom Menu feature or if you are using a custom menu in a sidebar widget, it's easy:&nbsp;

1. Go to Settings > Media and enable FancyBox iFrame support.
2. Go to Appearance > Menus and open the little tab "Screen Options" in the top-right corner.
3. Enable the option "CSS Classes" under Advanced menu proterties.
4. Now give the menu item you want to open in a FancyBox iframe the class `fancybox-iframe`.

If you are on an older version of WordPress or if you cannot use WP's Menus, you will need to do some heavy theme hacking to get it to work. Basically, what you need to achieve is that the menu item you want opened in a lightbox overlay, should get a class="fancybox-iframe" tag.


= Is Easy FancyBox multi-site compatible? =

Yes. Designed to work with **Network Activate** and does not require manual activation on each site in your network. You can even install it in mu-plugins: upload the complete /easy-fancybox/ directory to /wp-content/mu-plugins/ and move the file easy-fancybox.php one dir up.



== Known Issues ==

= Plugin conflicts =

- By default **Google Analytics for WordPress** converts links like `href="#anyID"` to `href="http://yoursite.url/page/#anyID"`, disabling inline content shown in FancyBox.
- A conflict with the **WordPress Amazon Associate** plugin as been reported. A script provided by Amazon and the FancyBox script are incompatible. Disabling _Product Preview_ in the **WP - Amazon > Settings** page should work around the issue.
- There is a conflict between the **WP Slimstat** plugin and the Easy FancyBox script for YouTube url conversion. When clicking a Youtube link, the movie opens in an overlay as it is supposed to but immediately after that, the complete page gets redirected to the original YouTube page. Adding a `class="noslimstat"` to the link is reported to work around the issue.
- When using **WP-Minify**, the javascript files like `fancybox/jquery.fancybox-X.X.X.pack.js` and others need to be excluded from minification.

= Other =

- When showing an iframe as inline content in FancyBox, the iframe will become blank after opening and closing it. The solution is to link directly to the iframe source and use `class="fancybox-iframe"` instead.
- Embedded flash content that has no wmode or wmode 'window', is displayed above the overlay and other javascript rendered content like dropdown menus. WordPress does NOT check for missing wmode in oEmbed generated embed code. Since version 1.3.4.5, the missing wmode is added by this plugin for WP (auto-)embeds but not for other user-embedded content. Please make sure you set the wmode parameter to 'opaque' (best performance) or 'transparent' (only when you need transparency) for your embedded content.

== Trouble Shooting ==

See the FAQ section on trouble shooting.


== Screenshots ==

1. Example image with **Overlay** caption. This is the default way Easy FancyBox displays images. Other options are **Inside** and the old **Outside**.

2. Example of a YouTube movie in overlay.

== Upgrade Notice ==

= 1.3.4.9 =
Metadata and image map support. Opening speed bugfix. New iFrame/HTML5 embed code for Youtube, Vimeo and Dailymotion. Frame color and opacity options. Media options simplification.

== Changelog ==

= 1.3.4.9 =
* NEW: Spanish translation
* NEW: jQuery Metadata support
* NEW: Image map AREA support for all content types
* NEW: new iFrame/HTML5 embed code for YouTube, Vimeo and Dailymotion
* NEW: fix WordPress Dailymotion auto-embed code missing wmode
* Some changes to default settings
* Updated Dutch translation
* BUGFIX: Opening speed

= 1.3.4.8 =
* NEW: Advanced option: Gallery auto-rotation
* NEW: Spotlight effect
* Improved auto-enable and auto-gallery settings
* BIGFIX: CSS IE6 hack
* BIGFIX: PDF object in IE7

= 1.3.4.6 =
* PDF embed compatibility improvement
* NEW: Show/hide title on mouse hover action
* NEW: Auto-gallery modes (Disabled, page/post images only, all) 
* NEW: Dailymotion support
* Links with id **fancybox-auto** will be triggered on page load
* Anything with class **fancybox-hidden"** will be hidden
* Support for menu items in iframe
* Added class **nofancybox** for exclusion when auto-enabling

= 1.3.4.5 =
* FancyBox script version 1.3.4 (2010/11/11 - http://fancybox.net/changelog/)
* NEW: Support for PDF
* NEW: Easing options
* YouTube, Vimeo and iFrame options adjustable
* lots and lots of more options!
* BIGFIX: work-around for missing wmode in WordPress (auto-)embedded movies (credits: Crantea Mihaita)

= 1.3.3.4.2 =
* BIGFIX: iframe width
* BIGFIX: image overlay size in Google Chrome browser issue (FancyBox 1.3.3)
* BIGFIX: fancybox-swf&nbsp;

= 1.3.3.4 =
* FancyBox script version 1.3.3 (2010/11/4 - http://fancybox.net/changelog/)
* Vimeo support
* YouTube Short URL support (disabled by default)
* Auto-recognition and seperate class `fancybox-youtube` for YouTube
* Auto-recognition and seperate class `fancybox-vimeo` for Vimeo

= 1.3.2 =
* FancyBox script version 1.3.2 (2010/10/10 - http://fancybox.net/changelog/)

= 1.3.1.3 =
* translation .pot file available
* Dutch translation
* NEW: YouTube and Flash movie support
* NEW: Iframe support
* added option Auto-enable for...

= 1.3.1.2 =
* added option titlePosition : over / inside / outside
* added option transitionIn : elastic / fade / none
* added option transitionOut : elastic / fade / none

= 1.3.1.1 =
* small jQuery speed improvement by chaining object calls

= 1.3.1 =
* Using FancyBox version 1.3.1
