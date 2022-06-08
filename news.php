<?php
/** Template Name: news */


get_header();   ?>

<!-- <div class="search_bar">
    <form action="/" method="get" autocomplete="off">
        <input type="text" name="s" placeholder="Search Code..." id="keyword" class="input_search" onkeyup="fetch()">
        <button>
            Search
        </button>
    </form>
    <div class="search_result" id="datafetch">
        <ul>
            <li>Please wait..</li>
        </ul>
    </div>
</div> -->
<div class="wrap">
    <div id="primary" class="content_area">
        <main id="main" class="site-main" role="main">
            <?php
            $curentpage = get_query_var('paged');
            $args = array
            (
                'post_type'      => 'news',
                'posts_per_page' => '2',
                'publish_status' => 'published',
                'paged' => $curentpage
            );

            $query = new WP_Query($args);
            
            if($query->have_posts()) :

                while($query->have_posts()) :

                    $query->the_post();?>
                
                    <?php the_post_thumbnail(); ?>
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                
            <?php
                endwhile;   
                    echo paginate_links(array(
                        'total' => $query->max_num_pages
                    ));
            endif;    
            ?>
        </main>
    </div>
</div>

<?php get_footer();?>