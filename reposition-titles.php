<?php 

/*
 *
 * Resposition entry title on posts and pages
 * for the Genesis Framework only
 *
 */
 
add_action( 'genesis_before', 'reposition_entry_title' );
function reposition_entry_title() {

	//* Don't reposition on front-page (optional)
	if( !is_front_page() ) {
	
	  	//* Reposition the breadcrumbs
	  	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	  	add_action( 'genesis_after_header', 'genesis_do_breadcrumbs', 17 );
	
	  	//* Remove entry-title and markup from all pages except Blog and Archives
	  	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_filter( 'genesis_entry_header', 'ahjira_subtitle_after_title', 11 );
	
	  	//* Opening HTML
	  	add_action( 'genesis_after_header', 'genesis_do_post_title_open', 15 );
	  	function genesis_do_post_title_open() {
	  	
	  	//* Check for Genesis Subtitles plugin
	    global $post;
	    $subtitle = get_post_meta( $post->ID, '_ahjira_subtitle', TRUE );
	
	    //* Use featured image as page-title backround image (optional)
	    if (has_post_thumbnail( $post->ID ) ) {
	    	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			$style = ' style="background-image: url(' . $image[0] . ');" ';
		}
	
	    //* Add has-subtitle class if page has subtitle
	    if( !empty( $subtitle ) ) {
		  	echo '<div class="page-title has-subtitle"' . $style . '><div class="wrap">'; 
		} else {
	    		echo '<div class="page-title"' . $style . '><div class="wrap">'; 
		}
	
	    //* Add the closing HTML
	    add_action( 'genesis_after_header', 'genesis_do_post_title_close', 18 );
	    function genesis_do_post_title_close() {
			echo '</div></div>';
	  	}
	
	  	//* Display the page and single post titles (not archives)
	  	if ( is_page() || is_single() ) {
			add_action( 'genesis_after_header', 'genesis_do_post_title', 16 );
			add_action( 'genesis_after_header', 'cp_subtitle_after_title', 17 );
	  	}
	 
		//* Display entry-title for each post on archives (since we removed these as well)
		if( is_home() || is_archive() ) {
			add_action( 'genesis_entry_header', 'genesis_do_post_title', 2 );
		}
	
	   	//* 404 page (error message to display)
	   	if( is_404() ) {
	   		add_action( 'genesis_after_header', 'gd_404_title', 16 );
	   		function gd_404_title() {
	    		echo '<h1 class="entry-title" itemprop="headling">Page not found!</h1>';
	   		}
	   	}
	    
		//* Remove titles and descriptions from all archives to reposition
		remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
		remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
		remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	
		//* Add titles and descriptions on all archives in right place
		add_action( 'genesis_after_header', 'genesis_do_cpt_archive_title_description', 16 );
		add_action( 'genesis_after_header', 'genesis_do_posts_page_heading', 16 );
		add_action( 'genesis_after_header', 'genesis_do_date_archive_title', 16 );
		add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 16 );
		add_action( 'genesis_after_header', 'genesis_do_author_title_description', 16 );
		add_action( 'genesis_after_header', 'genesis_do_blog_template_heading', 16 );

	}
}
