<?php 
/*
Plugin Name: Winsome Hover Gallery
Plugin URI:http://www.mhost.5gbfree.com/demo
Description: This plugin will help you to create eye-catching photo gallery with awesome hover effects in your wordpress theme.
Author: Masum Abdullah
Author URI:http://abdullahmasum.elance.com/
Version: 1.0
*/

 // add script

function hovergallery_plugin_main_css() {

global $var;
		
		wp_enqueue_style( 'hovergallery-css', plugins_url( '/css/style_common.css', __FILE__ ));
		
		
		wp_enqueue_style( 'custhover-css', plugins_url( '/css/style8.css', __FILE__ ));
	}

add_action( 'wp_enqueue_scripts', 'hovergallery_plugin_main_css' );

		
		
		  // add image custom post support
	  
	 function hovergallery_register_custom() {
	       
		   register_post_type('hover-gallery',
		     array(
			    'labels'=>array(
				         'name'=>__('Hover images'),
						 'singular_name'=>__('Hover image')
				),
				'public'=>true,
				'supports'=> array('title','thumbnail','editor'),
				'has_archive'=>true ,
				'rewrite'=>array('slug'=>'hoverimage-item')
			 )
		   );
			      }
     add_action('init', 'hovergallery_register_custom');
	 

    // add image custom post taxonomy support
	 
	 	function add_hovercustom_taxonomy(){
		
		   register_taxonomy(
		          'hoverimage-category',   
				  'hover-gallery', 
				  array(
				    'hierarchical'=>true,
					'label'=>'Image category',
					'query_var'=>true,
					'show_admin_column'=>true,
					'rewrite'=>array(
									'slug'=>'image-category',
									'with_front'=>true
									)
					)
		       );
			   		   }
			   
		add_action('init','add_hovercustom_taxonomy');
		
		
  
  		// Add image gallery Loop 

   function wws_get_hoverimage_shortcode($atts){
   
   global $type;
  
	   extract(shortcode_atts(
	      array(
			   'category'=>'',
	         ),$atts)
			 );
			 $q=new WP_Query(array(
			 
					'post_type'=>'hover-gallery',
					'hoverimage-category'=>$category
					
					));
				$markup='<ul class="hover-list">';	
			while($q->have_posts()): $q->the_post();
			  $idd=get_the_ID();
			  
        $small  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small_image' );
	         
			 $markup.='<li><div class="view view-eighth">
					<img src="'.$small[0].'" />
                    <div class="mask">
                        <h2>'.get_the_title().'</h2>
                        <p>'.get_the_content().'</p>
                        <a href="'.get_the_permalink().'" class="info">Read More</a>
                    </div>
						';
			
			endwhile;
			$markup.='</div></li></ul>';
			wp_reset_query();
			return $markup;
  }
  add_shortcode('hover_gallery','wws_get_hoverimage_shortcode');
  
  
  	add_theme_support( 'post-thumbnails', array( 'post','hover-gallery' ) );
	add_image_size( 'small_image',300, 200, true ); 

  
  	function hoveradmin_style(){
	?>
		<style type="text/css">
		
		.hover-list li{
		     list-style:none;
		     width:300px;
		     height:200px;
		     float:left;
		     overflow:hidden
		}
		.entry-content{
		     min-width:930px!important;
		     min-height:250px;
		}
		</style>
	<?php
	}
	add_action('init','hoveradmin_style');	
	
?>