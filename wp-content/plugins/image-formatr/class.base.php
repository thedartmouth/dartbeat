<?php
if (!class_exists("ImageFormatrBase")) {
    class ImageFormatrBase {

        // additional pages image dimension administration settings
        const FRONT      = 0;
        const NOT_FRONT  = 1;
        const SINGLE     = 2;
        const NOT_SINGLE = 3;

        // highslide slideshow group
        var $group = "main";

        // the image class list to remove
        var $remove_classes = array();

        // the image class exclusion list
        var $exclude_classes = array();

        /**
         * Add the highslide JavaScript and the ImageFormatr stylesheet 
         * to the HTML head tag.
         */
        function enqueue()
        {
            if (!is_admin()) {
                wp_enqueue_style ('image-formatr', plugins_url('image-formatr.css', __FILE__), array(), false, 'all');
                if( $this->get_option('highuse') )
                    wp_enqueue_script ('highslide', plugins_url('highslide.js', __FILE__), array('jquery'), '1.0', true );
            }
        }

        /**
         * Print the on-load JavaScript at the bottom of the page which 
         * is actually preferred to loading in the head for a faster
         * perceived load time.
         */
        function print_scripts()
        {
            if( $this->get_option('highuse') and !is_admin() ) {
                $graphics_url = plugins_url('graphics/', __FILE__);
                $highslide_options = $this->get_option('highcode');
                echo <<< FOOTER
<script type="text/javascript">
    jQuery(document).ready(function() {
        hs.graphicsDir = '$graphics_url';
        $highslide_options
    });
</script>

FOOTER;
            }
        }

        /**
         * Use the native PHP getimagesize() function to get the image
         * width & height.
         */
        function getimagesize($src)
        {
            $url  = parse_url(get_option('siteurl'));
            $site = "http://" . $url["host"]; // no trailing slash
            $size = array();

            // site relative?
            if (substr($src,0,1) == '/')
                $url = $site . $src;
            else
                $url = $src;

            try {
                $size = getimagesize($url);
            }
            catch (Exception $e)
            {
                error_log("Cannot getimagesize(): {$e->getMessage()}");
            }

            return $size;
        }

        /**
         * return the option for the given key
         */
        function get_option ( $key )
        {
            if( array_key_exists($key, $this->options) )
                return $this->options[$key];
                
            return '';
        }

    } //End Class ImageFormatrBase

} //End class_exists check
