<?php
/**
 * ShortCode Meta field Class
 *
 * This will generate the meta field for ShortCode generator post type
 *
 * @package WP_SERVICES_SHOWCASE
 * @since 1.0
 * @author RadiusTheme
 */

if (!class_exists('rtWPSSCMeta')):
    /**
     *
     */
    class rtWPSSCMeta
    {

        function __construct() {
            add_action( 'admin_enqueue_scripts',	array($this, 'admin_enqueue_scripts'));
            add_action( 'save_post', array($this, 'save_wps_sc_meta_data'), 10, 3);
            add_action( 'edit_form_after_title', array($this, 'wps_sc_after_title') );
            add_action( 'admin_init', array($this, 'rt_wps_remove_all_meta_box'));
        }


        /**
         * This will add input text field for shortCode
         * @param $post
         */
        function wps_sc_after_title($post){
            global $rtWPS;
            if( $rtWPS->shortCodePT !== $post->post_type) return;

            $html = null;
            $html .= '<div class="postbox" style="margin-bottom: 0;"><div class="inside">';
            $html .= '<p><input type="text" onfocus="this.select();" readonly="readonly" value="[service id=&quot;'.$post->ID.'&quot; title=&quot;'.$post->post_title.'&quot;]" class="large-text code rt-code-sc">
            <input type="text" onfocus="this.select();" readonly="readonly" value="&#60;&#63;php echo do_shortcode( &#39;[service id=&quot;'.$post->ID.'&quot; title=&quot;'.$post->post_title.'&quot;]&#39; ); &#63;&#62;" class="large-text code rt-code-sc">
            </p>';
            $html .= '</div></div>';
            echo $html;
        }

        /**
         * Arrange the shortCode listing column
         * @param $columns
         * @return array
         */
        public function arrange_wps_showcase_sc_columns( $columns ) {
            $shortcode = array( 'wps_short_code' => __( 'Shortcode', 'wp-services-showcase' ) );
            return array_slice( $columns, 0, 2, true ) + $shortcode + array_slice( $columns, 1, null, true );
        }
        public function manage_wps_showcase_sc_columns( $column ) {
            switch ( $column ) {
                case 'wps_short_code':
                    echo '<input type="text" onfocus="this.select();" readonly="readonly" value="[service id=&quot;'.get_the_ID().'&quot; title=&quot;'.get_the_title().'&quot;]" class="large-text code rt-code-sc">';
                    break;
                default:
                    break;
            }
        }

        /**
         *  Remove all unwanted meta box
         */
        function rt_wps_remove_all_meta_box(){
            if (is_admin()) {
                global $rtWPS;
                add_filter("get_user_option_meta-box-order_{$rtWPS->shortCodePT}", array($this, 'remove_all_meta_boxes_wps_sc'));
            }
        }

        /**
         * Add only custom meta box
         * @return array
         */
        function remove_all_meta_boxes_wps_sc(){
            global $wp_meta_boxes, $rtWPS;
            $publishBox = $wp_meta_boxes[$rtWPS->shortCodePT]['side']['core']['submitdiv'];
            $scBox = $wp_meta_boxes[$rtWPS->shortCodePT]['normal']['high'][$rtWPS->shortCodePT.'_sc_settings_meta'];
            $wp_meta_boxes[$rtWPS->shortCodePT] = array(
                'side' => array('core' => array('submitdiv' => $publishBox)),
                'normal' => array('high' => array(
                    $rtWPS->shortCodePT.'_sc_settings_meta' => $scBox
                ))
            );
            return array();
        }

        /**
         *  Add script for the shortCode generate page only
         */
        function admin_enqueue_scripts() {

            global $pagenow, $typenow, $rtWPS;
            // validate page
            if( !in_array( $pagenow, array('post.php', 'post-new.php', 'edit.php') ) ) return;
            if( $typenow != $rtWPS->shortCodePT ) return;

            // scripts
            wp_enqueue_script(array(
                'jquery',
                'wp-color-picker',
                'rt-select2',
                'rt-wps-admin',
            ));

            // styles
            wp_enqueue_style(array(
                'wp-color-picker',
                'rt-select2',
                'rt-wps-admin',
            ));

            $nonce = wp_create_nonce( $rtWPS->nonceText() );
            wp_localize_script( 'rt-wps-admin', 'wps',
                array(
                    'nonceID' => $rtWPS->nonceID(),
                    'nonce' => $nonce,
                    'ajaxurl' => admin_url( 'admin-ajax.php' )
                ) );


            add_filter( 'manage_edit-'.$rtWPS->shortCodePT.'_columns', array($this, 'arrange_wps_showcase_sc_columns'));
            add_action( 'manage_'.$rtWPS->shortCodePT.'_posts_custom_column', array($this,'manage_wps_showcase_sc_columns'), 10, 2);

            add_action('admin_head', array($this,'admin_head'));

        }

        /**
         * Create the custom meta box for ShortCode post type
         */
        function admin_head(){

            global $rtWPS;
            add_meta_box(
                $rtWPS->shortCodePT.'_sc_settings_meta',
                __('Short Code Generator', 'wp-services-showcase' ),
                array($this,'wps_sc_settings_selection'),
                $rtWPS->shortCodePT,
                'normal',
                'high');
        }

        /**
         * Setting Sections
         *
         * @param $post
         */
        function wps_sc_settings_selection($post){
            global $rtWPS;
            wp_nonce_field( $rtWPS->nonceText(), $rtWPS->nonceID() );
            $html = null;
            $html .='<div class="rt-tab-container">';
                $html .='<ul class="rt-tab-nav">
                            <li><a href="#sc-wps-layout">'.__('Layout Settings','wp-services-showcase').'</a></li>
                            <li><a href="#sc-wps-filter">'.__('Service Filtering', 'wp-services-showcase').'</a></li>
                            <li><a href="#sc-wps-item-selection">'.__('Service fields', 'wp-services-showcase').'</a></li>
                            <li><a href="#sc-wps-style">'.__('Styling','wp-services-showcase').'</a></li>
                          </ul>';
                $html .= '<div id="sc-wps-layout" class="rt-tab-content">';
                    $html .= $this->rt_wps_sc_layout_meta();
                $html .='</div>';

                $html .= '<div id="sc-wps-filter" class="rt-tab-content">';
                    $html .= $this->rt_wps_sc_filter_meta();
                $html .='</div>';

                $html .= '<div id="sc-wps-item-selection" class="rt-tab-content">';
                    $html .= $this->rt_wps_sc_item_meta();
                $html .='</div>';

                $html .= '<div id="sc-wps-style" class="rt-tab-content">';
                    $html .= $this->rt_wps_sc_style_meta($post);
                $html .='</div>';
            $html .='</div>';

            echo $html;
        }

        /**
         * Filter Section
         * @return null|string
         */
        function rt_wps_sc_filter_meta(){
            global $rtWPS;
            $html = null;
            $html .="<div class='rt-sc-meta-field-holder'>";
                $html .= $rtWPS->rtFieldGenerator($rtWPS->scFilterMetaFields(), true);
            $html .="</div>";

            return $html;
        }

        /**
         * Item section
         * @return null|string
         */
        function rt_wps_sc_item_meta(){
            global $rtWPS;
            $html = null;
            $html .="<div class='rt-sc-meta-field-holder'>";
                $html .= $rtWPS->rtFieldGenerator($rtWPS->scItemMetaFields());
            $html .="</div>"; // End
            return $html;
        }

        /**
         * Layout section
         * @return null|string
         */
        function rt_wps_sc_layout_meta(){
            global $rtWPS;
            $html = null;
            $html .="<div class='rt-sc-meta-field-holder'>";
                $html .= $rtWPS->rtFieldGenerator($rtWPS->scLayoutMetaFields(), true);
            $html .="</div>"; // End
            return $html;
        }


        /**
         * Style section
         *
         * @param $post
         * @return null|string
         */
        function rt_wps_sc_style_meta($post){
            global $rtWPS;
            $html = null;
            $html .="<div class='rt-sc-meta-field-holder'>";
                $html .=$rtWPS->rtFieldGenerator($rtWPS->scStyleFields(), true);
                $fields = $rtWPS->scLayoutItems();
                foreach($fields as $key => $field){
                    $meta = get_post_meta($post->ID, '_wps_style_'.$key, true);
                    $html .="<div class='field-holder '>";
                        $html .= "<label>{$field}</label>";
                        $html .="<div class='field'>";
                            $meta_color = (!empty($meta['color']) ? $meta['color'] : null);
                            $html .= "<div class='field-item'><label>Color</label><input type='text' value='{$meta_color}' class='rt-color' name='_wps_style_{$key}[color]'></div>";
                            $html .= "<div class='field-item'>";
                                $html .= "<label>Alignment</label>";
                                $html .= "<select name='_wps_style_{$key}[align]' class='rt-select2'>";
                                    $html .= "<option value=''>Default</option>";
                                    $aligns = $rtWPS->scWlsAlign();
                                    $meta_align = (!empty($meta['align']) ? $meta['align'] : null);
                                    foreach($aligns as $aKey => $aValue){
                                        $selected = ($aKey == $meta_align ? "selected" : null);
                                        $html .= "<option {$selected} value='{$aKey}'>{$aValue}</option>";
                                    }
                                $html .= "</select>";
                            $html .= "</div>";
                            $html .= "<div class='field-item'>";
                                $html .= "<label>Size</label>";
                                $html .= "<select name='_wps_style_{$key}[size]'  class='rt-select2'>";
                                    $html .= "<option value=''>Default</option>";
                                    $sizes = $rtWPS->scWlsFontSize();
                                    $meta_size = (!empty($meta['size']) ? $meta['size'] : null);
                                    foreach($sizes as $sKey => $sValue){
                                        $selected = ($sKey == $meta_size ? "selected" : null);
                                        $html .= "<option {$selected} value='{$sKey}'>{$sValue}</option>";
                                    }
                                $html .= "</select>";
                            $html .= "</div>";
                        $html .="</div>";
                    $html .="</div>";
                }

            $html .="</div>"; // End

            return $html;

        }

        /**
         * Save all the meta value for shortCode meta field
         *
         * @param $post_id
         * @param $post
         * @param $update
         */
        function save_wps_sc_meta_data($post_id, $post, $update) {

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            global $rtWPS;
            if( !$rtWPS->verifyNonce() ) return $post_id;
            if ($rtWPS->shortCodePT != $post->post_type) return $post_id;

            $mates = $rtWPS->wpsScMetaNames();
            foreach($mates as $field){
                if(empty($field['multiple'])){
                    $fValue = !empty($_REQUEST[$field['name']]) ? trim($_REQUEST[$field['name']]) : null;
                    update_post_meta($post_id, $field['name'], $fValue);
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

            $meta = array();
            foreach ($rtWPS->scLayoutItems() as $key => $value) {
                $key = "_wps_style_".$key;
                if(!empty($_REQUEST[$key]) && is_array($_REQUEST[$key])){
                    $meta[$key] = $_REQUEST[$key];
                }else{
                    delete_post_meta($post_id, $key);
                }
            }
            foreach($meta as $key => $data){
                update_post_meta($post_id, $key, $data);
            }

        }
    }
endif;