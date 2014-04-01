<?php
require_once(dirname(__FILE__) . '/class.admin.php');

if (!class_exists("ImageFormatr")) {
    class ImageFormatr extends ImageFormatrAdmin {

        // html image tag attributes
        // <img src="pic.jpg" title="This picture is great" width="800"
        //  group="sub" hint="borrowed from pics.org"/>
        var $image_atts = array(
                'alt',
                'asis',
                'class',
                'group',
                'height',
                'hint',
                'id',
                'link',
                'nocap',
                'nofx',
                'page',
                'src',
                'thumb',
                'title',
                'usemya',
                'usemysize',
                'width',
                );

        // administration settings are stored in a single table
        var $options = array();

  ////////////////////////////////////////////////////////// PHP4-compatable constructor

        function ImageFormatr()
        {
            $this->options = get_option('plugin_image-formatr');
            $this->init();
        }

        // load plugin settings
        function init()
        {
            $this->caption_att     =            $this->get_option('capatt') ? $this->get_option('capatt') : 'title'; // attribute to be used for image caption
            $this->strip_title     =            $this->get_option('yankit') ? true : false; // should "title" attribute be stripped?
            $this->add_class       =            $this->get_option('addclass' ); // list of css classes to add to the container div
            $this->new_title       =         __($this->get_option('newtitle' )); // the new title replacement
            $this->def_img_width   = abs(intval($this->get_option('imglong'  )));
            $this->def_img_height  = abs(intval($this->get_option('imgshort' )));
            $this->addl_img_width  = abs(intval($this->get_option('img2long' )));
            $this->addl_img_height = abs(intval($this->get_option('img2short')));
            $this->addl_page       =     intval($this->get_option('img2page' ));

            // remove class list
            foreach( explode(' ', $this->get_option('remclass')) as $class )
                if (trim($class))
                    $this->remove_classes[] = trim($class);

            // exclude class list
            foreach( explode(' ', $this->get_option('xcludclass')) as $class )
                if (trim($class))
                    $this->exclude_classes[] = trim($class);

            // default image dimensions
            if ($this->def_img_height > $this->def_img_width) {
                $this->def_img_long   = $this->def_img_height;
                $this->def_img_short  = $this->def_img_width;
            } else {
                $this->def_img_long   = $this->def_img_width;
                $this->def_img_short  = $this->def_img_height;
            }

            // additional pages image dimensions
            if ($this->addl_img_height > $this->addl_img_width) {
                $this->addl_img_long   = $this->addl_img_height;
                $this->addl_img_short  = $this->addl_img_width;
            } else {
                $this->addl_img_long   = $this->addl_img_width;
                $this->addl_img_short  = $this->addl_img_height;
            }

            // load additional pages image dimensions, if blank, with defaults
            if (!$this->addl_img_width and !$this->addl_img_height) {
                $this->addl_img_width  = $this->def_img_width;
                $this->addl_img_height = $this->def_img_height;
            }
            if (!$this->addl_img_long and !$this->addl_img_short) {
                $this->addl_img_long  = $this->def_img_long;
                $this->addl_img_short = $this->def_img_short;
            }
        }

  //////////////////////////////////////////////// parse content methods

        function filter ( $content )
        {
#$debug_sma_eval ='$this';$debug_sma_title =__METHOD__.':'.__LINE__;include('debug_output_sma.php'); #SMA
            // if we are displaying a page that meets the additional-page
            // criteria (e.g. single), then we use the additional dimensions
            if ( ($this->addl_page == self::FRONT      and  is_front_page())
              or ($this->addl_page == self::NOT_FRONT  and !is_front_page())
              or ($this->addl_page == self::SINGLE     and  is_single()    )
              or ($this->addl_page == self::NOT_SINGLE and !is_single()    )
              ) {
                $this-> def_img_width  = $this-> addl_img_width;
                $this-> def_img_height = $this-> addl_img_height;
                $this-> def_img_long   = $this-> addl_img_long;
                $this-> def_img_short  = $this-> addl_img_short;
            }

            // [img] BBcode short tags /////    [img      ]         [/img ]
            $content = preg_replace_callback('|\[img( *[^]]*)\](.*)\[/img\]|', array($this, 'do_shortcode_bbcode_img'), $content);

            // regular img tags ////////////      <p>   <a     >      <img      / >     <    /a>     < /p>   insensitive-case
            $content = preg_replace_callback("/(?:<p>)?(<a[^>]*>)?\s*(<img[^>]*\/?>)\s?(<\s*\/a>)?(?:<\/p>)?/i", array($this, 'parse'), $content);

            return $content;
        }

        /**
         * Parse bbcode [img] tags
         *
         *  [0] => [img class="alignright"]https://help.ubuntu.com/htdocs/ubuntunew/img/logo.png[/img]
         *  [1] =>  class="alignright"
         *  [2] => https://help.ubuntu.com/htdocs/ubuntunew/img/logo.png
         */
        function do_shortcode_bbcode_img ( $matches )
        {
            return do_shortcode($matches[0]);
        }

        /**
         * Parse the image markup tags
         *
         * matches[0]: <a><img></a>
         * matches[1]: <a href>
         * matches[2]: <img src>
         * matches[3]: </a>
         */
        function parse ( $matches )
        {
#$debug_sma_eval ='$matches';$debug_sma_title =__METHOD__.':'.__LINE__;include('debug_output_sma.php'); #SMA
            $image_atts  = array();
            $orig_markup = $matches[0];

            if( count($matches) < 3 )
                return $orig_markup;

            $anchor_tag  = $matches[1];
            $image_tag   = $matches[2];

             // add the xhtml closing slash, if it's not present,
             // and make sure it has a space before it so wp_kses_hair()
             // will be happy
            $image_tag = preg_replace("%\s*/?\s*>\s*$%", ' />', $image_tag);

            // create an array of the image attributes/parameters
            // [src]   => http://warriorself.com/images/asia/bangkok_1517.jpg
            // [class] => alignright
            // [title] => Licensed to soak
            foreach (wp_kses_hair($image_tag, array('http','https','ftp','file')) as $att => $info)
                $image_atts[$att] = $info['value'];

            // return the untouched markup if we can't find any attributes
            if (!count($image_atts)) return $orig_markup;

            // merge the image atts with the full class default att list
            // so we don't have to check if key exists
            // [id] =>
            // [src] => http://warriorself.com/images/asia/bangkok_1517.jpg
            // [width] =>
            // [height] =>
            // [alt] =>
            // [title] => Licensed to soak
            // [class] => alignright
            // [usemya] =>
            // [nofx] =>
            // [group] =>
            // [nocap] =>
            // [link] =>
            // [hint] =>
            // [asis] =>
            // [usemysize] =>
            // [page] =>
            $image_atts = array_merge(array('group'=>$this->group)          , $image_atts);
            $image_atts = array_merge(array_fill_keys($this->image_atts, ''), $image_atts);

            // return the untouched markup if the asis attribute is set
            if ($image_atts['asis']) return $orig_markup;

            // return the untouched markup if the image style contains
            // an excluded class
            if ($this->exclude_classes)
                foreach (explode(' ', $image_atts['class']) as $class)
                    if (in_array(trim($class), $this->exclude_classes))
                        return $orig_markup;

            // return nothing if we're not on the right page
            // in effect this image gets deleted
            if ( ($image_atts['page'] == 'front'   and !is_front_page())
              or ($image_atts['page'] == 'single'  and !is_single()    )
              or ($image_atts['page'] == '!front'  and  is_front_page())
              or ($image_atts['page'] == '!single' and  is_single()    )
              ) return '';

            // add in the href from the surrounding anchor, if any
            $image_atts['anchor'] = $anchor_tag;

            // add the none attribute which comes from the form if they
            // dont want a caption
            $image_atts['none'] = "";

            // personal fix for my website, force all parent-relative urls
            // to be root-relative instead, i.e. change ../ to /
            if( substr($image_atts['src'], 0, 3) == "../" and $this->options['force'] )
                $image_atts['src'] = substr($image_atts['src'], 2);

            // remove any css classes we don't want
            if ($image_atts['class'])
                foreach ($this->remove_classes as $class)
                    $image_atts['class'] = str_replace($class, "", $image_atts['class']);

            return $this->format($image_atts);
        }

        /**
         * Format the html output
         *
         * @param array $param The image attributes/parameters as an associative array
         * @return string The screen markup
         */
        function format ( $param )
        {
#$debug_sma_eval ='$param';$debug_sma_title =__METHOD__.':'.__LINE__;include('debug_output_sma.php'); #SMA
            // setup dimensions width & height /////////////////////////////////

            // default dimensions
            if ($param['usemysize']) {
                $img_width  = $param['width'];
                $img_height = $param['height'];
            } else {
                $img_width  = $this->def_img_width;
                $img_height = $this->def_img_height;
            }

            // collect the actual image dimensions
            if ($this->options['inspect']) {
                // first load the image dimensions
                #list($img_width, $img_height, $img_type, $img_attr) = getimagesize($param['src']);
                // [0] => 1000
                // [1] => 668
                // [2] => 2
                // [3] => width="1000" height="668"
                // [bits] => 8
                // [channels] => 3
                // [mime] => image/jpeg
                $img_size = $this->getimagesize($param['src']);
                if ( (is_array($img_size)) and (count($img_size) > 1) ) {
                    if (!$param['usemysize'])
                        if ($img_size[0] > $img_size[1]) {
                            $img_width  = $this->def_img_long;
                            $img_height = $this->def_img_short;
                        } else {
                            $img_width  = $this->def_img_short;
                            $img_height = $this->def_img_long;
                        }
                    if (!$img_width  and $img_size[1]) $img_width  = intval($img_height * $img_size[0] / $img_size[1]);
                    if (!$img_height and $img_size[0]) $img_height = intval($img_width  * $img_size[1] / $img_size[0]);
                }
            }

            // setup image dimension print variables ///////////////////
            if ($param['usemysize']) {
                $width  = $img_width   ? "width: {$img_width}px;"   : "";
                $height = $img_height  ? "height: {$img_height}px;" : "";
            } else {
                $width  = $img_width   ? "max-width: {$img_width}px;"   : "";
                $height = $img_height  ? "max-height: {$img_height}px;" : "";
            }
            $img_style  = "style=\"$width $height\"";

            // setup print source and id print variables ///////////////
            $src    = $param['thumb'] ? $param['thumb'] : $param['src'];
            $id     = $param['id'] ? "id=\"{$param['id']}\""  : "";

            // edit title print variable ///////////////////////////////
            if (!$param['usemya'])
                $title = "title=\"{$param['title']}\"";
            if ($param['hint'])
                $title = "title=\"{$param['hint']}\"";
            elseif (!$param['nofx'])
                $title = "title=\"{$this->new_title}\"";
            if ($this->strip_title)
                $title = "";

            // setup caption print variable ////////////////////////////
            $caption = $param[$this->caption_att];
            $div_style = "";
            if ($param['nocap'])
              $caption = "";
            if ($caption and $param['link'])
              $caption = "<a href=\"{$param['link']}\" target=\"_blank\">$caption</a>";
            if ($caption) {
              $caption = "<div style=\"width:100%;\">$caption</div>";
              $div_style = "style=\"width:{$img_width}px\"";
            }

            // setup effect print variable /////////////////////////////
            $effect = "";
            if ($this->options['dofx'])
              $effect = <<< EFFECT
                class="highslide"
                onclick="return hs.expand(this, { slideshowGroup: '{$param['group']}' })"
EFFECT;
            if ($param['nofx'])
              $effect = "";

            // setup anchor print variable /////////////////////////////
            $anchor = $anchor_close = "";
            if (!empty($param['anchor']))
              if( ($param['usemya']==true)
               or (!$this->options['killanc']) )
                $anchor = $param['anchor'];
            if (!$anchor)
              if (!$param['nofx'])
              $anchor = <<< ANCHOR
                <a
                  href="{$param['src']}"
                  title="{$param['title']}"
                  $effect
                >
ANCHOR;
            if ($anchor)
              $anchor_close = "</a>";

            // setup printing output ///////////////////////////////////
            ob_start();
            print <<< IMG
              <div $id class="{$this->add_class} {$param['class']}" $div_style>
                $anchor<img src="$src" alt="{$param['alt']}" $img_style $title/>$anchor_close
                $caption
              </div>
IMG;
            $output = ob_get_clean();

            // return print output /////////////////////////////////////
            return $output;
        }

    } //End Class ImageFormatr

} //End class_exists check
