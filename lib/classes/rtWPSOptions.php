<?php

if(!class_exists('rtWPSOptions')):

    class rtWPSOptions
    {

        function rtWPSSettingFields(){
            global $rtWPS;
            $settings = get_option($rtWPS->options['settings']);
            return  array(
                'custom_css' => array(
                    'type' => 'custom_css',
                    'name' => 'custom_css',
                    'label' => 'Custom Css',
                    'id'    => 'custom-css',
                    'value' => isset($settings['custom_css']) ? trim($settings['custom_css']) : null,
                ),
            );
        }

        function scItemMetaFields(){
            return array(
                'type' => 'checkbox',
                'name'  => '_wps_items',
                'multiple'=> true,
                'alignment'=> 'vertical',
                'label' => 'Select the item to display',
                'default' => array('icon','title','description'),
                'options'  => $this->scLayoutItems()
            );
        }

        function rtServiceMetaFields(){
            return array(
                'short_description' => array(
                    'type' => 'textarea',
                    'name'  => 'short_description',
                    'label' => 'Short Description',
                    'class' => 'rt-textarea'
                ),
                'fa_icon' => array(
                    'type' => 'select',
                    'name'  =>'icon',
                    'class' => 'rt-select2',
                    'label' => 'Service Icon',
                    'holderClass'    => 'fa-icon-drop-down',
                    'blank' => 'Select one',
                    'options'   => $this->fontAwesomeDropDownList()
                )
            );
        }

        /**
         * Generate Custom css Field for setting page
         * @return array
         */
        function rtWLSCustomCss(){
            global $rtWPS;
            $settings = get_option($rtWPS->options['settings']);
            return  array(
                'custom_css' => array(
                    'type' => 'custom_css',
                    'name' => 'custom_css',
                    'id'    => 'custom-css',
                    'holderClass'   => 'full',
                    'value' => isset($settings['custom_css']) ? trim($settings['custom_css']) : null,
                ),
            );
        }

        /**
         * Layout array
         *
         * @return array
         */
        function scLayout(){
            return array(
                'grid' => 'Grid Layout',
                'list' => 'List Layout',
            );
        }

        /**
         * Layout item list
         *
         * @return array
         */
        function scLayoutItems(){
            return array(
                'icon'  => "Icon",
                'title' => "Title",
                'description' => "Description",
                'read_more' => "Read More"
            );
        }


        /**
         * Align options
         *
         * @return array
         */
        function scWlsAlign(){
            return array(
                'left' => "Left",
                'center' => "Center",
                'right' => "Right",
            );
        }

        /**
         * FontSize Options
         * @return array
         */
        function scWlsFontSize(){

            $size = array();

            for($i=14; $i <= 60; $i++ ){
                $size[$i] = "{$i} px";
            }

            return $size;
        }

        /**
         * Order By Options
         *
         * @return array
         */
        function scOrderBy(){
            return array(
                'menu_order' => "Menu Order",
                'title' => "Name",
                'date' => "Date",
            );
        }

        /**
         * Order Options
         *
         * @return array
         */
        function scOrder(){
            return array(
                'ASC' => "Ascending",
                'DESC' => "Descending",
            );
        }

        /**
         * Style field options
         *
         * @return array
         */
        function scStyleFields(){
            return array(
                'primary_color' => array(
                    'type' => 'text',
                    'class' => 'rt-color',
                    'name'  => '_wps_primary_color',
                    'label' => 'Primary color',
                ),
                'primary_hover_color' => array(
                    'type' => 'text',
                    'class' => 'rt-color',
                    'name'  => '_wps_hover_color',
                    'label' => 'Primary hover color',
                )
            );
        }


        /**
         * Column Options
         *
         * @return array
         */
        function scColumns(){
            return array(
                1 => "1 Column",
                2 => "2 Column",
                3 => "3 Column",
                4 => "4 Column",
                6 => "6 Column",
            );
        }

        /**
         * Link type options
         *
         * @return array
         */
        function scLinkTypes(){
            return array(
                'self' => "Open in same window",
                'new_window' => "Open in new window",
                'no_link' => "No link",
            );
        }

        /**
         * ShortCode Layout Options
         *
         * @return array
         */
        function scLayoutMetaFields(){
            return array(
                'wps_layout' => array(
                    'name'  => 'wps_layout',
                    'type'  =>  'select',
                    'id'    => 'wps_layout',
                    'label' => 'Layout',
                    'class' => 'rt-select2',
                    'options'   => $this->scLayout()
                ),
                'wps_column'    => array(
                    'name'  =>  'wps_column',
                    'type'  =>  'select',
                    'label' => 'Column',
                    'id'    =>  'wps_column',
                    'class' =>  'rt-select2',
                    'default'   => 3,
                    'options'   =>  $this->scColumns()
                ),/*
                'wps_link_type'    => array(
                    'name'  =>  'wps_link_type',
                    'type'  =>  'select',
                    'label' => 'Link Type',
                    'id'    =>  'wps_link_type',
                    'class' =>  'rt-select2',
                    'options'   =>  $this->scLinkTypes()
                ),*/
                'wps_box_highlight'    => array(
                    'name'  =>  'wps_box_highlight',
                    'type'  =>  'checkbox',
                    'label' =>  'Box Highlight',
                    'option' => 'Enable',
                    'id'    =>  'wps_box_highlight'
                ),
                'wps_short_desc_limit'    => array(
                    'name'  =>  'wps_short_desc_limit',
                    'type'  =>  'number',
                    'label' =>  'Short description character limit',
                    'description'   => 'Leave it blank for full text',
                    'id'    =>  'wps_short_desc_limit'
                )
            );
        }


        /**
         * Filter Options
         *
         * @return array
         */
        function scFilterMetaFields(){
            return array(
                'wps_post__in' => array(
                    "name" => "wps_post__in",
                    "label" => "Include only",
                    "type"  => "text",
                    "class" => "full",
                    "description" => 'List of post IDs to show (comma-separated values, for example: 1,2,3)'
                ),
                'wps_post__not_in' => array(
                    "name" => "wps_post__not_in",
                    "label" => "Exclude",
                    "type"  => "text",
                    "class" => "full",
                    "description" => 'List of post IDs to show (comma-separated values, for example: 1,2,3)'
                ),
                'wps_limit' => array(
                    "name" => "wps_limit",
                    "label" => "Limit",
                    "type"  => "number",
                    "class" => "full",
                    "description" => 'The number of posts to show. Set empty to show all found posts.'
                ),
                'wps_order_by' => array(
                    "name" => "wps_order_by",
                    "label" => "Order By",
                    "type"  => "select",
                    "class" => "rt-select2",
                    "default"   => "date",
                    "options"   => $this->scOrderBy()
                ),
                'wps_order' => array(
                    "name" => "wps_order",
                    "label" => "Order",
                    "type"  => "radio",
                    "class" => "rt-select2",
                    "options"   => $this->scOrder(),
                    "default"   => "DESC",
                    "alignment" => "vertical",
                ),
            );
        }



        public function fontAwesomeDropDownList()
        {
            $icons = array();
            $fList = $this->fontAwesomeIconList();
            foreach($fList as $font => $unicode){
                $icons[$font] = $unicode ." ". ucwords(str_replace(array('fa-','-'), ' ', $font));
            }

            return $icons;

        }


        public function fontAwesomeIconList()
        {

            return array(
                'fa-adjust' => '&#xf042',
                'fa-adn' => '&#xf170',
                'fa-align-center' => '&#xf037',
                'fa-align-justify' => '&#xf039',
                'fa-align-left' => '&#xf036',
                'fa-align-right' => '&#xf038',
                'fa-ambulance' => '&#xf0f9',
                'fa-anchor' => '&#xf13d',
                'fa-android' => '&#xf17b',
                'fa-angellist' => '&#xf209',
                'fa-angle-double-down' => '&#xf103',
                'fa-angle-double-left' => '&#xf100',
                'fa-angle-double-right' => '&#xf101',
                'fa-angle-double-up' => '&#xf102',
                'fa-angle-down' => '&#xf107',
                'fa-angle-left' => '&#xf104',
                'fa-angle-right' => '&#xf105',
                'fa-angle-up' => '&#xf106',
                'fa-apple' => '&#xf179',
                'fa-archive' => '&#xf187',
                'fa-area-chart' => '&#xf1fe',
                'fa-arrow-circle-down' => '&#xf0ab',
                'fa-arrow-circle-left' => '&#xf0a8',
                'fa-arrow-circle-o-down' => '&#xf01a',
                'fa-arrow-circle-o-left' => '&#xf190',
                'fa-arrow-circle-o-right' => '&#xf18e',
                'fa-arrow-circle-o-up' => '&#xf01b',
                'fa-arrow-circle-right' => '&#xf0a9',
                'fa-arrow-circle-up' => '&#xf0aa',
                'fa-arrow-down' => '&#xf063',
                'fa-arrow-left' => '&#xf060',
                'fa-arrow-right' => '&#xf061',
                'fa-arrow-up' => '&#xf062',
                'fa-arrows' => '&#xf047',
                'fa-arrows-alt' => '&#xf0b2',
                'fa-arrows-h' => '&#xf07e',
                'fa-arrows-v' => '&#xf07d',
                'fa-asterisk' => '&#xf069',
                'fa-at' => '&#xf1fa',
                'fa-automobile-alias' => '&#xf1b9',
                'fa-backward' => '&#xf04a',
                'fa-ban' => '&#xf05e',
                'fa-bank-alias' => '&#xf19c',
                'fa-bar-chart' => '&#xf080',
                'fa-bar-chart-o-alias' => '&#xf080',
                'fa-barcode' => '&#xf02a',
                'fa-bars' => '&#xf0c9',
                'fa-bed' => '&#xf236',
                'fa-beer' => '&#xf0fc',
                'fa-behance' => '&#xf1b4',
                'fa-behance-square' => '&#xf1b5',
                'fa-bell' => '&#xf0f3',
                'fa-bell-o' => '&#xf0a2',
                'fa-bell-slash' => '&#xf1f6',
                'fa-bell-slash-o' => '&#xf1f7',
                'fa-bicycle' => '&#xf206',
                'fa-binoculars' => '&#xf1e5',
                'fa-birthday-cake' => '&#xf1fd',
                'fa-bitbucket' => '&#xf171',
                'fa-bitbucket-square' => '&#xf172',
                'fa-bitcoin-alias' => '&#xf15a',
                'fa-bold' => '&#xf032',
                'fa-bolt' => '&#xf0e7',
                'fa-bomb' => '&#xf1e2',
                'fa-book' => '&#xf02d',
                'fa-bookmark' => '&#xf02e',
                'fa-bookmark-o' => '&#xf097',
                'fa-briefcase' => '&#xf0b1',
                'fa-btc' => '&#xf15a',
                'fa-bug' => '&#xf188',
                'fa-building' => '&#xf1ad',
                'fa-building-o' => '&#xf0f7',
                'fa-bullhorn' => '&#xf0a1',
                'fa-bullseye' => '&#xf140',
                'fa-bus' => '&#xf207',
                'fa-buysellads' => '&#xf20d',
                'fa-cab' => '&#xf1ba',
                'fa-calculator' => '&#xf1ec',
                'fa-calendar' => '&#xf073',
                'fa-calendar-o' => '&#xf133',
                'fa-camera' => '&#xf030',
                'fa-camera-retro' => '&#xf083',
                'fa-car' => '&#xf1b9',
                'fa-caret-down' => '&#xf0d7',
                'fa-caret-left' => '&#xf0d9',
                'fa-caret-right' => '&#xf0da',
                'fa-caret-square-o-down' => '&#xf150',
                'fa-caret-square-o-left' => '&#xf191',
                'fa-caret-square-o-right' => '&#xf152',
                'fa-caret-square-o-up' => '&#xf151',
                'fa-caret-up' => '&#xf0d8',
                'fa-cart-arrow-down' => '&#xf218',
                'fa-cart-plus' => '&#xf217',
                'fa-cc' => '&#xf20a',
                'fa-cc-amex' => '&#xf1f3',
                'fa-cc-discover' => '&#xf1f2',
                'fa-cc-mastercard' => '&#xf1f1',
                'fa-cc-paypal' => '&#xf1f4',
                'fa-cc-stripe' => '&#xf1f5',
                'fa-cc-visa' => '&#xf1f0',
                'fa-certificate' => '&#xf0a3',
                'fa-chain-alias' => '&#xf0c1',
                'fa-chain-broken' => '&#xf127',
                'fa-check' => '&#xf00c',
                'fa-check-circle' => '&#xf058',
                'fa-check-circle-o' => '&#xf05d',
                'fa-check-square' => '&#xf14a',
                'fa-check-square-o' => '&#xf046',
                'fa-chevron-circle-down' => '&#xf13a',
                'fa-chevron-circle-left' => '&#xf137',
                'fa-chevron-circle-right' => '&#xf138',
                'fa-chevron-circle-up' => '&#xf139',
                'fa-chevron-down' => '&#xf078',
                'fa-chevron-left' => '&#xf053',
                'fa-chevron-right' => '&#xf054',
                'fa-chevron-up' => '&#xf077',
                'fa-child' => '&#xf1ae',
                'fa-circle' => '&#xf111',
                'fa-circle-o' => '&#xf10c',
                'fa-circle-o-notch' => '&#xf1ce',
                'fa-circle-thin' => '&#xf1db',
                'fa-clipboard' => '&#xf0ea',
                'fa-clock-o' => '&#xf017',
                'fa-close-alias' => '&#xf00d',
                'fa-cloud' => '&#xf0c2',
                'fa-cloud-download' => '&#xf0ed',
                'fa-cloud-upload' => '&#xf0ee',
                'fa-cny-alias' => '&#xf157',
                'fa-code' => '&#xf121',
                'fa-code-fork' => '&#xf126',
                'fa-codepen' => '&#xf1cb',
                'fa-coffee' => '&#xf0f4',
                'fa-cog' => '&#xf013',
                'fa-cogs' => '&#xf085',
                'fa-columns' => '&#xf0db',
                'fa-comment' => '&#xf075',
                'fa-comment-o' => '&#xf0e5',
                'fa-comments' => '&#xf086',
                'fa-comments-o' => '&#xf0e6',
                'fa-compass' => '&#xf14e',
                'fa-compress' => '&#xf066',
                'fa-connectdevelop' => '&#xf20e',
                'fa-copy-alias' => '&#xf0c5',
                'fa-copyright' => '&#xf1f9',
                'fa-credit-card' => '&#xf09d',
                'fa-crop' => '&#xf125',
                'fa-crosshairs' => '&#xf05b',
                'fa-css3' => '&#xf13c',
                'fa-cube' => '&#xf1b2',
                'fa-cubes' => '&#xf1b3',
                'fa-cut-alias' => '&#xf0c4',
                'fa-cutlery' => '&#xf0f5',
                'fa-dashboard-alias' => '&#xf0e4',
                'fa-dashcube' => '&#xf210',
                'fa-database' => '&#xf1c0',
                'fa-dedent-alias' => '&#xf03b',
                'fa-delicious' => '&#xf1a5',
                'fa-desktop' => '&#xf108',
                'fa-deviantart' => '&#xf1bd',
                'fa-diamond' => '&#xf219',
                'fa-digg' => '&#xf1a6',
                'fa-dollar-alias' => '&#xf155',
                'fa-dot-circle-o' => '&#xf192',
                'fa-download' => '&#xf019',
                'fa-dribbble' => '&#xf17d',
                'fa-dropbox' => '&#xf16b',
                'fa-drupal' => '&#xf1a9',
                'fa-edit-alias' => '&#xf044',
                'fa-eject' => '&#xf052',
                'fa-ellipsis-h' => '&#xf141',
                'fa-ellipsis-v' => '&#xf142',
                'fa-empire' => '&#xf1d1',
                'fa-envelope' => '&#xf0e0',
                'fa-envelope-o' => '&#xf003',
                'fa-envelope-square' => '&#xf199',
                'fa-eraser' => '&#xf12d',
                'fa-eur' => '&#xf153',
                'fa-euro-alias' => '&#xf153',
                'fa-exchange' => '&#xf0ec',
                'fa-exclamation' => '&#xf12a',
                'fa-exclamation-circle' => '&#xf06a',
                'fa-exclamation-triangle' => '&#xf071',
                'fa-expand' => '&#xf065',
                'fa-external-link' => '&#xf08e',
                'fa-external-link-square' => '&#xf14c',
                'fa-eye' => '&#xf06e',
                'fa-eye-slash' => '&#xf070',
                'fa-eyedropper' => '&#xf1fb',
                'fa-facebook' => '&#xf09a',
                'fa-facebook-f-alias' => '&#xf09a',
                'fa-facebook-official' => '&#xf230',
                'fa-facebook-square' => '&#xf082',
                'fa-fast-backward' => '&#xf049',
                'fa-fast-forward' => '&#xf050',
                'fa-fax' => '&#xf1ac',
                'fa-female' => '&#xf182',
                'fa-fighter-jet' => '&#xf0fb',
                'fa-file' => '&#xf15b',
                'fa-file-archive-o' => '&#xf1c6',
                'fa-file-audio-o' => '&#xf1c7',
                'fa-file-code-o' => '&#xf1c9',
                'fa-file-excel-o' => '&#xf1c3',
                'fa-file-image-o' => '&#xf1c5',
                'fa-file-movie-o-alias' => '&#xf1c8',
                'fa-file-o' => '&#xf016',
                'fa-file-pdf-o' => '&#xf1c1',
                'fa-file-photo-o-alias' => '&#xf1c5',
                'fa-file-picture-o-alias' => '&#xf1c5',
                'fa-file-powerpoint-o' => '&#xf1c4',
                'fa-file-sound-o-alias' => '&#xf1c7',
                'fa-file-text' => '&#xf15c',
                'fa-file-text-o' => '&#xf0f6',
                'fa-file-video-o' => '&#xf1c8',
                'fa-file-word-o' => '&#xf1c2',
                'fa-file-zip-o-alias' => '&#xf1c6',
                'fa-files-o' => '&#xf0c5',
                'fa-film' => '&#xf008',
                'fa-filter' => '&#xf0b0',
                'fa-fire' => '&#xf06d',
                'fa-fire-extinguisher' => '&#xf134',
                'fa-flag' => '&#xf024',
                'fa-flag-checkered' => '&#xf11e',
                'fa-flag-o' => '&#xf11d',
                'fa-flash-alias' => '&#xf0e7',
                'fa-flask' => '&#xf0c3',
                'fa-flickr' => '&#xf16e',
                'fa-floppy-o' => '&#xf0c7',
                'fa-folder' => '&#xf07b',
                'fa-folder-o' => '&#xf114',
                'fa-folder-open' => '&#xf07c',
                'fa-folder-open-o' => '&#xf115',
                'fa-font' => '&#xf031',
                'fa-forumbee' => '&#xf211',
                'fa-forward' => '&#xf04e',
                'fa-foursquare' => '&#xf180',
                'fa-frown-o' => '&#xf119',
                'fa-futbol-o' => '&#xf1e3',
                'fa-gamepad' => '&#xf11b',
                'fa-gavel' => '&#xf0e3',
                'fa-gbp' => '&#xf154',
                'fa-ge-alias' => '&#xf1d1',
                'fa-gear-alias' => '&#xf013',
                'fa-gears-alias' => '&#xf085',
                'fa-genderless-alias' => '&#xf1db',
                'fa-gift' => '&#xf06b',
                'fa-git' => '&#xf1d3',
                'fa-git-square' => '&#xf1d2',
                'fa-github' => '&#xf09b',
                'fa-github-alt' => '&#xf113',
                'fa-github-square' => '&#xf092',
                'fa-gittip-alias' => '&#xf184',
                'fa-glass' => '&#xf000',
                'fa-globe' => '&#xf0ac',
                'fa-google' => '&#xf1a0',
                'fa-google-plus' => '&#xf0d5',
                'fa-google-plus-square' => '&#xf0d4',
                'fa-google-wallet' => '&#xf1ee',
                'fa-graduation-cap' => '&#xf19d',
                'fa-gratipay' => '&#xf184',
                'fa-group-alias' => '&#xf0c0',
                'fa-h-square' => '&#xf0fd',
                'fa-hacker-news' => '&#xf1d4',
                'fa-hand-o-down' => '&#xf0a7',
                'fa-hand-o-left' => '&#xf0a5',
                'fa-hand-o-right' => '&#xf0a4',
                'fa-hand-o-up' => '&#xf0a6',
                'fa-hdd-o' => '&#xf0a0',
                'fa-header' => '&#xf1dc',
                'fa-headphones' => '&#xf025',
                'fa-heart' => '&#xf004',
                'fa-heart-o' => '&#xf08a',
                'fa-heartbeat' => '&#xf21e',
                'fa-history' => '&#xf1da',
                'fa-home' => '&#xf015',
                'fa-hospital-o' => '&#xf0f8',
                'fa-hotel-alias' => '&#xf236',
                'fa-html5' => '&#xf13b',
                'fa-ils' => '&#xf20b',
                'fa-image-alias' => '&#xf03e',
                'fa-inbox' => '&#xf01c',
                'fa-indent' => '&#xf03c',
                'fa-info' => '&#xf129',
                'fa-info-circle' => '&#xf05a',
                'fa-inr' => '&#xf156',
                'fa-instagram' => '&#xf16d',
                'fa-institution-alias' => '&#xf19c',
                'fa-ioxhost' => '&#xf208',
                'fa-italic' => '&#xf033',
                'fa-joomla' => '&#xf1aa',
                'fa-jpy' => '&#xf157',
                'fa-jsfiddle' => '&#xf1cc',
                'fa-key' => '&#xf084',
                'fa-keyboard-o' => '&#xf11c',
                'fa-krw' => '&#xf159',
                'fa-language' => '&#xf1ab',
                'fa-laptop' => '&#xf109',
                'fa-lastfm' => '&#xf202',
                'fa-lastfm-square' => '&#xf203',
                'fa-leaf' => '&#xf06c',
                'fa-leanpub' => '&#xf212',
                'fa-legal-alias' => '&#xf0e3',
                'fa-lemon-o' => '&#xf094',
                'fa-level-down' => '&#xf149',
                'fa-level-up' => '&#xf148',
                'fa-life-bouy-alias' => '&#xf1cd',
                'fa-life-buoy-alias' => '&#xf1cd',
                'fa-life-ring' => '&#xf1cd',
                'fa-life-saver-alias' => '&#xf1cd',
                'fa-lightbulb-o' => '&#xf0eb',
                'fa-line-chart' => '&#xf201',
                'fa-link' => '&#xf0c1',
                'fa-linkedin' => '&#xf0e1',
                'fa-linkedin-square' => '&#xf08c',
                'fa-linux' => '&#xf17c',
                'fa-list' => '&#xf03a',
                'fa-list-alt' => '&#xf022',
                'fa-list-ol' => '&#xf0cb',
                'fa-list-ul' => '&#xf0ca',
                'fa-location-arrow' => '&#xf124',
                'fa-lock' => '&#xf023',
                'fa-long-arrow-down' => '&#xf175',
                'fa-long-arrow-left' => '&#xf177',
                'fa-long-arrow-right' => '&#xf178',
                'fa-long-arrow-up' => '&#xf176',
                'fa-magic' => '&#xf0d0',
                'fa-magnet' => '&#xf076',
                'fa-mail-forward-alias' => '&#xf064',
                'fa-mail-reply-alias' => '&#xf112',
                'fa-mail-reply-all-alias' => '&#xf122',
                'fa-male' => '&#xf183',
                'fa-map-marker' => '&#xf041',
                'fa-mars' => '&#xf222',
                'fa-mars-double' => '&#xf227',
                'fa-mars-stroke' => '&#xf229',
                'fa-mars-stroke-h' => '&#xf22b',
                'fa-mars-stroke-v' => '&#xf22a',
                'fa-maxcdn' => '&#xf136',
                'fa-meanpath' => '&#xf20c',
                'fa-medium' => '&#xf23a',
                'fa-medkit' => '&#xf0fa',
                'fa-meh-o' => '&#xf11a',
                'fa-mercury' => '&#xf223',
                'fa-microphone' => '&#xf130',
                'fa-microphone-slash' => '&#xf131',
                'fa-minus' => '&#xf068',
                'fa-minus-circle' => '&#xf056',
                'fa-minus-square' => '&#xf146',
                'fa-minus-square-o' => '&#xf147',
                'fa-mobile' => '&#xf10b',
                'fa-mobile-phone-alias' => '&#xf10b',
                'fa-money' => '&#xf0d6',
                'fa-moon-o' => '&#xf186',
                'fa-mortar-board-alias' => '&#xf19d',
                'fa-motorcycle' => '&#xf21c',
                'fa-music' => '&#xf001',
                'fa-navicon-alias' => '&#xf0c9',
                'fa-neuter' => '&#xf22c',
                'fa-newspaper-o' => '&#xf1ea',
                'fa-openid' => '&#xf19b',
                'fa-outdent' => '&#xf03b',
                'fa-pagelines' => '&#xf18c',
                'fa-paint-brush' => '&#xf1fc',
                'fa-paper-plane' => '&#xf1d8',
                'fa-paper-plane-o' => '&#xf1d9',
                'fa-paperclip' => '&#xf0c6',
                'fa-paragraph' => '&#xf1dd',
                'fa-paste-alias' => '&#xf0ea',
                'fa-pause' => '&#xf04c',
                'fa-paw' => '&#xf1b0',
                'fa-paypal' => '&#xf1ed',
                'fa-pencil' => '&#xf040',
                'fa-pencil-square' => '&#xf14b',
                'fa-pencil-square-o' => '&#xf044',
                'fa-phone' => '&#xf095',
                'fa-phone-square' => '&#xf098',
                'fa-photo-alias' => '&#xf03e',
                'fa-picture-o' => '&#xf03e',
                'fa-pie-chart' => '&#xf200',
                'fa-pied-piper' => '&#xf1a7',
                'fa-pied-piper-alt' => '&#xf1a8',
                'fa-pinterest' => '&#xf0d2',
                'fa-pinterest-p' => '&#xf231',
                'fa-pinterest-square' => '&#xf0d3',
                'fa-plane' => '&#xf072',
                'fa-play' => '&#xf04b',
                'fa-play-circle' => '&#xf144',
                'fa-play-circle-o' => '&#xf01d',
                'fa-plug' => '&#xf1e6',
                'fa-plus' => '&#xf067',
                'fa-plus-circle' => '&#xf055',
                'fa-plus-square' => '&#xf0fe',
                'fa-plus-square-o' => '&#xf196',
                'fa-power-off' => '&#xf011',
                'fa-print' => '&#xf02f',
                'fa-puzzle-piece' => '&#xf12e',
                'fa-qq' => '&#xf1d6',
                'fa-qrcode' => '&#xf029',
                'fa-question' => '&#xf128',
                'fa-question-circle' => '&#xf059',
                'fa-quote-left' => '&#xf10d',
                'fa-quote-right' => '&#xf10e',
                'fa-ra-alias' => '&#xf1d0',
                'fa-random' => '&#xf074',
                'fa-rebel' => '&#xf1d0',
                'fa-recycle' => '&#xf1b8',
                'fa-reddit' => '&#xf1a1',
                'fa-reddit-square' => '&#xf1a2',
                'fa-refresh' => '&#xf021',
                'fa-remove-alias' => '&#xf00d',
                'fa-renren' => '&#xf18b',
                'fa-reorder-alias' => '&#xf0c9',
                'fa-repeat' => '&#xf01e',
                'fa-reply' => '&#xf112',
                'fa-reply-all' => '&#xf122',
                'fa-retweet' => '&#xf079',
                'fa-rmb-alias' => '&#xf157',
                'fa-road' => '&#xf018',
                'fa-rocket' => '&#xf135',
                'fa-rotate-left-alias' => '&#xf0e2',
                'fa-rotate-right-alias' => '&#xf01e',
                'fa-rouble-alias' => '&#xf158',
                'fa-rss' => '&#xf09e',
                'fa-rss-square' => '&#xf143',
                'fa-rub' => '&#xf158',
                'fa-ruble-alias' => '&#xf158',
                'fa-rupee-alias' => '&#xf156',
                'fa-save-alias' => '&#xf0c7',
                'fa-scissors' => '&#xf0c4',
                'fa-search' => '&#xf002',
                'fa-search-minus' => '&#xf010',
                'fa-search-plus' => '&#xf00e',
                'fa-sellsy' => '&#xf213',
                'fa-send-alias' => '&#xf1d8',
                'fa-send-o-alias' => '&#xf1d9',
                'fa-server' => '&#xf233',
                'fa-share' => '&#xf064',
                'fa-share-alt' => '&#xf1e0',
                'fa-share-alt-square' => '&#xf1e1',
                'fa-share-square' => '&#xf14d',
                'fa-share-square-o' => '&#xf045',
                'fa-shekel-alias' => '&#xf20b',
                'fa-sheqel-alias' => '&#xf20b',
                'fa-shield' => '&#xf132',
                'fa-ship' => '&#xf21a',
                'fa-shirtsinbulk' => '&#xf214',
                'fa-shopping-cart' => '&#xf07a',
                'fa-sign-in' => '&#xf090',
                'fa-sign-out' => '&#xf08b',
                'fa-signal' => '&#xf012',
                'fa-simplybuilt' => '&#xf215',
                'fa-sitemap' => '&#xf0e8',
                'fa-skyatlas' => '&#xf216',
                'fa-skype' => '&#xf17e',
                'fa-slack' => '&#xf198',
                'fa-sliders' => '&#xf1de',
                'fa-slideshare' => '&#xf1e7',
                'fa-smile-o' => '&#xf118',
                'fa-soccer-ball-o-alias' => '&#xf1e3',
                'fa-sort' => '&#xf0dc',
                'fa-sort-alpha-asc' => '&#xf15d',
                'fa-sort-alpha-desc' => '&#xf15e',
                'fa-sort-amount-asc' => '&#xf160',
                'fa-sort-amount-desc' => '&#xf161',
                'fa-sort-asc' => '&#xf0de',
                'fa-sort-desc' => '&#xf0dd',
                'fa-sort-down-alias' => '&#xf0dd',
                'fa-sort-numeric-asc' => '&#xf162',
                'fa-sort-numeric-desc' => '&#xf163',
                'fa-sort-up-alias' => '&#xf0de',
                'fa-soundcloud' => '&#xf1be',
                'fa-space-shuttle' => '&#xf197',
                'fa-spinner' => '&#xf110',
                'fa-spoon' => '&#xf1b1',
                'fa-spotify' => '&#xf1bc',
                'fa-square' => '&#xf0c8',
                'fa-square-o' => '&#xf096',
                'fa-stack-exchange' => '&#xf18d',
                'fa-stack-overflow' => '&#xf16c',
                'fa-star' => '&#xf005',
                'fa-star-half' => '&#xf089',
                'fa-star-half-empty-alias' => '&#xf123',
                'fa-star-half-full-alias' => '&#xf123',
                'fa-star-half-o' => '&#xf123',
                'fa-star-o' => '&#xf006',
                'fa-steam' => '&#xf1b6',
                'fa-steam-square' => '&#xf1b7',
                'fa-step-backward' => '&#xf048',
                'fa-step-forward' => '&#xf051',
                'fa-stethoscope' => '&#xf0f1',
                'fa-stop' => '&#xf04d',
                'fa-street-view' => '&#xf21d',
                'fa-strikethrough' => '&#xf0cc',
                'fa-stumbleupon' => '&#xf1a4',
                'fa-stumbleupon-circle' => '&#xf1a3',
                'fa-subscript' => '&#xf12c',
                'fa-subway' => '&#xf239',
                'fa-suitcase' => '&#xf0f2',
                'fa-sun-o' => '&#xf185',
                'fa-superscript' => '&#xf12b',
                'fa-support' => '&#xf1cd',
                'fa-table' => '&#xf0ce',
                'fa-tablet' => '&#xf10a',
                'fa-tachometer' => '&#xf0e4',
                'fa-tag' => '&#xf02b',
                'fa-tags' => '&#xf02c',
                'fa-tasks' => '&#xf0ae',
                'fa-taxi' => '&#xf1ba',
                'fa-tencent-weibo' => '&#xf1d5',
                'fa-terminal' => '&#xf120',
                'fa-text-height' => '&#xf034',
                'fa-text-width' => '&#xf035',
                'fa-th' => '&#xf00a',
                'fa-th-large' => '&#xf009',
                'fa-th-list' => '&#xf00b',
                'fa-thumb-tack' => '&#xf08d',
                'fa-thumbs-down' => '&#xf165',
                'fa-thumbs-o-down' => '&#xf088',
                'fa-thumbs-o-up' => '&#xf087',
                'fa-thumbs-up' => '&#xf164',
                'fa-ticket' => '&#xf145',
                'fa-times' => '&#xf00d',
                'fa-times-circle' => '&#xf057',
                'fa-times-circle-o' => '&#xf05c',
                'fa-tint' => '&#xf043',
                'fa-toggle-down-alias' => '&#xf150',
                'fa-toggle-left-alias' => '&#xf191',
                'fa-toggle-off' => '&#xf204',
                'fa-toggle-on' => '&#xf205',
                'fa-toggle-right-alias' => '&#xf152',
                'fa-toggle-up-alias' => '&#xf151',
                'fa-train' => '&#xf238',
                'fa-transgender' => '&#xf224',
                'fa-transgender-alt' => '&#xf225',
                'fa-trash' => '&#xf1f8',
                'fa-trash-o' => '&#xf014',
                'fa-tree' => '&#xf1bb',
                'fa-trello' => '&#xf181',
                'fa-trophy' => '&#xf091',
                'fa-truck' => '&#xf0d1',
                'fa-try' => '&#xf195',
                'fa-tty' => '&#xf1e4',
                'fa-tumblr' => '&#xf173',
                'fa-tumblr-square' => '&#xf174',
                'fa-turkish-lira-alias' => '&#xf195',
                'fa-twitch' => '&#xf1e8',
                'fa-twitter' => '&#xf099',
                'fa-twitter-square' => '&#xf081',
                'fa-umbrella' => '&#xf0e9',
                'fa-underline' => '&#xf0cd',
                'fa-undo' => '&#xf0e2',
                'fa-university' => '&#xf19c',
                'fa-unlink-alias' => '&#xf127',
                'fa-unlock' => '&#xf09c',
                'fa-unlock-alt' => '&#xf13e',
                'fa-unsorted-alias' => '&#xf0dc',
                'fa-upload' => '&#xf093',
                'fa-usd' => '&#xf155',
                'fa-user' => '&#xf007',
                'fa-user-md' => '&#xf0f0',
                'fa-user-plus' => '&#xf234',
                'fa-user-secret' => '&#xf21b',
                'fa-user-times' => '&#xf235',
                'fa-users' => '&#xf0c0',
                'fa-venus' => '&#xf221',
                'fa-venus-double' => '&#xf226',
                'fa-venus-mars' => '&#xf228',
                'fa-viacoin' => '&#xf237',
                'fa-video-camera' => '&#xf03d',
                'fa-vimeo-square' => '&#xf194',
                'fa-vine' => '&#xf1ca',
                'fa-vk' => '&#xf189',
                'fa-volume-down' => '&#xf027',
                'fa-volume-off' => '&#xf026',
                'fa-volume-up' => '&#xf028',
                'fa-warning-alias' => '&#xf071',
                'fa-wechat-alias' => '&#xf1d7',
                'fa-weibo' => '&#xf18a',
                'fa-weixin' => '&#xf1d7',
                'fa-whatsapp' => '&#xf232',
                'fa-wheelchair' => '&#xf193',
                'fa-wifi' => '&#xf1eb',
                'fa-windows' => '&#xf17a',
                'fa-won-alias' => '&#xf159',
                'fa-wordpress' => '&#xf19a',
                'fa-wrench' => '&#xf0ad',
                'fa-xing' => '&#xf168',
                'fa-xing-square' => '&#xf169',
                'fa-yahoo' => '&#xf19e',
                'fa-yelp' => '&#xf1e9',
                'fa-yen-alias' => '&#xf157',
                'fa-youtube' => '&#xf167',
                'fa-youtube-play' => '&#xf16a',
                'fa-youtube-square' => '&#xf166');
        }
    }
    
endif;
