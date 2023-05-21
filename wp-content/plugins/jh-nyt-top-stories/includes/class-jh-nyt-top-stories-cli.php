<?php
class NYT_CLI {

	/**
	 * Returns 'Success Failure of Data Pull from NYT'
	 *
	 * @since  0.0.1
	 * @author Scott Anderson
	 */
	public function pull_feed() {
		$storiesPull = new Jh_Nyt_Top_Stories_Data_Parser();
    	$result = $storiesPull->get_nyt_feed();
     	WP_CLI::line( 'Pulled Successfully' ) ;
	}

}