<?php
/*
Plugin Name: Frontier Restrict Backend
Plugin URI: http://wordpress.org/extend/plugins/frontier-restrict-backend
Description: Restrict non-admin users from accessing the backend (admin area)
Author: finnj
Version: 1.0.2
Author URI: http://wpfrontier.com
*/

define('FRONTIER_RESTRICT_BACKEND_VERSION', "1.0.2"); 
define('FRONTIER_RESTRICT_BACKEND_DIR', dirname( __FILE__ )); //an absolute path to this directory

//Restrict users who dont have capability manage_options to access the admin area
function frontier_restrict_backend($query) 
	{
    if ( is_admin() && ! current_user_can( 'manage_options' ) )
        {
        $admin_ok = false;
        if (defined( 'DOING_AJAX' ) && DOING_AJAX )
        	{
        	$admin_ok = true;
        	}
        else
        	{
        	if (strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/media-upload.php' ) !== false)
        		{
        		$admin_ok = true;
        		}
        	}
        if ( !$admin_ok)
        	{
        	error_log("Back-end access blocked");
        	wp_redirect( home_url() );
        	exit;
        	}
        else
        	{
        	error_log("Back-end access allowed - Media upload or AJAX");
        	}
        }
    }
add_action( 'init', 'frontier_restrict_backend' );
?>