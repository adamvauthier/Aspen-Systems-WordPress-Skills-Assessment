<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.aspsys.com/
 * @since      1.0.0
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 * @author     Aspen Systems Inc. <webmaster@aspsys.com>
 */
class Jh_Nyt_Top_Stories_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'nytcontent_scheduler_parser' );
	}

}
