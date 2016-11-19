<?php


/*
function load_book_template($template) {

    global $post;

    // Is this a "my-custom-post-type" post?

    if ($post->post_type == "book"){

        //Your plugin path 

        $plugin_path = WTR_PLUGIN_DIR;


        // The name of custom post type single template

        $template_name = 'includes/single-book.php';

        // A specific single template for my custom post type exists in theme folder? Or it also doesn't exist in my plugin?

        if($template === get_stylesheet_directory() . '/' . $template_name

            || !file_exists($plugin_path . $template_name)) {


            //Then return "single.php" or "single-my-custom-post-type.php" from theme directory.

            return $template;

        }

        // If not, return my plugin custom post type template.

        return $plugin_path . $template_name;

    }



    //This is not my custom post type, do nothing with $template

    return $template;





     wp_reset_postdata();

}

add_filter('single_template', 'load_book_template');
*/

add_action('loop_start', 'display_tax_title', 20);

function display_tax_title() {
if (is_tax('genre') || is_tax('subgenre') ){
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); print "<div style='text-transform:capitalize;'><h1> $term->taxonomy: $term->name</h1></div>";
}
}


function be_archive_post_class( $classes ) {
	// Don't run on single posts or pages
	if( is_singular() || is_home())
		return $classes;
	$classes[] = 'one-sixth';
	global $wp_query;
	if(  0 == $wp_query->current_post ||0 == $wp_query->current_post % 6 )
		$classes[] = 'first';
	return $classes;
}
add_filter( 'post_class', 'be_archive_post_class' );


add_filter( 'the_content','filter_function_name');
function filter_function_name($content){
if(is_archive() || is_search()){
$content = '<p>'.$content.'<a href='.get_permalink().'>'.get_the_title().'</a></p>';}

   return $content;

}

if(!function_exists('wtr_change_table_column_titles')){
    function wtr_change_table_column_titles($columns){
        unset($columns['date']);// temporarily remove, to have custom column before date column
unset($columns['series']);// temporarily remove, to have custom column before date column
        $columns['genre'] = 'Genre';
$columns['subgenre'] = 'Subgenre';
$columns['writer'] = 'Writer';
$columns['series'] = 'Series';

        $columns['date'] = 'Date Read';// readd the date column
        return $columns;
    }
    add_filter('manage_book_posts_columns', 'wtr_change_table_column_titles');
}

if(!function_exists('wtr_change_column_rows')){
    function wtr_change_column_rows($column_name, $post_id){
        if($column_name == 'genre'){
            echo get_the_term_list($post_id, 'genre', '', ', ', '').PHP_EOL;
        }
 if($column_name == 'writer'){
            echo get_the_term_list($post_id, 'writer', '', ', ', '').PHP_EOL;
        }
if($column_name == 'subgenre'){
            echo get_the_term_list($post_id, 'subgenre', '', ', ', '').PHP_EOL;
        }
if($column_name == 'series'){
            echo get_the_term_list($post_id, 'series', '', ', ', '').PHP_EOL;
        }
    }
    add_action('manage_book_posts_custom_column', 'wtr_change_column_rows', 10, 2);
}

if(!function_exists('wtr_change_sortable_columns')){
    function wtr_change_sortable_columns($columns){
        $columns['genre'] = 'genre';
$columns['writer'] = 'writer';
$columns['subgenre'] = 'subgenre';
$columns['series'] = 'series';
        return $columns;
    }
    add_filter('manage_edit-book_sortable_columns', 'wtr_change_sortable_columns');
}

