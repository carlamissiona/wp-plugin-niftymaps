<?php
/*
Plugin Name: Carla-WP-Banner
Plugin URI: http://yourdomain.com/
Description: A simple hello world wordpress plugin
Version: 1.0
Author: Carla Missiona
Author URI: http://yourdomain.com
License: GPL

*/



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * ** * * *
=================================================================
This file is part of  Carla-WP-Banner.

Carla-WP-Banner is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Carla-WP-Banner is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Carla-WP-Banner.  If not, see <http://www.gnu.org/licenses/>
================================================================
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
*/


class Carla_WP_Banner{
       public $render; 
       public $imglist;
       public $meta;
       public $gen_id;
    function __construct(){

        $this->render = new TemplateEngine();

        /* lifecycle */
        register_activation_hook(__FILE__, array( $this , 'activate' ) );
        register_deactivation_hook(__FILE__, array( $this , 'deactivate' ) );
        /* lifecycle */

        /*admin_menu*/
         add_action( 'admin_menu', array( $this, 'add_admin_menu' ));

         add_action( 'admin_action_new_carla_wp_banner', array( $this, 'add_new_banner' ) );

         add_action( 'wp_head', array( $this, 'photobannerstyle' ) );
  
    }   

    function deactivate(){
        global $wpdb; 
        $sql ="DROP DATABASE 'wp_cwpb_banners'";
        $wpdb->query( $sql );

    }

    function activate(){
      global $wpdb;  
      if($wpdb->get_var("SHOW TABLES LIKE 'wp_cwpb_banners'") != "wp_cwpb_banners") {
        $sql = "CREATE TABLE IF NOT EXISTS `wp_cwpb_banners` (
              `id` int(255) NOT NULL AUTO_INCREMENT,
              `name` varchar(64) NOT NULL,
              `desc` varchar(255) NOT NULL,
              `img` varchar(255) NOT NULL,
              `meta` varchar(255) DEFAULT NULL,
              `shortcode` varchar(64) NOT NULL,
              `short_id` varchar(64) NOT NULL,
              `saved` int(2) NOT NULL DEFAULT 0,
              `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        $wpdb->query( $sql );

         
      }

    }
    function add_admin_menu(){

      add_menu_page( "Photo Banner", "Carla WP Banner","manage_options","carla-wp-banner dash",array($this , 'add_settings_page' ), plugins_url( 'carla-wp-banner/images/icon.png' ), "4.44");    
      add_submenu_page( NULL,"Add New Banner", "Submenu" , "manage_options","carla-wp-banner new", array($this , 'action_new_banner' ) );
      add_submenu_page( NULL,"Delete All", "Submenu" , "manage_options","carla-wp-banner delete all", array($this , 'action_delete_all' ) );
    }  


    function action_generate_shortcode( $atts ){
      $row =array();
      global $wpdb; 
      $sql ="Select * From `wp_cwpb_banners` Where short_id ='" .$atts['id']."'";       
      $row = $wpdb->get_results( $sql, "ARRAY_A" ) ;
      $html = "<div class='bcontainer'><div class='photobanner'>";
      foreach( explode( "," ,$row[0]['img'] )  as $index => $img  ) {
           if($img != ""  ){
              if( $index == 0 ){
                $html .= "<img class='first' src='".$img."' width='200px' height='200px'>";
              }else{
                $html .= "<img src='".$img."' width='200px' height='200px'>";
              }
           }
          

      }  
      $html .= "</div></div>";
      wp_enqueue_style('pbs',  plugins_url('carla-wp-banner/css/design_shack.css'));
      return  $html;     
 
    }
  
    function photobannerstyle() {
         wp_enqueue_style('pbs',  plugins_url('carla-wp-banner/css/design_shack.css'));
    }
    function action_delete_all(){
        if( isset($_POST['action_delete_all'] ) ){
          global $wpdb;
          $d = $wpdb->query("TRUNCATE TABLE`wp_cwpb_banners`");
        }
    }


    function action_new_banner(){
        if( isset($_POST['action_new_banner'] ) ){
               // generate id 
               $generated_id = substr(uniqid('', true), -5);
               echo "<div class='sc_id'>" .$generated_id."</div>";
               if( is_null($_POST['meta']) || $_POST['meta'] === NULL || $_POST['meta'] =="")
                  $_POST['meta'] =" null ";
               // Store to database 
                global $wpdb;
                $data = array(
                    "name" => $_POST['name'] ,
                    "desc" => $_POST['desc'],  
                    "img"  => $_POST['img'] ,
                    "meta" => $_POST['meta'] ,  
                    "short_id" => $generated_id ,
                    "shortcode" => "[cwpb id='".$generated_id."']"
                );
              $res = $wpdb->insert( "wp_cwpb_banners", $data, array( '%s', '%s','%s','%s','%s','%s' ) ) ;
               if( $res == true ||   $res == 1 ){                 
                  echo "<div class='draft_db'>" . $res ."</div>";
   
               }else{
                  while( $res != 1 ){
                    $res = $wpdb->insert( "wp_cwpb_banners", $data, array( '%s', '%s','%s','%s','%s','%s' ) ) ;
                  }
               }    
              echo "<use-code>".$generated_id."</use-code>";
           
              return false;
        }else{
            echo "Insufficient permission";
        }
    }

  
 
    function add_settings_page(){  

       /* get photobanner from database */
        global $wpdb; 
        $sql ="Select * From `wp_cwpb_banners`"; 
        
    
        $data = array(  
                "date" => "date now" ,
                "author" => "Carla" ,
                "records" => $wpdb->get_results( $sql, "ARRAY_A" )
        );
        wp_enqueue_script('accordion');
        if(function_exists( 'wp_enqueue_media' )){
            wp_enqueue_media();
        }else{
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }
        wp_enqueue_script( 'uploadjs', plugins_url( 'carla-wp-banner/js/upload.js' ), array(), '1.0.0', true );
        
        print $this->render->display("settings" , $data );


    }

 
}
$instance = new Carla_WP_Banner();
if ( shortcode_exists( "cwpb" ) ) {
    
}else{
    add_shortcode( "cwpb",  array( $instance, "action_generate_shortcode" ) );
} 

/* Template class */
class TemplateEngine{

    function __construct(){

    }

   function display($temp, $param){
       ob_start();
       $temp = "template/".$temp.".php";
       //extract everything in param into the current scope
       extract($param, EXTR_SKIP);
       include($temp);
       ob_end_flush();
    }
   
}
/* Template class */