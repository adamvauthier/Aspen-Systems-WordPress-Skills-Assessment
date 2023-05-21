<?php

/**
 * The file that defines the shortcode class
 *
 *
 * @link       https://www.aspsys.com/
 * @since      1.0.0
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 */

class Jh_Nyt_Top_Stories_Shortcode {

    static function display_stories()  {
		
		$stories_query = new WP_Query( array( 'post_type' => 'nyt_story', 'posts_per_page' => '5' ) );
		
		ob_start(); 
		
		$output =  '<ul>';
		
		while ( $stories_query->have_posts() ) {
			$stories_query->the_post();
			$output .= '<li>';
			$story_link = get_post_meta(get_the_ID(), 'URL', true);
			$story_byline = get_post_meta(get_the_ID(), 'byline', true);
			$output .= '<a href="'.$story_link.'" class="storyTitle">'.get_the_title().'</a>';
			$output .= '<div class="byline">'.$story_byline.'</div>';
			$output .= "</li>";
		}
        
		$output .= "</ul>";
		
		return $output;

    }

}