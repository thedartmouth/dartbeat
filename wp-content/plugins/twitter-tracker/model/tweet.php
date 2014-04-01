<?php


// N.B. This class is extended by ApiTweet class (need to create an abstract base class for both tweet types,
// they mostly differ in the way they are constructed).
class Tweet
{
	public $content;
	public $link;
	public $timestamp;
	public $date;
	public $twit;
	public $twit_name;
	public $twit_link;
	public $twit_pic;
	public $twit_uid;
	
	public function __construct( $content, $link, $timestamp, $twit, $twit_link, $twit_pic ) {
		$this->content = $content;
		$this->link = $link;
		$this->timestamp = $timestamp;
		$this->date = $date;
		$this->set_tweet_date();
		$this->twit = $twit;
		$this->twit_link = $twit_link;
		$this->set_twit_uid();
		$this->set_twit_name();
		$this->twit_pic_bigger = "http://api.twitter.com/1/users/profile_image/{$this->twit_uid}?size=bigger";
		$this->twit_pic = "http://api.twitter.com/1/users/profile_image/{$this->twit_uid}";
	}
	
	/**
	 * Ripped off from the bb_since bbPress function
	 */
	public function time_since( $do_more = 0 ) {
		$today = time();

		// array of time period chunks
		$chunks = array(
			( 60 * 60 * 24 * 365 ), // years
			( 60 * 60 * 24 * 30 ),  // months
			( 60 * 60 * 24 * 7 ),   // weeks
			( 60 * 60 * 24 ),       // days
			( 60 * 60 ),            // hours
			( 60 ),                 // minutes
			( 1 )                   // seconds
		);

		$since = $today - $this->timestamp;

		for ($i = 0, $j = count($chunks); $i < $j; $i++) {
			$seconds = $chunks[$i];

			if ( 0 != $count = floor($since / $seconds) )
				break;
		}

		$trans = array(
			$this->pluralise( '%d year', '%d years', $count ),
			$this->pluralise( '%d month', '%d months', $count ),
			$this->pluralise( '%d week', '%d weeks', $count ),
			$this->pluralise( '%d day', '%d days', $count ),
			$this->pluralise( '%d hour', '%d hours', $count ),
			$this->pluralise( '%d minute', '%d minutes', $count ),
			$this->pluralise( '%d second', '%d seconds', $count )
		);

		$basic = sprintf( $trans[$i], $count );

		if ( $do_more && $i + 1 < $j) {
			$seconds2 = $chunks[$i + 1];
			if ( 0 != $count2 = floor( ($since - $seconds * $count) / $seconds2) ) {
				$trans = array(
					$this->pluralise( 'a year', '%d years', $count2 ),
					$this->pluralise( 'a month', '%d months', $count2 ),
					$this->pluralise( 'a week', '%d weeks', $count2 ),
					$this->pluralise( 'a day', '%d days', $count2 ),
					$this->pluralise( 'an hour', '%d hours', $count2 ),
					$this->pluralise( 'a minute', '%d minutes', $count2 ),
					$this->pluralise( 'a second', '%d seconds', $count2 )
				);
				$additional = sprintf( $trans[$i + 1], $count2 );
			}
			
			$final = sprintf( __( 'about %s, %s ago' ), $basic, $additional );
			return $final;
		}
		$final = sprintf( __( 'about %s ago' ), $basic );
		return $final;
	}
	
	protected function set_twit_uid() {
		$twit_uid = str_replace( 'http://twitter.com/', '', $this->twit_link );
		$this->twit_uid = $twit_uid;
	}
	
	// Expects something of the form "username (Real Name)"
	protected function set_twit_name()
	{
		// We now go to a lot of trouble, basically because I don't know regexes.
		// Lop off the username component
		$bits = explode( '(', $this->twit );
		array_shift( $bits );
		// Join back together with a '(' as glue, in case there were any of 
		// those in the "real name".
		$string = implode( '(', $bits );
		// Lop off the last character, which is a ")"
		$this->twit_name = substr( $string, 0, -1 );
	}
	
	// e.g. Jul 30, 2009 @ 10:01
	protected function set_tweet_date() {
		$this->date = date( 'M n, Y  @ G:i', $this->timestamp );
	}
	
	protected function pluralise( $singular, $plural, $count ) {
		if ( $count == 0 || $count > 1 ) return $plural;
		return $singular;
	}

}


?>