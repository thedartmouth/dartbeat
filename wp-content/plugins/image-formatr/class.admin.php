<?php
require_once(dirname(__FILE__) . '/class.base.php');

if (!class_exists("ImageFormatrAdmin")) {
    class ImageFormatrAdmin extends ImageFormatrBase {

        // default html admin options
        var $def_options = array(
                'capatt'    => "title",
                'newtitle'  => "Click here to enlarge.",
                'yankit'    => "",
                'imglong'   => "180",
                'imgshort'  => "",
                'img2long'  => "",
                'img2short' => "",
                'img2page'  => "3",
                'dofx'      => "on",
                'force'     => "",
                'stdthumb'  => "on",
                'killanc'   => "on",
                'inspect'   => "",
                'addclass'  => "img",
                'remclass'  => "",
                'xcludclass'=> "wp-smiley",
                'uninstal'  => "",
                'highuse'   => "on",
                'highcode'  =>
"hs.showCredits = false;
hs.captionEval = 'this.a.title';
hs.transitions = ['expand', 'crossfade'];
hs.fadeInOut   = true;
hs.dimmingOpacity = 0.8;
if (hs.addSlideshow) hs.addSlideshow({
    interval: 0,
    repeat: true,
    useControls: false
});",
                # legacy options used for deactivation removal
                'yanktit'   => null,
                'homelong'  => null,
                'homeshort' => null,
        );

        function admin_init ( )
        {
            $this->option_descriptions = Array(
                'yankit'    => __('Blank out the image title.', IMAGEFORMATR_TEXTDOMAIN). " <code>&lt;img title=&quot;&quot;/&gt;</code> NOTE: this will override the <em>Title replacement</em> option below.",
                'dofx'      => __('Wrap the image in a Highslide popup zoom anchor.', IMAGEFORMATR_TEXTDOMAIN). " <code>&lt;a class=&quot;highslide&quot;&gt;&lt;img/&gt;&lt;/a&gt;</code>",
                'killanc'   => __('Ignore any image anchors in the post.', IMAGEFORMATR_TEXTDOMAIN). " This option will be overridden with an image's <code>usemya</code> attribute. <code>&lt;a href=&quot;dont-ignore-me.html&quot;&gt;&lt;img usemya=&quot;true&quot;/&gt;&lt;/a&gt;</code>",
                'force'     => __('Force relative parent location of images to the root.', IMAGEFORMATR_TEXTDOMAIN). " Interpret <code>&lt;img src=&quot;../images/1.jpg&quot;/&gt;</code> as <code>&lt;img src=&quot;/images/1.jpg&quot;/&gt;</code> which helped when I changed my permalinks.",
                'stdthumb'  => "Try to size all the thumbnails to the dimensions below even if you have width &amp; height set in your image tags.  So, enable this if you want to ignore any width &amp; height settings in your image tags.  This option will be overridden with an image's <code>usemysize</code> attribute.  <code>&lt;img usemysize=&quot;true&quot; width=&quot;200&quot; height=&quot;132&quot;/&gt;</code>",
                'newtitle'  => "The new image title (used for the mouse-over hint in most browsers). <code>&lt;img title=&quot;Click here to enlarge.&quot;/&gt;</code> NOTE: this will be overridden by the <em>Strip title</em> option above.",
                'inspect'   => "Try to determine the dimensions of the image to see if it is portrait (standing up) or layout (laying down) before deciding if the width/height is the long or short edges. NOTE: may cause pages with lots of images to load slowly.              <em>Uses PHP <a target='_blank' href='http://php.net/manual/en/function.getimagesize.php'>GetImageSize</a> function.</em>",
                'addclass'  => "Enter a space-separated list of classes to add to the image container div.",
                'remclass'  => "Enter a space-separated list of classes to remove from the image container div.",
                'xcludclass'=> "Enter a space-separated list of classes to exclude images from processing, i.e. images with these classes will not be touched, just displayed &quot;as-is&quot;. Note: <tt>wp-smiley</tt> is the class used by Wordpress <em>emoticons</em>. Example: <code>wp-smiley exclude-me-class excludemetoo</code>",
                'highuse'   => "Use the Highslide library included with the Image Formatr plugin?  Uncheck this option to disable the pre-bundled Highslide JavaScript Image library from loading as well as the Highslide Settings below.  If you uncheck this option and have the Popup Effects setting checked above then you need to include your own Highslide library in your theme or in a Highslide Integration plugin.",
                'highcode'  => "<p>Note: do not include the <code>hs.graphicsDir</code> setting, it is pre-configured.</p><p><strong>Be careful:</strong> these lines execute as JavaScript and are for advanced users who want to edit the <a href='http://highslide.com/ref/'>Highslide settings</a>. If you don't know what you're doing, leave the defaults.</p>",
                'uninstal'  => "Remove all Image Formatr settings from the database upon plugin deactivation?              Check this box if you want to automatically uninstall this plugin when you deactivate it.               This will clean up the database but you will loose all your settings and you will have the default settings if you re-activate it. If you're not sure, don't check it.",
            );

            register_setting(
                IMAGEFORMATR_TEXTDOMAIN,         // group
                'plugin_image-formatr',          // option name in settings table
                array($this, 'admin_validate')); // sanitize callback function

            add_settings_section(
                'main_section',
                'Main settings',
                array($this, 'admin_overview'),
                __FILE__);

            add_settings_field('capatt'  , 'Caption attribute'                , array($this, 'admin_form_dropdown'), __FILE__, 'main_section', 'capatt'  );
            add_settings_field('yankit'  , 'Strip title'                      , array($this, 'admin_form_checkbox'), __FILE__, 'main_section', 'yankit'  );
            add_settings_field('newtitle', 'Title replacement'                , array($this, 'admin_form_textbox' ), __FILE__, 'main_section', 'newtitle');
            add_settings_field('dofx'    , 'Popup effects'                    , array($this, 'admin_form_checkbox'), __FILE__, 'main_section', 'dofx'    );
            add_settings_field('killanc' , 'Ignore anchors'                   , array($this, 'admin_form_checkbox'), __FILE__, 'main_section', 'killanc' );
            add_settings_field('force'   , 'Force root'                       , array($this, 'admin_form_checkbox'), __FILE__, 'main_section', 'force'   );
            add_settings_field('stdthumb', 'Standardize thumbnails'           , array($this, 'admin_form_checkbox'), __FILE__, 'main_section', 'stdthumb');
            add_settings_field('imgdefs' , 'Thumbnail dimensions (default)'   , array($this, 'admin_form_def_dims'), __FILE__, 'main_section'            );
            add_settings_field('imgaddl' , 'Thumbnail dimensions (additional)', array($this, 'admin_form_def_addl'), __FILE__, 'main_section'            );
            add_settings_field('inspect' , 'Auto determine orientation'       , array($this, 'admin_form_checkbox'), __FILE__, 'main_section', 'inspect' );

            add_settings_section(
                'adv_section',
                'Advanced settings',
                array($this, 'admin_overview'),
                __FILE__);

            add_settings_field('addclass'  , 'Additional classes', array($this, 'admin_form_textbox' ), __FILE__, 'adv_section', 'addclass'  );
            add_settings_field('remclass'  , 'Remove classes'    , array($this, 'admin_form_textbox' ), __FILE__, 'adv_section', 'remclass'  );
            add_settings_field('xcludclass', 'Exclude classes'   , array($this, 'admin_form_textbox' ), __FILE__, 'adv_section', 'xcludclass');
            add_settings_field('highuse'   , 'Highslide enabled' , array($this, 'admin_form_checkbox'), __FILE__, 'adv_section', 'highuse'   );
            add_settings_field('highcode'  , 'Highslide settings', array($this, 'admin_form_textarea'), __FILE__, 'adv_section', 'highcode'  );
            add_settings_field('uninstal'  , 'Uninstall'         , array($this, 'admin_form_checkbox'), __FILE__, 'adv_section', 'uninstal'  );
        }

        function admin_form_dropdown ( $f )
        {
            $desc = __('The image attribute to be used as the caption.', IMAGEFORMATR_TEXTDOMAIN);
            $options = '';
            foreach( array("title", "alt", "(x) no caption") as $item ) {
                $selected = ($this->options[$f]==$item) ? 'selected="selected"' : '';
                $options .= "<option value='$item' $selected>$item</option>\n";
            }
            echo <<< INPUT
                <select id="$f" name="plugin_image-formatr[$f]">
                    $options
                </select>
                $desc
                <code>&lt;img title="This is the title attribute parameter" alt="This is the alt attribute parameter"/&gt;</code>
INPUT;
        }

        function admin_form_checkbox ( $f )
        {
            $desc = array_key_exists($f, $this->option_descriptions) ? $this->option_descriptions[$f] : '';
            $checked = $this->options[$f] ? 'checked="checked" ' : '';
            echo <<< INPUT
                <input type="checkbox" id="$f" name="plugin_image-formatr[$f]" $checked/>
                $desc
INPUT;
        }

        function admin_form_textarea ( $f )
        {
            $desc = array_key_exists($f, $this->option_descriptions) ? $this->option_descriptions[$f] : '';
            echo <<< INPUT
                <textarea id="$f" name="plugin_image-formatr[$f]" rows="5" cols="50">{$this->options[$f]}</textarea>
                $desc
INPUT;
        }

        function admin_form_textbox ( $f )
        {
            $desc = array_key_exists($f, $this->option_descriptions) ? $this->option_descriptions[$f] : '';
            echo <<< INPUT
                <input type="text" id="$f" name="plugin_image-formatr[$f]" value="{$this->options[$f]}"/>
                $desc
INPUT;
        }

        function admin_form_def_dims ( )
        {
            echo <<< INPUT
              <input type="text" name="plugin_image-formatr[imglong]"  id="imglong"  value="{$this->options['imglong']}" size="5"/>
              x
              <input type="text" name="plugin_image-formatr[imgshort]" id="imgshort" value="{$this->options['imgshort']}" size="5"/>
              These values will be used as the width &amp; height in pixels by the <em>Auto determine orientation</em> setting
              which, if disabled will default to the <code>width</code> in the first box and the <code>height</code> in second box.
              NOTE: leave one of the boxes blank (or zero) and it will be calculated using the aspect ratio to the other box.
INPUT;
        }

        function admin_form_def_addl ( )
        {
            $checked = Array('', '', '', '');
            $checked[$this->options['img2page']] = "checked";
            echo <<< INPUT
              <input type="text" name="plugin_image-formatr[img2long]"  id="img2long"  value="{$this->options['img2long']}" size="5"/>
              x
              <input type="text" name="plugin_image-formatr[img2short]" id="img2short" value="{$this->options['img2short']}" size="5"/>
              =
              <input type="radio" name="plugin_image-formatr[img2page]" id="img2page0" value="0" {$checked[0]}/> <label for="img2page0">front</label> |
              <input type="radio" name="plugin_image-formatr[img2page]" id="img2page1" value="1" {$checked[1]}/> <label for="img2page1">not front</label> |
              <input type="radio" name="plugin_image-formatr[img2page]" id="img2page2" value="2" {$checked[2]}/> <label for="img2page2">single</label> |
              <input type="radio" name="plugin_image-formatr[img2page]" id="img2page3" value="3" {$checked[3]}/> <label for="img2page3">not single</label> /
              Thumbnail dimensions if you want to specify different settings for the front page or the single display page or everything else.
              See <em>Thumbnail dimensions (default)</em> setting for description.
INPUT;
        }

        function admin_menu ( )
        {
            if( !function_exists('current_user_can') 
             || !current_user_can('manage_options') )
                return;

            add_options_page(
                __('Image Formatr', IMAGEFORMATR_TEXTDOMAIN), 
                __('Image Formatr', IMAGEFORMATR_TEXTDOMAIN), 
                'manage_options', 
                basename(__FILE__), 
                array($this, 'options_page'));
        }

        function admin_overview ( )
        {
            #echo 'Administration settings';
        }

        function admin_validate ( $input )
        {
            // only validate the integers
            $integers = Array('imglong', 'imgshort', 'img2long', 'img2short');
            foreach( $input as $key => $val) {
                $this->options[$key] = $val;
                if( in_array($key, $integers) )
                    $this->admin_validate_positive_integer($input, $key);
            }

            // the checkbox fields will not be present in the $input
            // so they need to be manually set to false if absent
            $checkboxes = Array('yankit', 'dofx', 'killanc', 'force', 'stdthumb', 'uninstal', 'inspect', 'highuse');
            foreach( $checkboxes as $checkbox )
                if( !array_key_exists($checkbox, $input) )
                    $this->options[$checkbox] = '';

/*
echo "<pre>options ".print_r($this->options, true)."</pre>";
echo "<pre>input ".print_r($input, true)."</pre>";
echo "<pre>integers ".print_r($integers, true)."</pre>";
echo "<pre>checkboxes ".print_r($checkboxes, true)."</pre>";
die();
*/
            return $this->options;
        }

        function admin_validate_positive_integer ( $input, $fieldname )
        {
            if( $input[$fieldname] )
                if( !is_numeric($input[$fieldname])
                 or $input[$fieldname] < 0
                 or sprintf("%.0f", $input[$fieldname]) != $input[$fieldname] )
                    add_settings_error('plugin_image-formatr', 'settings_updated', __("Only positive integers should be used as $fieldname."));
        }

        function options_page()
        {
            ?>
                <div class="wrap">
                    <?php screen_icon("options-general"); ?>
                    <h2><?php _e('Image Formatr', IMAGEFORMATR_TEXTDOMAIN); ?></h2>
                    <form action="options.php" method="post">
                        <?php settings_fields(IMAGEFORMATR_TEXTDOMAIN); ?>
                        <?php do_settings_sections(__FILE__); ?>
                        <p class="submit">
                            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>"/>
                        </p>
                    </form>
                </div>
            <?php
        }

        function activate()
        {
            foreach ($this->def_options as $option => $default_value) {
                $old_key1 = "if_$option"; // legacy option index
                $old_key2 = "image-formatr_$option"; // legacy option index
                if( !array_key_exists($option, $this->options) and !is_null($default_value) ) {
                    $old_value = get_option($old_key2) ? get_option($old_key2) : get_option($old_key1); // check for legacy values
                    $this->options[$option] = $old_value ? $old_value : $default_value;
                }
                delete_option($old_key1); // remove legacy options
                delete_option($old_key2); // remove legacy options
            }

            // if the current setting for highslide is the default, then
            // try to import the Highslide Integration plugin settings
            if( $this->def_options['highcode'] == $this->options['highcode'] )
                if (get_option('hi_jsSettings')) {
                    $highcode = preg_replace("/\s*hs.graphicsDir\s*=.+;/", '', get_option('hi_jsSettings')); // pull the graphicsDir setting out
                    $this->options['highcode'] = strip_tags($highcode);
                }

            // a bit of a hack
            // if the Additional classes setting is blank (upgrade from
            // 0.9.7.4 to 0.9.7.5), then let's just pop in the default
            if( !$this->options['addclass'] )
                $this->options['addclass'] = $this->def_options['addclass'];

            update_option('plugin_image-formatr', $this->options);
            $this->init();
        }

        function deactivate()
        {
            // uninstall all options from the database
#$debug_sma_eval ='$this->options["uninstal"]';$debug_sma_title =__METHOD__.':'.__LINE__;include('debug_output_sma.php'); #SMA
#$debug_sma_eval ='$this';$debug_sma_title =__METHOD__.':'.__LINE__;include('debug_output_sma.php'); #SMA
            if( $this->options['uninstal'] ) {
                delete_option('plugin_image-formatr');
                // delete any leftover legacy option straggelers
                foreach ($this->def_options as $option => $value)
                    delete_option(IMAGEFORMATR_TEXTDOMAIN."_$option");
            }
        }

    } //End Class ImageFormatrAdmin

} //End class_exists check
