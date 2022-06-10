<?php


//Init Hook for the custom post type
 
add_action('wp_enqueue_scripts', 'auto_scripts');
function auto_scripts()
{

wp_enqueue_script('cus_js',get_stylesheet_directory_uri()."/jq.js",array('jquery'));
wp_localize_script('cus_js','ajax_obj',array('ajaxurl'=>admin_url('admin-ajax.php')));
    
}




add_action('init', 'create_post_type');
 
function create_post_type() {
 
$supports = array(
'title', // post title
'editor', // post content 
'author', // post author
'thumbnail', // featured images
'excerpt', // post excerpt
'custom-fields', // custom fields
'comments', // post comments
'revisions', // post revisions
'post-formats', // post formats
);
 
$labels = array(
'name' => _x('news', 'plural'),
'singular_name' => _x('news', 'singular'),
'menu_name' => _x('news', 'admin menu'),
'name_admin_bar' => _x('news', 'admin bar'),
'add_new' => _x('Add New', 'add new'),
'add_new_item' => __('Add New news'),
'new_item' => __('New news'),
'edit_item' => __('Edit news'),
'view_item' => __('View news'),
'all_items' => __('All news'),
'search_items' => __('Search news'),
'not_found' => __('No news found.'),
);
 
$args = array(
'supports' => $supports,
'labels' => $labels,
'description' => 'Holds our News and specific data',
'public' => true,
'taxonomies' => array( 'category', 'post_tag' ),
'show_ui' => true,
'show_in_menu' => true,
'show_in_nav_menus' => true,
'show_in_admin_bar' => true,
'can_export' => true,
'capability_type' => 'post',
 'show_in_rest' => true,
'query_var' => true,
'rewrite' => array('slug' => 'news'),
'has_archive' => true,
'hierarchical' => false,
'menu_position' => 6,
'menu_icon' => 'dashicons-megaphone',
);
 
register_post_type('news', $args); // Register Post type
}
 

// function load_style(){


// wp_enqueue_style('customm',get_stylesheet_directory_uri().'/citystyle/cus.css',array(),'1.0.0','all');
// wp_enqueue_script('sc',get_stylesheet_directory_uri().'/sc.js',array(),'1.0.0',false);


// }


// add_action('wp_enqueue_scripts','load_style');


function create_shortcode_post_type(){

$curentpage = get_query_var('paged');

$args=array(

'post_type' =>'news',
'posts_per_page'=>'2',
'publish_status'=>'published',
'paged'=>$curentpage

);

$query=new WP_Query($args);

$result="";
if($query->have_posts()):

while($query->have_posts()):
	$query->the_post();
	
	$result = $result .get_the_post_thumbnail();
	$result = $result .get_the_title();
	$result = $result .get_the_content();



endwhile;

echo paginate_links(array(
	'total' => $query->max_num_pages));




wp_reset_postdata();

endif;

return $result;

}

add_shortcode('mycode','create_shortcode_post_type');





// add the ajax fetch js


// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');

function data_fetch() {
    $the_query = new WP_Query( array( 'posts_per_page' => 3, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('news') ) );
    if( $the_query->have_posts() ) :
        
        while( $the_query->have_posts() ): $the_query->the_post();     
        ?>
        <div class="row">
            <div> 
                <h1 style="text-align: center;"> <a href=" <?php the_permalink(); ?> "> <?php the_title(); ?></a></h1>
                <a href="<?php the_permalink(); ?> ">  <?php the_post_thumbnail();?> </a>
                <p style="text-align: center;" ><?php the_content(); ?></p>
            </div>       
            </div>
            
            <?php   
        endwhile; 
        wp_reset_postdata();  
    endif;

    
    die();
}


?>
