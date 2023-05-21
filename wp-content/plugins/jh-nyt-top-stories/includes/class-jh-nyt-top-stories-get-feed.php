<?php
require_once( $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-load.php' );
if ( ! function_exists( 'post_exists' ) ) {
    require_once( $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-admin/includes/post.php' );
}
/**
 * The file that defines feed import class
 *
 *
 * @link       https://www.aspsys.com/
 * @since      1.0.0
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 */

class Jh_Nyt_Top_Stories_Data_Parser {
	
	private $feed_data;
	
	public function get_nyt_feed(){
		$this->pull_nyt_feed();
		$this->import_new_stories();
	}
	
	/**
	 * Collect the external data from the New York Times
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pull_nyt_feed() {
		$this->feed_data = file_get_contents('https://api.nytimes.com/svc/topstories/v2/home.json?api-key=q0fSRDhVac2xGisx0VbprTOKZJoYMVrJ');
		$this->feed_data = json_decode($this->feed_data, true);
		//print_r($this->feed_data);
	}
	
	/**
	 * Collect the external data from the New York Times
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function import_new_stories() {
		$results = $this->feed_data['results'];
		foreach ($results as $article){			
			if( !post_exists( wp_strip_all_tags( $article['title'] ) )):
			
				// Create post object
				$my_post = array(
					  'post_type'	  => 'nyt_story',
					  'post_title'    => wp_strip_all_tags( $article['title'] ),
					  'post_excerpt'  => $article['abstract'],
					  'post_date'	  => $article['published_date'],
					  'meta_input'	  => array( 'URL' => $article['url'], 'byline' => $article['byline'] ),
					  'tax_input'	  => $custom_tax,
					  'post_status'   => 'publish',
					  'post_content'  => 'Article',
				);
				$new_id = wp_insert_post( $my_post, true );
				wp_set_object_terms( $new_id, ucfirst($article['section']), 'nyt_category');
				wp_set_object_terms( $new_id, $article['des_facet'], 'nyt_tag');
			endif;	   
		}
	}
	
}