if(!function_exists('wtr_sort_custom_column2')){
    function wtr_sort_custom_column2($clauses, $wp_query){
        global $wpdb;
        if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'writer'){
            $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
            $clauses['where'] .= "AND (taxonomy = 'writer' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
            if(strtoupper($wp_query->get('order')) == 'ASC'){
                $clauses['orderby'] .= 'ASC';
            } else{
                $clauses['orderby'] .= 'DESC';
            }
        }
        return $clauses;
    }

    add_filter('posts_clauses', 'wtr_sort_custom_column2', 10, 2);
}
if(!function_exists('wtr_sort_custom_column3')){
    function wtr_sort_custom_column3($clauses, $wp_query){
        global $wpdb;
        if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'genre'){
            $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
            $clauses['where'] .= "AND (taxonomy = 'genre' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
            if(strtoupper($wp_query->get('order')) == 'ASC'){
                $clauses['orderby'] .= 'ASC';
            } else{
                $clauses['orderby'] .= 'DESC';
            }
        }
        return $clauses;
    }

    add_filter('posts_clauses', 'wtr_sort_custom_column3', 10, 2);
}

if(!function_exists('wtr_sort_custom_column4')){
    function wtr_sort_custom_column4($clauses, $wp_query){
        global $wpdb;
        if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'subgenre'){
            $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
            $clauses['where'] .= "AND (taxonomy = 'subgenre' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
            if(strtoupper($wp_query->get('order')) == 'ASC'){
                $clauses['orderby'] .= 'ASC';
            } else{
                $clauses['orderby'] .= 'DESC';
            }
        }
        return $clauses;
    }

    add_filter('posts_clauses', 'wtr_sort_custom_column4', 10, 2);
}

if(!function_exists('wtr_sort_custom_column5')){
    function wtr_sort_custom_column5($clauses, $wp_query){
        global $wpdb;
        if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'series'){
            $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
            $clauses['where'] .= "AND (taxonomy = 'series' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
            if(strtoupper($wp_query->get('order')) == 'ASC'){
                $clauses['orderby'] .= 'ASC';
            } else{
                $clauses['orderby'] .= 'DESC';
            }
        }
        return $clauses;
    }

    add_filter('posts_clauses', 'wtr_sort_custom_column5', 10, 2);
}


 function wtr_featured_image($post_ID) {
        $post_thumbnail_id = get_post_thumbnail_id($post_ID);
        if ($post_thumbnail_id) {
            $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'admin-feat');
            return $post_thumbnail_img[0];
        }
    }
	
	 function wtr_columns_head($defaults) {
        $defaults['featured_image'] = 'Featured Image';
        return $defaults;
    }
	
	function wtr_columns_content($column_name, $post_ID) {
        if ($column_name == 'featured_image') {
            $post_featured_image = wtr_featured_image($post_ID);
            if ($post_featured_image) {
                echo '<img src="' . $post_featured_image . '" />';
            }
        }
    }
	add_filter('manage_book_posts_columns', 'wtr_columns_head', 10);
	add_action('manage_book_posts_custom_column', 'wtr_columns_content', 10, 2);
	
function column_image_size($post_ID) {
	add_image_size( 'admin-feat', 50, 75, true );
}
	add_action('admin_init', 'column_image_size');

function wtr_modify_uploaded_file_names($image_name) {

    // Get the parent post ID, if there is one
    if( isset($_GET['post_id']) ) {
        $post_id = $_GET['post_id'];
    } elseif( isset($_POST['post_id']) ) {
        $post_id = $_POST['post_id'];
    }

    // Only do this if we got the post ID--otherwise they're probably in
    //  the media section rather than uploading an image from a post.
    if(is_numeric($post_id)) {

        // Get the post slug
        $post_obj = get_post($post_id);
        $post_slug = $post_obj->post_name;

        // If we found a slug
        if($post_slug) {
            $i = 1;
            $i++;
           
            $image_name['name'] = $post_slug . '-' . $i . '.jpg';

        }

    }

    return $image_name;

}
add_filter('wp_handle_upload_prefilter', 'wtr_modify_uploaded_file_names', 1, 1);

add_shortcode('star_rating', 'wp_starrate_shortcode');
function wp_starrate_shortcode(){
$rate = get_post_meta( get_the_ID(), 'wtr_myrating', true );
if ( $rate ) {
$args = array(
   'rating' => $rate,
   'type' => '',
   'number' => '',
'echo' => false,
);
$mytest = "<div class='entry-terms'><strong>My Rating: " . wp_star_rating( $args ) . "</strong></div>" ;


	}
return $mytest ;
    }
	

