<?php

if(!class_exists('rtWPSInit')):
	class rtWPSInit
	{

		function __construct()
		{
			add_action('init', array($this, 'init'), 1);
			add_action( 'widgets_init', array($this, 'initWidget'));
			add_action( 'plugins_loaded', array($this,'wps_load_text_domain') );
			register_activation_hook(RT_WPS_PLUGIN_ACTIVE_FILE_NAME, array($this, 'activate'));
			register_deactivation_hook(RT_WPS_PLUGIN_ACTIVE_FILE_NAME, array($this, 'deactivate'));
			add_action('wp_enqueue_scripts',	array($this, 'enqueue_scripts'));
			add_action('admin_enqueue_scripts',	array($this, 'admin_enqueue_scripts_settings'));
		}


		function init()
		{
			// Create the post grid post type
			$labels = array(
				'name' => __( 'Services', 'wp-services-showcase' ),
				'singular_name' => __( 'Service', 'wp-services-showcase' ),
				'add_new' => __( 'Add New Service' , 'wp-services-showcase' ),
				'all_items' => __( 'All Services' , 'wp-services-showcase'),
				'add_new_item' => __( 'Add New Service' , 'wp-services-showcase' ),
				'edit_item' =>  __( 'Edit Service' , 'wp-services-showcase' ),
				'new_item' => __( 'New Service' , 'wp-services-showcase' ),
				'view_item' => __('View Service', 'wp-services-showcase'),
				'search_items' => __('Search Services', 'wp-services-showcase'),
				'not_found' =>  __('No Services found', 'wp-services-showcase'),
				'not_found_in_trash' => __('No Services found in Trash', 'wp-services-showcase'),
			);

			global $rtWPS;

			register_post_type( $rtWPS->post_type, array(
				'labels' => $labels,
				'public' => true,
				'show_ui' => true,
				'_builtin' =>  false,
				'capability_type' => 'page',
				'hierarchical' => false,
				'menu_icon' => $rtWPS->assetsUrl .'images/menu-icon.png',
				'rewrite' => true,
				'query_var' => true,
				'supports' => array(
					'title', 'editor', 'page-attributes'
				),
				'show_in_menu'	=> true,
			));

			$sc_args = array(
				'label'               => __( 'Shortcode', 'wp-logo-showcase' ),
				'description'         => __( 'Wp logo showcase Shortcode generator', 'wp-logo-showcase' ),
				'labels'              => array(
					'all_items'           =>__('Shortcode Generator', 'wp-logo-showcase' ),
					'menu_name'	          =>__('Shortcode', 'wp-logo-showcase' ),
					'singular_name'       =>__('Shortcode', 'wp-logo-showcase' ),
					'edit_item'           =>__('Edit Shortcode', 'wp-logo-showcase' ),
					'new_item'            =>__('New Shortcode', 'wp-logo-showcase' ),
					'view_item'           =>__('View Shortcode', 'wp-logo-showcase' ),
					'search_items'        =>__('Shortcode Locations', 'wp-logo-showcase' ),
					'not_found'	          =>__('No Shortcode found.', 'wp-logo-showcase' ),
					'not_found_in_trash'  =>__('No Shortcode found in trash.', 'wp-logo-showcase' )
				),
				'supports'            => array( 'title'),
				'public'              => false,
				'rewrite'				=> false,
				'show_ui'             => true,
				'show_in_menu'        => 'edit.php?post_type='.$rtWPS->post_type,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
			);
			register_post_type( $rtWPS->shortCodePT, $sc_args );

			// register acf scripts
			$scripts = array();
			$styles = array();

			$scripts[] = array(
				'handle'	=> 'rt-actual-height-js',
				'src'		=> $rtWPS->assetsUrl . "vendor/actual-height/jquery.actual.min.js",
				'deps'		=> array('jquery'),
				'footer' => true
			);
			$scripts[] = array(
				'handle'	=> 'rt-wps',
				'src'		=> $rtWPS->assetsUrl . "js/wps.js",
				'deps'		=> array('jquery'),
				'footer' => true
			);
			// register acf styles
			$styles['rt-fontawsome'] = $rtWPS->assetsUrl . 'vendor/font-awesome/css/font-awesome.min.css';
			$styles['rt-wps'] = $rtWPS->assetsUrl . 'css/wps.css';

			if(is_admin()) {
				$scripts[] = array(
					'handle' => 'rt-colorbox',
					'src' => $rtWPS->assetsUrl . "vendor/colorbox/jquery.colorbox-min.js",
					'deps' => array('jquery'),
					'footer' => false
				);
				$scripts[] = array(
					'handle' => 'ace_code_highlighter_js',
					'src' => $rtWPS->assetsUrl . "vendor/ace/ace.js",
					'deps' => null,
					'footer' => true
				);
				$scripts[] = array(
					'handle' => 'ace_mode_js',
					'src' => $rtWPS->assetsUrl . "vendor/ace/mode-css.js",
					'deps' => array('ace_code_highlighter_js'),
					'footer' => true
				);

				$scripts[] = array(
					'handle' => 'rt-select2',
					'src' => $rtWPS->assetsUrl . "vendor/select2/select2.min.js",
					'deps' => array('jquery'),
					'footer' => false
				);
				$scripts[] = array(
					'handle' => 'rt-wps-admin',
					'src' => $rtWPS->assetsUrl . "js/wps-admin.js",
					'deps' => array('jquery'),
					'footer' => true
				);
				$styles['rt-colorbox'] = $rtWPS->assetsUrl . 'vendor/colorbox/colorbox.css';
				$styles['rt-select2'] = $rtWPS->assetsUrl . 'vendor/select2/select2.min.css';
				$styles['rt-wps-admin'] = $rtWPS->assetsUrl . 'css/wps-admin.css';
			}


			foreach( $scripts as $script )
			{
				wp_register_script( $script['handle'], $script['src'], $script['deps'], $rtWPS->options['version'], $script['footer'] );
			}
			foreach( $styles as $k => $v )
			{
				wp_register_style( $k, $v, false, $rtWPS->options['version'] );
			}

			// admin only
			if( is_admin() )
			{
				add_action('admin_menu', array($this,'admin_menu'));
			}
		}
		function initWidget(){
			global $rtWPS;
			$rtWPS->loadWidget( $rtWPS->widgetsPath );
		}

		function admin_menu()
		{
			global $rtWPS;
			add_submenu_page( 'edit.php?post_type='.$rtWPS->post_type, __('Settings', 'wp-services-showcase'), __('Settings', 'wp-services-showcase'), 'administrator', 'wps_settings', array($this, 'rt_wps_settings') );
		}

		function rt_wps_settings(){
			global $rtWPS;
			$rtWPS->render('settings');
		}

		public function wps_load_text_domain() {
			load_plugin_textdomain( 'wp-services-showcase', FALSE, RT_WPS_PLUGIN_LANGUAGE_PATH);
		}

		function activate(){
			$this->insertDefaultData();
		}

		function deactivate(){

		}

		private function insertDefaultData()
		{
			global $rtWPS;
			update_option($rtWPS->options['installed_version'],$rtWPS->options['version']);
			if(!get_option($rtWPS->options['settings'])){
				update_option( $rtWPS->options['settings'], $rtWPS->defaultSettings);
			}
		}

		function enqueue_scripts(){
			wp_enqueue_style('rt-wps');
			add_action('wp_footer', array($this, 'addCustomCss'));
		}

		public function addCustomCss(){
			global $rtWPS;
			$settings = get_option($rtWPS->options['settings']);
			$cCss = (!empty($settings['custom_css']) ? trim($settings['custom_css']) : null);
			$css = null;
			if($cCss){
				$css .= "<style>";
					$css .= $cCss;
				$css .= "</style>";
			}

			echo $css;
		}

		function admin_enqueue_scripts_settings(){
			global $pagenow, $typenow, $rtWPS;

			// validate page
			if( !in_array( $pagenow, array('edit.php') ) ) return;
			if( $typenow != $rtWPS->post_type ) return;

			// scripts
			wp_enqueue_script(array(
				'jquery',
				'ace_code_highlighter_js',
				'ace_mode_js',
				'rt-wps-admin',
			));

			// styles
			wp_enqueue_style(array(
				'rt-wps-admin',
			));

			$nonce = wp_create_nonce( $rtWPS->nonceText() );
			wp_localize_script( 'rt-wps-admin', 'wps',
				array(
					'nonceID' => $rtWPS->nonceId(),
					'nonce' => $nonce,
					'ajaxurl' => admin_url( 'admin-ajax.php' )
				) );
		}
	}
endif;