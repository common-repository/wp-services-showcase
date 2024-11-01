<?php

if(!class_exists('rtWPSShortCode')):

    class rtWPSShortCode
    {
        private $scA = array();

        function __construct()
        {
            add_shortcode( 'service', array( $this, 'wps_short_code' ) );
        }
        function register_scripts(){
            $script = array();
            $style = array();
            if(count($this->scA)){
                array_push($script, 'jquery');
                array_push($style,'rt-fontawsome');
                array_push($script,'rt-actual-height-js');
                array_push($script,'rt-wps');
                wp_enqueue_style($style);
                wp_enqueue_script($script);
            }
        }

        function wps_short_code($atts){

            global $rtWPS;
            $html = null;
            $arg= array();
            $atts = shortcode_atts( array(
                'id' => null,
                'title' =>  null,
            ), $atts, 'logo-showcase' );
            $scID =  $atts['id'];
            if($scID && !is_null(get_post( $scID ))) {
                $scMeta = get_post_meta($scID);

                $layout = (isset($scMeta['wps_layout'][0]) ? $scMeta['wps_layout'][0] : 'grid');
                if (!in_array($layout, array_keys($rtWPS->scLayout()))) {
                    $layout = 'grid';
                }

                $col = (isset($scMeta['wps_column'][0]) ? intval($scMeta['wps_column'][0]) : 4);
                if (!in_array($col, array_keys($rtWPS->scColumns()))) {
                    $col = 3;
                }
                $arg['linkType'] = (isset($scMeta['wps_link_type'][0]) ? $scMeta['wps_link_type'][0] : "self");



                /* Argument create */
                $args = array();
                $args['post_type'] = $rtWPS->post_type;
                $args['post_status'] = 'publish';

                // Common filter
                /* post__in */
                $post__in = (isset($scMeta['wps_post__in'][0]) ? $scMeta['wps_post__in'][0] : null);
                if ($post__in) {
                    $post__in = explode(',', $post__in);
                    $args['post__in'] = $post__in;
                }
                /* post__not_in */
                $post__not_in = (isset($scMeta['wps_post__not_in'][0]) ? $scMeta['wps_post__not_in'][0] : null);
                if ($post__not_in) {
                    $post__not_in = explode(',', $post__not_in);
                    $args['post__not_in'] = $post__not_in;
                }

                /* LIMIT */
                $args['posts_per_page'] = (isset($scMeta['wps_limit'][0]) ? (empty($scMeta['wps_limit'][0]) || $scMeta['wps_limit'][0] === '-1') ? 10000000 : (int)$scMeta['wps_limit'][0] : 10000000);

                $short_desc_limit = !empty($scMeta['wps_short_desc_limit'][0]) ? (int)$scMeta['wps_short_desc_limit'][0] : null ;

                $arg['items'] = (!empty($scMeta['_wps_items']) ? $scMeta['_wps_items'] : array());

                // Order
                $order_by = (!empty($scMeta['wps_order_by'][0]) ? $scMeta['wps_order_by'][0] : null);
                $order = (!empty($scMeta['wps_order'][0]) ? $scMeta['wps_order'][0] : null);
                if ($order) {
                    $args['order'] = $order;
                }
                if ($order_by) {
                    $args['orderby'] = $order_by;
                }

                $col = round(12 / $col);
                $arg['grid'] = $col;
                $arg['eqlHClass'] = 'rt-equal-height';
                if(!empty($scMeta['wps_box_highlight'][0])){
                    $arg['boxShadowClass'] = 'wps-boxhighlight';
                }else{
                    $arg['boxShadowClass'] = null;
                }
                /* Some Custom option */
                $serviceQuery = new WP_Query( $args );
                if ( $serviceQuery->have_posts() ) {
                    $rand = mt_rand();
                    $layoutID = "rt-wps-holder-".$rand;
                    $html .= $this->layoutStyle($layoutID, $layout, $scMeta);
                    $html .= "<div class='rt-wps-container-fluid'>";
                    $html .= "<div class='row rt-services {$layout}' id='{$layoutID}'>";

                    while ($serviceQuery->have_posts()) : $serviceQuery->the_post();

                        /* Argument for single member */
                        $sID = get_the_ID();
                        $arg['sID'] = $sID;
                        $arg['title'] = get_the_title();
                        $arg['pLink'] = get_permalink();
                        $arg['icon'] = get_post_meta($sID, 'icon', true);
                        $arg['short_description'] = ($short_desc_limit ? substr(get_post_meta($sID, 'short_description', true), 0, $short_desc_limit) : get_post_meta($sID, 'short_description', true));
                        $html .= $rtWPS->render('layouts/' . $layout, $arg, true);

                    endwhile;
                    $html .= '</div>'; //end row rt-service

                    wp_reset_postdata();

                    $html .= '</div>';// end rt-container


                    $scriptGenerator = array();
                    $scriptGenerator['layout'] = $layoutID;
                    $scriptGenerator['rand'] = $rand;
                    $scriptGenerator['scMeta'] = $scMeta;
                    $this->scA[] = $scriptGenerator;
                    add_action( 'wp_footer', array($this, 'register_scripts'));

                }else{
                    $html .= "<p>".__('No service found','wp-services-showcase')."</p>";
                }
            }else{
                $html .= "<p>" . __('No short code found', 'wp-services-showcase') . "</p>";
            }
            return $html;
        }

        function layoutStyle($layoutId, $layout, $scMeta)
        {
            $css = null;
            $css .= "<style>";

            // Hover primary hover color
            if(!empty($scMeta['_wps_hover_color'][0])){
                $css .= "#{$layoutId}.{$layout} .single-service i:hover,#{$layoutId}.{$layout} .single-service a:hover i,#{$layoutId}.{$layout} .single-service h3 a:hover,#{$layoutId}.{$layout} .single-service h3:hover,#{$layoutId}.{$layout} .services-read-more a:hover{";
                    $css .= "color : {$scMeta['_wps_hover_color'][0]}";
                $css .= "}";
            }
            //Icon , color,
            if(!empty($scMeta['_wps_style_icon'][0])){
                $icon = unserialize($scMeta['_wps_style_icon'][0]);
            }
            if(!empty($icon['size'])){
                $css .= "#{$layoutId}.{$layout} .single-service i,#{$layoutId}.{$layout} .single-service .service-image i{";
                    $css .= "font-size : {$icon['size']}px";
                $css .= "}";
            }
            if(!empty($icon['color'])){
                $css .= "#{$layoutId}.{$layout} .single-service a i,#{$layoutId}.{$layout} .single-service .service-image a i{";
                    $css .= "color : {$icon['color']}";
                $css .= "}";
            }

            // Title
            if(!empty($scMeta['_wps_style_title'][0])){
                $title =  unserialize($scMeta['_wps_style_title'][0]);
            }
            if(!empty($title['size'])){
                $css .= "#{$layoutId}.{$layout} .single-service h3 a,#{$layoutId}.{$layout} .single-service h3{";
                $css .= "font-size : {$title['size']}px";
                $css .= "}";
            }
            if(!empty($title['color'])){
                $css .= "#{$layoutId}.{$layout} .single-service h3 a,#{$layoutId}.{$layout} .single-service h3{";
                $css .= "color : {$title['color']}";
                $css .= "}";
            }
            if(!empty($title['align'])){
                $css .= "#{$layoutId}.{$layout} .single-service h3 a,#{$layoutId}.{$layout} .single-service h3{";
                $css .= "text-align : {$title['align']}";
                $css .= "}";
            }
            // Description service-short-description

            // Description
            if(!empty($scMeta['_wps_style_description'][0])){
                $desc =  unserialize($scMeta['_wps_style_description'][0]);
            }
            if(!empty($desc['size'])){
                $css .= "#{$layoutId}.{$layout} .service-short-description{";
                $css .= "font-size : {$desc['size']}px";
                $css .= "}";
            }
            if(!empty($desc['color'])){
                $css .= "#{$layoutId}.{$layout} .service-short-description{";
                $css .= "color : {$desc['color']}";
                $css .= "}";
            }
            if(!empty($desc['align'])){
                $css .= "#{$layoutId}.{$layout} .service-short-description{";
                $css .= "text-align : {$desc['align']}";
                $css .= "}";
            }

            // Read more
            if(!empty($scMeta['_wps_style_read_more'][0])){
                $read_more =  unserialize($scMeta['_wps_style_read_more'][0]);
            }
            if(!empty($read_more['size'])){
                $css .= "#{$layoutId}.{$layout} .services-read-more a{";
                $css .= "font-size : {$read_more['size']}px";
                $css .= "}";
            }
            if(!empty($read_more['color'])){
                $css .= "#{$layoutId}.{$layout} .services-read-more a{";
                $css .= "color : {$read_more['color']}";
                $css .= "}";
            }
            if(!empty($read_more['align'])){
                $css .= "#{$layoutId}.{$layout} .services-read-more{";
                $css .= "text-align : {$read_more['align']}";
                $css .= "}";
            }



            $css .= "</style>";

            return $css;
        }
    }
endif;
