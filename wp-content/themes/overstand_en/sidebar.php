<div class="sidebar">


<?php if( is_front_page()) : ?>
<div id="rss" onclick="location.href='/rss';" style="cursor: pointer;"></div>
<div id="dailybitebg" >
<div id="dailybite" >
<?php $id=124; $post = get_page($id); echo $post->post_content;  ?>
<div class="clear"></div></div>
</div>
</br></br>
<?php endif;?>


<div>
<!--/* Javascript Tag v2.8.7 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://www.oncampusweb.com/delivery/...'
  * to
  *   'https://www.oncampusweb.com/delivery/...'
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://www.oncampusweb.com/delivery/ajs.php':'http://www.oncampusweb.com/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=96");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://www.oncampusweb.com/delivery/ck.php?n=a02fb939&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://www.oncampusweb.com/delivery/avw.php?zoneid=96&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a02fb939' border='0' alt='' /></a></noscript>


</div>


<div id="tags" >

<div class="clear2"></div>

<ul class="etc">

<li><?php if (function_exists('wp_tag_cloud') ) : ?>

<?php wp_tag_cloud('smallest=8&largest=20&'); ?>

<?php endif; ?></li>

</ul></div>

<?php if( is_front_page()) : ?>
<div id="dailybitebg" >
<div id="dailybite" >
<?php $id=2606; $post = get_page($id); echo $post->post_content;  ?>
<div class="clear"></div></div>
</div>
</br></br>
<?php endif;?>

<ul>

<div class="clear"></div>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // begin primary sidebar widgets ?>

<?php endif; // end sidebar widgets  ?>

		</ul>



<div class="clear2"></div>
</div><!-- #sidebar -->

<div class="clear2"></div>