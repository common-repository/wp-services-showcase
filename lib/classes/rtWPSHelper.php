<?php

if(!class_exists('rtWPSHelper')):

    class rtWPSHelper
    {
        function verifyNonce(){
            global $rtWPS;
            $nonce      = isset($_REQUEST[$this->nonceId()]) ? $_REQUEST[$this->nonceId()] : null;
            $nonceText  = $rtWPS->nonceText();
            if( !wp_verify_nonce( $nonce, $nonceText ) ) return false;
            return true;
        }

        function nonceText(){
            return "rt_wps_nonce_secret";
        }

        function nonceId(){
            return "rt_wps_nonce";
        }


        /**
         * Generate MetaField Name list for shortCode Page
         *
         * @return array
         */
        function wpsScMetaNames(){
            global $rtWPS;
            $fields = array();
            $fieldsA = array_merge(
                $rtWPS->scFilterMetaFields(),
                $rtWPS->scLayoutMetaFields(),
                $rtWPS->scStyleFields()
            );
            foreach($fieldsA as $field){
                $fields[] = $field;
            }
            array_push($fields, array('name' =>'_wps_items', "multiple"  => true ));
            return $fields;
        }

        function rtServiceMetaNames(){
            global $rtWPS;
            $fields = array();
            $fieldsA = $rtWPS->rtServiceMetaFields();
            foreach($fieldsA as $field){
                $fields[] = $field;
            }
            return $fields;
        }

        function rtFieldGenerator($fields = array(), $multi = false){
            $html = null;
            if(is_array($fields) && !empty($fields)) {
                $rtField = new rtWPSField();
                if ($multi) {
                    foreach ($fields as $field) {
                        $html .= $rtField->Field($field);
                    }
                } else {
                    $html .= $rtField->Field($fields);
                }
            }

            return $html;
        }
    }

endif;