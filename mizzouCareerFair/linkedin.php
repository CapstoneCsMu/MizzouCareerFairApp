<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/MemberProfile" data-id="http://www.linkedin.com/in/reidhoffman" data-format="inline" data-related="false"></script>
<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/ryan-pliske/94/6b9/341" data-format="inline" data-related="false"></script>

<?php
/* File: linkedin2.php
/* DO NOT DELETE
/* Knowledge needed: 
/* Open Authentication version 2.0 (OAuth 2): 
/* This file will be used once we get a working version of OAuth 2 on our server.
*/
if (isset($_GET["error"]))
{
    echo("<pre>OAuth Error: " . $_GET["error"]."\n");
    echo('<a href="index.php">Retry</a></pre>');
    die;
}

require('PHP-OAuth2-master/src/OAuth2/Client.php');
require('PHP-OAuth2-master/src/OAuth2/GrantType/IGrantType.php');
require('PHP-OAuth2-master/src/OAuth2/GrantType/AuthorizationCode.php');

$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
$clientId = '750nr1ytn6d9bz';
$clientSecret = '77nk3oD0VXhEhphp';
$userAgent = 'ChangeMeClient/0.1 by YourUsername';
$redirectURL = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];

$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

if (!isset($_GET["code"]))
{
    $authUrl = $client->getAuthenticationUrl($authorizeUrl, $redirectUrl, array("scope" => "identity", "state" => "SomeUnguessableValue"));
    header("Location: ".$authUrl);
    die("Redirect");
}
?>