add_filter('the_content', 'display_book_content');

function display_book_content($content)
{
    if (!is_singular('book')) {
return $content;
} else {
if ( in_the_loop() && is_main_query() ) {
        echo '<div class="one-half first">';
$summary = get_post_meta( get_the_ID(), 'wtr_summary', true );
if ( $summary ) {
print "$summary<br /><br />";
}
$writers = wp_get_post_terms(get_the_ID(), 'writer');
if($writers ){
foreach($writers as $writer) {
          echo "<div class='entry-terms'><strong>Author:</strong> <a href='" . get_term_link($writer) . "' title='" . $writer->name . "'>" . $writer->name . "</a></div>";
}
}
$price = get_post_meta( get_the_ID(), 'wtr_price', true );
if ( $price ) {
echo '<div class="entry-terms"><strong>Price:</strong> $'. $price .'<span class="price_notice"> *Individual store prices may vary.</span></div>';
}
$ISBN= get_post_meta( get_the_ID(), 'wtr_ISBN', true );
if ( $ISBN ) {
echo '<div class="entry-terms"><strong>ISBN:</strong> '. $ISBN .'</div>';
}

$publisher= get_post_meta( get_the_ID(), 'wtr_publisher', true );
if ( $publisher ) {
echo '<div class="entry-terms"><strong>Publisher:</strong> '. $publisher .'</div>';
}
$pubdate= get_post_meta( get_the_ID(), 'wtr_pubdate', true );
if ( $pubdate ) {
echo '<div class="entry-terms"><strong>Year of Publication:</strong> '. $pubdate .'</div>';
}
$terms = wp_get_post_terms(get_the_ID(), 'series');
if($terms ){
echo "<div class='entry-terms'><strong>Series:</strong> ";
foreach($terms as $term) {
          echo "<a href='" . get_term_link($term) . "' title='" . $term->name . "'>" . $term->name . "</a>, ";
}
echo "</div>";
}
$genres = wp_get_post_terms(get_the_ID(), 'genre');
if($genres ){
echo "<div class='entry-terms'><strong>Genre:</strong> ";
foreach($genres as $genre) {
          echo "<a href='" . get_term_link($genre) . "' title='" . $genre->name . "'>" . $genre->name . "</a>, ";
}
echo "</div>";
}
$subgenres = wp_get_post_terms(get_the_ID(), 'subgenre');
if($subgenres ){
echo "<div class='entry-terms'><strong>Subgenre:</strong> ";
foreach($subgenres as $subgenre) {
          echo "<a href='" . get_term_link($subgenre) . "' title='" . $subgenre->name . "'>" . $subgenre->name . "</a>, ";
}
echo "</div>";
}

$awards = wp_get_post_terms(get_the_ID(), 'award');
if($awards ){
echo "<div class='entry-terms'><strong>Awards:</strong> ";
foreach($awards as $award) {
          echo "<a href='" . get_term_link($award) . "' title='" . $award->name . "'>" . $award->name . "</a>, ";
}
echo "</div>";
}
$dateread=get_post_meta( get_the_ID(), 'wtr_dateread', true );
if($dateread ){
echo '<div class="entry-terms"><strong>Date Read:</strong> '. $dateread .'</div>';
}
$rate = get_post_meta( get_the_ID(), 'wtr_myrating', true );
if($rate){
echo do_shortcode ('[star_rating]');
}
$title3 = get_the_title();

$amazon= get_post_meta( get_the_ID(), 'amazon_status', true );
$amazonurl = get_post_meta( get_the_ID(), 'amazon_url', true );
$amazonimage = get_post_meta( get_the_ID(), 'amazon_image', true );
$amazonid = get_post_meta( get_the_ID(), 'amazon_id', true );
$indie= get_post_meta( get_the_ID(), 'indie_status', true );
$indieurl = get_post_meta( get_the_ID(), 'indie_url', true );
$indieimage = get_post_meta( get_the_ID(), 'indie_image', true );
$indieid = get_post_meta( get_the_ID(), 'indie_id', true );
$ebay= get_post_meta( get_the_ID(), 'ebay_status', true );
$ebayurl = get_post_meta( get_the_ID(), 'ebay_url', true );
$ebayimage = get_post_meta( get_the_ID(), 'ebay_image', true );
$ebayid = get_post_meta( get_the_ID(), 'ebay_id', true );
 if ( $amazon === 'on' ) {
print "<br /><span class='purchase_style' ><br /><strong>Purchase $title3</strong></span><br /><br />";
print "<a href='$amazonurl$ISBN/?tag=$amazonid' target='_blank'> <img src='$amazonimage' class='alignleft' /> Buy from Amazon</a><br /><br /><br />";
}
 if ( $indie === 'on' ) {

print "<a href='$indieurl$ISBN?aff=$indieid' target='_blank'> <img src='$indieimage' class='alignleft' /> Buy from IndieBound</a><br /><br /><br />";
}
 if ( $ebay === 'on' ) {

print "<a href='$ebayurl' target='_blank'> <img src='$ebayimage' class='alignleft' /> Buy from Ebay</a><br />";
}
if(adrotate_group){
echo '<br /><br />';
echo adrotate_group(4);
}

echo '</div>';
echo '<div class="one-half">';



$img = get_post_thumbnail_id();
$feat_image = wp_get_attachment_image_src($img,'tax-test', true);
if($feat_image){
print "<a href='$amazonurl$ISBN/?tag=$amazonid' target='_blank'><img src='$feat_image[0]' /></a><br /><br />";
}
$title2 = get_the_title();
$isbn = get_post_meta( get_the_ID(), 'wtr_ISBN', true );
$showgoodreads = get_post_meta( get_the_ID(), 'wtr_goodreads', true );

if ( $isbn && $showgoodreads !='' ) {
print "<div id='goodreads-widget'>
  <div id='gr_header'>Goodreads Reviews $title2</div><br />
  <iframe id='the_iframe' src='http://www.goodreads.com/api/reviews_widget_iframe?did=DEVELOPER_ID&format=html&header_text=Goodreads+reviews&isbn=$isbn&links=660&min_rating=&num_reviews=3&review_back=ffffff&stars=000000&stylesheet=&text=444' width='375' height='400' frameborder='0'></iframe></div>";
}
    
echo '</div><div style="clear: both;"></div>';
global $post;
$custom_taxterms = wp_get_object_terms( $post->ID, 'subgenre', array('fields' => 'ids') );
// arguments
$args = array(
'post_type' => 'book',
'post_status' => 'publish',
'posts_per_page' => 3, // you may edit this number
'orderby' => 'rand',
'tax_query' => array(
    array(
        'taxonomy' => 'subgenre',
        'field' => 'id',
        'terms' => $custom_taxterms
    )
),
'post__not_in' => array ($post->ID),
);
$related_items = new WP_Query( $args );
echo '<p>&nbsp;</p><h4>You Might Like:</h4>';

if ( $related_items->have_posts() ) :
while ( $related_items->have_posts() ) : $related_items->the_post();

echo '<div class="one-fourth"><a href="' . get_permalink() . '">' . get_the_post_thumbnail( $_post->ID, 'front-grid' ) . '</a><br /><div class="entry-terms_single"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div></div>';

endwhile;
wp_reset_postdata();

else :
    echo 'No Related Posts';
endif;

wp_reset_query();

}
}
}




/*
add_action('the_content', 'display_book_archive_content');
function display_book_archive_content($content)
{
    if (is_archive() && in_the_loop()){

$content .='do stuff';}
remove_action('the_content', 'display_book_archive_content');

}
*/





/*function be_archive_post_class( $classes ) {
if(is_archive()
	global $wp_query;
	if( ! $wp_query->is_main_query() )

		return $classes;
		
	$classes[] = 'one-third';
	if( 0 == $wp_query->current_post % 3 )
		$classes[] = 'first';
	return $classes;
}

add_filter( 'post_class', 'be_archive_post_class' );
*/

