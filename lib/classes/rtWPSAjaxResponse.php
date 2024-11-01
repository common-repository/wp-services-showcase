<?php

if(!class_exists('rtWPSAjaxResponse')):

    class rtWPSAjaxResponse
    {
        function __construct(){
            add_action(	'wp_ajax_rtWPSSettings', array($this, 'rtWPSSaveSettings'));
            add_action( 'wp_ajax_wpsShortCodeList', array($this, 'shortCodeList'));
        }

        function rtWPSSaveSettings(){
            global $rtWPS;
            $msg = null;
            $error = true;
            if($rtWPS->verifyNonce()){
                unset($_REQUEST['action']);
                unset($_REQUEST[$rtWPS->nonceId()]);
                unset($_REQUEST['_wp_http_referer']);
                update_option( $rtWPS->options['settings'], $_REQUEST);
                $error = true;
                $msg =__('Settings successfully updated', 'wp-services-showcase');
            }else{

                    $msg = __('Security Error !!', 'wp-services-showcase');
            }
            wp_send_json( array(
                'error'=> $error,
                'msg' => $msg
            ) );
            die();
        }


        /**
         *  Short code list for editor
         */
        function shortCodeList(){
            global $rtWPS;
            $html = null;
            $scQ = new WP_Query( array('post_type' => $rtWPS->shortCodePT, 'order_by' => 'title', 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => -1) );
            if ( $scQ->have_posts() ) {

                $html .= "<div class='mce-container mce-form'>";
                $html .= "<div class='mce-container-body'>";
                $html .= '<label class="mce-widget mce-label" style="padding: 20px;font-weight: bold;" for="scid">'.__('Select Short code', 'wp-service-showcase').'</label>';
                $html .= "<select name='id' id='scid' style='width: 150px;margin: 15px;'>";
                $html .= "<option value=''>".__('Default', 'wp-service-showcase')."</option>";
                while ( $scQ->have_posts() ) {
                    $scQ->the_post();
                    $html .="<option value='".get_the_ID()."'>".get_the_title()."</option>";
                }
                $html .= "</select>";
                $html .= "</div>";
                $html .= "</div>";
            }else{
                $html .= "<div>".__('No shortcode found.','wp-service-showcase')."</div>";
            }
            echo $html;
            die();
        }
    }

endif;