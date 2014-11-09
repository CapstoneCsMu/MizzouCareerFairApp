<?php

function oauth_session_exists() {
  if((is_array($_SESSION)) && (array_key_exists('oauth', $_SESSION))) {
    return TRUE;
  } else {
    return FALSE;
  }
}

  // include the LinkedIn class
  include('linkedin/linkedin_3.2.0.class.php');
  
  // start the session
  if(!session_start()) {
    throw new LinkedInException('This script requires session support, which appears to be disabled according to session_start().');
  }
  
  // display constants
  $API_CONFIG = array(
    'appKey'       => '75a6k7ahbjlrny',
	  'appSecret'    => 'PlIszxO8R5FeiFaz',
	  'callbackUrl'  => NULL 
  );
  define('DEMO_GROUP', '4010474');
  define('DEMO_GROUP_NAME', 'Simple LI Demo');
  define('PORT_HTTP', '80');
  define('PORT_HTTP_SSL', '443');

  // set index
  $_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';
  // Check to see if User wants to Link his LinkedIn Account
  switch($_REQUEST[LINKEDIN::_GET_TYPE]) {
    case 'initiate':
		  /**
		   * Handle user initiated LinkedIn connection, create the LinkedIn object.
		   */
			
		  // check for the correct http protocol (i.e. is this script being served via http or https)
		  if($_SERVER['HTTPS'] == 'on') {
			$protocol = 'https';
		  } else {
			$protocol = 'http';
		  }
		  
		  // set the callback url
		  $API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
		  $OBJ_linkedin = new LinkedIn($API_CONFIG);
		  
		  // check for response from LinkedIn
		  $_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
		  if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
			// LinkedIn hasn't sent us a response, the user is initiating the connection
			
			// send a request for a LinkedIn access token
			$response = $OBJ_linkedin->retrieveTokenRequest();
			// echo $response['success'];
			// var_dump($response['linkedin']);
			
			
			if($response['success'] === TRUE) {
			  // store the request token
			  $_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
			  
			  // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
			  header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
			} else {
			  // bad token request
			  echo "Request token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
			}
		  } else {
			// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
			$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
			if($response['success'] === TRUE) {
			  // the request went through without an error, gather user's 'access' tokens
			  $_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];
			  
			  // set the user as authorized for future quick reference
			  $_SESSION['oauth']['linkedin']['authorized'] = TRUE;
				
			  // redirect the user back to the demo page
			  header('Location: ' . $_SERVER['PHP_SELF']);
			} else {
			  // bad token access
			  echo "Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
			}
		  }
		  
		  break;
	default:
		break;
	}
	
  $_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
  if($_SESSION['oauth']['linkedin']['authorized'] === TRUE)
	{
		$OBJ_linkedin = new LinkedIn($API_CONFIG);
		$OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
		$OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
		$response = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,headline,location:(name),phone-numbers,public-profile-url)');
		if($response['success'] === TRUE) {
		  $response['linkedin'] = new SimpleXMLElement($response['linkedin']);
		  $firstname = $response['linkedin']->{'first-name'};
		  $lastname = $response['linkedin']->{'last-name'};
		  $pictureURL = $response['linkedin']->{'picture-url'};
		  $linkedin_ID = $response['linkedin']->id;
		  $headline = $response['linkedin']->headline;
		  $location = $response['linkedin']->location->name;
		  $phone = $response['linkedin']->{'phone-numbers'}->{'phone-number'}->{'phone-number'};
		  $profileURL = $response['linkedin']->{'public-profile-url'};
		  
		  // echo "</br><pre>" . print_r($response['linkedin'], TRUE) . "</pre>";
		} else {
		  // request failed
		  echo "Error retrieving profile information:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response) . "</pre>";
		} 
	}
?>
   