<?php
// this is just my implentation of 
// http://kovshenin.com/archives/twitter-api-pin-based-oauth-php/
// well worth a read if you're setting up your own Twitter bot

require_once('twitteroauth/twitteroauth/twitteroauth.php');
$oauth = new TwitterOAuth('YOUR_TWITTER_CONSUMER_KEY','YOUR_TWITTER_CONSUMER_SECRET');

$request = $oauth->getRequestToken();
$requestToken = $request['oauth_token'];
$requestTokenSecret = $request['oauth_token_secret'];

// place the generated request token/secret into local files
file_put_contents('request_token', $requestToken);
file_put_contents('request_token_secret', $requestTokenSecret);

// display Twitter generated registration URL
$registerURL = $oauth->getAuthorizeURL($request);
echo '<a href="' . $registerURL . '">Register with Twitter</a>';

?>