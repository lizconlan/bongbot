<?php

// Get the time, set the timezone
$time = new DateTime("now");
$london = timezone_open("Europe/London");
date_timezone_set($time, $london);

// am/pm flag
$is_pm = false;

// Get the last tweet time, split it into Hour Minute Second [space] Day Month Year
$last_tweet = explode(".", file_get_contents("last_update"));

// Construct string for current datetime
$current_tweet = $time->format("H") . "." . $time->format("i") . ". ." . $time->format("d") . "." . $time->format("m") . "." . $time->format("Y");

// Adjust to 12 hour clock
$hour = (int)$time->format("H");
if ($hour >= 12) {
  $is_pm = true;
}

if ($hour > 12) {
  $hour -= 12;
}

// Tweet if it's the top of the hour (and it's not the hour we were just in, that would be weird)
if ($time->format("i") == "00" && $time->format("H") != $last_tweet[0]) {
  // Read in our saved access token/secret
  $accessToken = file_get_contents("access_token");
  $accessTokenSecret = file_get_contents("access_token_secret");

  // Create our twitter API object
  require_once("twitteroauth/twitteroauth/twitteroauth.php");
  $oauth = new TwitterOAuth('YOUR_TWITTER_CONSUMER_KEY','YOUR_TWITTER_CONSUMER_SECRET', $accessToken, $accessTokenSecret);
  
  $message = rtrim(str_repeat("Bong! ", $hour));
  echo $message;
  $oauth->post('statuses/update', array('status' => $message));
  file_put_contents("last_update", $current_tweet);
}

?>