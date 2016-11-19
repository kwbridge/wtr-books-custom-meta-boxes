<?php
/**
 * This file adds the custom post type single post template to any Genesis child Theme.
 */

/*add remove genesis actions here */


function display_book_data() {
echo '<div class="one-half first">';
$summary = get_post_meta( get_the_ID(), 'wtr_summary', true );
if ( $summary ) {
print "$summary<br /><br />";
}
/*echo do_shortcode('[post_terms taxonomy="writer" before="<strong>Author:</strong> "]');*/
$writers = wp_get_post_terms(get_the_ID(), 'writer');
if($writers ){
foreach($writers as $writer) {
          echo "<strong>Author:</strong> <a href='" . get_term_link($writer) . "' title='" . $writer->name . "'>" . $writer->name . "</a>";
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
/*echo do_shortcode('[post_terms taxonomy="series" before="<strong>Series:</strong> " after="<br />"]');*/
$terms = wp_get_post_terms(get_the_ID(), 'series');
if($terms ){
echo "<div class='entry-terms'><strong>Series:</strong> ";
foreach($terms as $term) {
          echo "<a href='" . get_term_link($term) . "' title='" . $term->name . "'>" . $term->name . "</a>, ";
}
echo "</div>";
}

/*echo do_shortcode('[post_terms taxonomy="genre" before="<strong>Genre</strong>: " after="<br />"]');*/
$genres = wp_get_post_terms(get_the_ID(), 'genre');
if($genres ){
echo "<div class='entry-terms'><strong>Genre:</strong> ";
foreach($genres as $genre) {
          echo "<a href='" . get_term_link($genre) . "' title='" . $genre->name . "'>" . $genre->name . "</a>, ";
}
echo "</div>";
}
$dateread=get_post_meta( get_the_ID(), 'wtr_dateread', true );
if($dateread ){
echo '<div class="entry-terms"><strong>Date Read:</strong> '. $dateread .'</div>';
}

$rate = get_post_meta( get_the_ID(), 'wtr_myrating', true );
/*if ( $rate ) {
$args = array(
   'rating' => $rate,
   'type' => '',
   'number' => '',
);

print "<div class='entry-terms'><strong>My Rating:"; wtr_star_myrating( $args ); print "</strong></div>";
echo $rate;
}
*/
if($rate){
echo do_shortcode ('[star_rating]');
}
echo the_content();

$title3 = get_the_title();
$amazon= get_post_meta( get_the_ID(), 'amazon_status', true );
$amazonurl = get_post_meta( get_the_ID(), 'amazon_url', true );
$amazonimage = get_post_meta( get_the_ID(), 'amazon_image', true );
$amazonid = get_post_meta( get_the_ID(), 'amazon_id', true );
$indie= get_post_meta( get_the_ID(), 'indie_status', true );
$indieurl = get_post_meta( get_the_ID(), 'indie_url', true );
$indieimage = get_post_meta( get_the_ID(), 'indie_image', true );
$indieid = get_post_meta( get_the_ID(), 'indie_id', true );
 if ( $amazon === 'on' ) {


print "<a href='$amazonurl$ISBN/?tag=$amazonid' target='_blank'> <img src='$amazonimage' class='alignleft' /> Buy from Amazon</a><br /><br /><br />";
}
 if ( $indie === 'on' ) {

print "<a href='$indieurl$ISBN?aff=$indieid' target='_blank'> <img src='$indieimage' class='alignleft' /> Buy from IndieBound</a><br /><br /><br />";
}
echo '</div>';
}
//* Add featured image on single post
/*add_action( 'genesis_entry_header', 'single_post_featured_image' );*/
function single_post_featured_image() {
echo '<div class="one-half">';


$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'tax-test' );
if($feat_image){
print "<a href='$feat_image' target='_blank'><img src='$feat_image' /></a><br /><br />";
}

$title2 = get_the_title();
$isbn = get_post_meta( get_the_ID(), 'wtr_ISBN', true );
$showgoodreads = get_post_meta( get_the_ID(), 'wtr_goodreads', true );

if ( $isbn && $showgoodreads !='' ) {
print "<div id='goodreads-widget'>
  <div id='gr_header'>Goodreads Reviews $title2</div><br />
  <iframe id='the_iframe' src='http://www.goodreads.com/api/reviews_widget_iframe?did=DEVELOPER_ID&format=html&header_text=Goodreads+reviews&isbn=$isbn&links=660&min_rating=&num_reviews=3&review_back=ffffff&stars=000000&stylesheet=&text=444' width='375' height='400' frameborder='0'></iframe></div>";
}
    
echo '</div>';
}
genesis();