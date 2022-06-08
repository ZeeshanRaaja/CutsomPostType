<?php


//Init Hook for the custom post type
 
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




/*
 ==================
 Ajax Search
======================	 
*/
// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script type="text/javascript">
function fetch(){

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
        success: function(data) {
            jQuery('#datafetch').html( data );
        }
    });

}
</script>

<?php
}

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('create_post_type') ) );
    if( $the_query->have_posts() ) :
        echo '<ul>';
        while( $the_query->have_posts() ): $the_query->the_post(); ?>

            <li><a href="<?php echo esc_url( post_permalink() ); ?>"><?php the_title();?></a></li>

        <?php endwhile;
       echo '</ul>';
        wp_reset_postdata();  
    endif;

    die();
}



?>