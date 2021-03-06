<?php
/* File: linkedin2.php
/* Parent: doesn't have one yet.
/* DO NOT DELETE
/* Knowledge needed: 
/* Open Authentication version 2.0 (OAuth 2): 
/* and LinkedIn's documentation: https://developer.linkedin.com/documents/authentication
/*
/* This file allows us to ask the users if he/she wishes to give us his/her linkedIn information to us.
/* We start by sending the user to LinkedIn's Authentication Server.
/* We then receive an authentication token back from LinkedIn. If it's successful then we can make requests to LinkedIn's Resource Server (and grab their info)
*/

if($_SERVER['HTTP_HOST'] == 'localhost'):
	define('API_KEY',      '750nr1ytn6d9bz');
	define('API_SECRET',   '77nk3oD0VXhEhphp');
	define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
else:
	define('API_KEY',      '75a6k7ahbjlrny');
	define('API_SECRET',   'PlIszxO8R5FeiFaz');
	define('REDIRECT_URI', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
endif;

define('SCOPE',        'r_basicprofile r_emailaddress');
 
// We may store the tokens in a database (it'll be safer)
// But for now i'm  using a session variable
session_name('linkedin');
session_start();
 
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
// Congratulations! You have a valid token. Now fetch your profile ...(firstName and lastName) is field selector notation
// https://developer.linkedin.com/documents/profile-api#
$user = fetch('GET', '/v1/people/~');
// $user = fetch('GET', '/v1/people/~ HTTP/1.1');

print "</br>Hello".$user->firstName.$user->lastName."!";
exit;
 
function getAuthorizationCode() {
    $params = array(
        'response_type' => 'code',
        'client_id' => API_KEY,
        'scope' => SCOPE,
        'state' => uniqid('', true), // unique long string
        'redirect_uri' => REDIRECT_URI,
    );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array(
        'grant_type' => 'authorization_code',
        'client_id' => API_KEY,
        'client_secret' => API_SECRET,
        'code' => $_GET['code'],
        'redirect_uri' => REDIRECT_URI,
    );
     
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
     
    // Tell streams to make a POST request
    $context = stream_context_create(
        array('http' => 
            array('method' => 'POST',
            )
        )
    );
 
    // Retrieve access token information
    $response = file_get_contents($url, false, $context);
	var_dump($response);
 
    // Native PHP object, please
    $token = json_decode($response);
 
    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
     
    return true;
}
 
function fetch($method, $resource, $body = '') {
    print $_SESSION['access_token'];
 
	// these are headers that are required by LinkedIn
	// ref: https://developer.linkedin.com/documents/authentication (check out Step 4)
    $headers = array(
		// 'Host' => 'api.linkedin.com',
		// 'Content-type' => 'application/x-www-form-urlencoded\r\n',
		'Connection' => 'Keep-Alive',
        'Authorization' => 'Bearer ' . $_SESSION['access_token'],
        'x-li-format' => 'json' // Comment out to use XML
    );
	//var_dump($headers);
 
    $params = array(
		// 'param1' => 'Ryan',
		// 'param2' => 'Pliske'
    );
	 
    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource;
 
    // Append query parameters (if there are any)
    if (isset($params)) 
	{ 
		$url .= '?' . http_build_query($params); 
	} 
 

	// Creat context using stream
    // http://php.net/manual/en/function.stream-context-create.php
    $context = stream_context_create(
        array('http' => 
            array('method' => $method,
                  'header' => $headers
            )
        )
    );
	echo "</br>";
	var_dump($context);
 
    // Send the request to LinkedIn's resource using the HTTP headers set above
	
	// cURL example is used for testing purposes
	$url = "http://api.linkedin.com/v1/people/~?oauth_consumer_key=75a6k7ahbjlrny&oauth_nonce=1234&oauth_signature=66CayRWJINr4y3isA5IHuayjklY%3D&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1412976594&oauth_token=414459df-3979-44ca-91e6-6e906d46559c&oauth_version=2";
	echo "</br>".$url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $response = curl_exec($ch);
    curl_close($ch);
   
	// using file_get_contents
	// $response = file_get_contents($url, false, $context);
	echo "</br>";
	var_dump($response);
 
    // Native PHP object, please
    return json_decode($response);
}
?>