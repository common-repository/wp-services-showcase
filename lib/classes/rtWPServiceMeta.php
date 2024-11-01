<?php

if(!class_exists('rtWPServiceMeta')):

    class rtWPServiceMeta
    {
        function __construct()
        {
            // actions
            add_action('admin_enqueue_scripts',	array($this, 'admin_enqueue_scripts'));
            add_action('save_post', array($this, 'save_post'), 10, 2);
        }

        function admin_enqueue_scripts()
        {
            global $pagenow, $typenow, $rtWPS;

            // validate page
            if( !in_array( $pagenow, array('post.php', 'post-new.php') ) ) return;
            if( $typenow != $rtWPS->post_type ) return;

            // scripts
            wp_enqueue_script(array(
                'jquery',
                'rt-select2',
                'rt-wps-admin',
            ));

            // styles
            wp_enqueue_style(array(
                'wp-color-picker',
                'rt-select2',
                'rt-fontawsome',
                'rt-wps-admin',
            ));

            $nonce = wp_create_nonce( $rtWPS->nonceText() );
            wp_localize_script( 'rt-wps-admin', 'wps',
                array(
                    'nonceID' => $rtWPS->nonceId(),
                    'nonce' => $nonce,
                    'ajaxurl' => admin_url( 'admin-ajax.php' )
                ) );

            add_action('admin_head', array($this,'admin_head'));
        }

        function admin_head(){
            global $rtWPS;
            add_meta_box(
                'rt_wps_meta',
                __('Service Information'),
                array($this,'rt_wps_meta_information'),
                $rtWPS->post_type,
                'normal',
                'high');
        }

        function rt_wps_meta_information($post){
            global $rtWPS;

            wp_nonce_field( $rtWPS->nonceText(), $rtWPS->nonceId() );
            $html = null;
            $html .='<div id="rt-wps-meta-information" class="rt-wps-meta-holder">';
                $html .= $rtWPS->rtFieldGenerator($rtWPS->rtServiceMetaFields(), true);
            $html .='</div>';
            echo $html;
        }


        function save_post($post_id, $post){

            if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
            global $rtWPS;
            if( !$rtWPS->verifyNonce() ) return $post_id;

            if ($rtWPS->post_type != $post->post_type) return $post_id;

            $mates = $rtWPS->rtServiceMetaNames();
            foreach($mates as $field){
                if(empty($field['multiple'])){
                    $fValue = !empty($_REQUEST[$field['name']]) ? trim($_REQUEST[$field['name']]) : null;
                    if($field['name'] == 'short_description'){
                        update_post_meta($post_id, $field['name'], wp_kses_post($fValue));
                    }else{
                        update_post_meta($post_id, $field['name'], $fValue);
                    }
                }else{
                    if($field['multiple']){
                        delete_post_meta($post_id, $field['name']);
                        $mValueA = isset($_REQUEST[$field['name']]) ? $_REQUEST[$field['name']] : array();
                        if(is_array($mValueA) && !empty($mValueA)){
                            foreach($mValueA as $item){
                                add_post_meta($post_id, $field['name'], trim($item));
                            }
                        }
                    }
                }
            }

        } // end function

    }

endif;