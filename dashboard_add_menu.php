<?php
	/*
	Plugin name: WP Admin Add Page
	Version: 0.1
	Description: Create A WordPress Admin Menu and Page
	Author: WJ Carey
	Author URI: https://wjcarey.io
	Plugin URI: https://github.com/wjcarey/wordpress-admin-add-page
	License: Apache License 2.0
	*/

	require_once( plugin_dir_path( __FILE__ ) . '/admin_pages.php' );

	class Admin_Dashboard_Menu {

		function __construct() { 
            add_action( 'admin_enqueue_scripts', array(&$this, 'register_admin_menu_scripts') );
            add_action( 'admin_enqueue_scripts', array(&$this, 'load_admin_menu_scripts') );
            add_action( 'admin_menu', array(&$this, 'register_admin_menu') );
        }
        
        public function register_admin_menu_scripts() {
            wp_register_style( 'wordpress-admin-add-page', plugins_url( 'wordpress-admin-add-page/css/admin_page.css' ) );
        }

        public function load_admin_menu_scripts($hook) {
            // Load only on ?page=insert-primary-title
            if( $hook == 'toplevel_page_primary-title' ) {
                wp_enqueue_style( 'wordpress-admin-add-page' );  
            }
            // Load only on ?page=insert-secondary-title
            if( $hook == 'primary-title_page_secondary-title' ) {
                wp_enqueue_style( 'wordpress-admin-add-page' );  
            }
        }

		public function register_admin_menu() {		
			add_menu_page(
				'Primary Title', 'Primary Title', 'manage_options', 'primary-title', array(&$this, 'primary_page_callback'), 'dashicons-schedule', 3
			);
			add_submenu_page( 
				'primary-title', 'secondary Title', 'secondary Title', 'manage_options', 'secondary-title', array(&$this, 'secondary_page_callback')
			);
		}

		public function primary_page_callback() {
			global $primary_page_contents;
			echo $primary_page_contents;
		}

		public function secondary_page_callback() {
			global $secondary_page_contents;
			echo $secondary_page_contents;
		}

	}

	$adm = new Admin_Dashboard_Menu();
?>