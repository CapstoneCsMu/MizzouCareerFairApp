<?php 

/* 
 * This authenticates papwrints (sso) to the Mizzou LDAP servers and returns 
 * null if the authentication credentials are invalid, and a user object with
 * emails and user info if the credentials were valid.
 * 
 * Adapted from um_ldap and muauth by Mathew Dickinson, Grant Scott, et. al
 *
 * Tested on babbage and other internal locations. Subject to headaches from
 * network and domain if used  elsewhere.
 *
 * Refactored by Ben Baker 2014
 */




/** 
 * Test with valid and invalid credentials in a safe location.
 * @return Authentication response.
 */

function test(){
  // Test with a real one -- it should work.
  var_dump( authenticateToUMLDAP("PAWPRINT", "PASSWORD") );
  // $test_silent = @authenticateToUMLDAP("", "");
}

/**
 * Validate emails
 * @param  Object $query_result
 * @return Array  Valid Emails
 */

function get_email($query_result) {
    $possible_emails = array();
    $valid_emails = array();
  { $valid_emails[] = $query_result[0]["mail"][0]; }
    {{{ $email = strtolower($val);
      { $possible_emails[] = substr($email, 5); } 
      { $possible_emails[] = $email;}
    }}}
   {{ $valid_emails[] = $val; }}
    return $valid_emails;
}

/**
 * Validates email
 * @param  string  $email 
 * @return boolean valid
 */

function is_valid_email($email) {

    // eregi() is depricated after PHP 5.1
    // using filter instead.
    // Ben Baker

    return (!filter_var(trim($email), FILTER_VALIDATE_EMAIL));
}

/**
 * Processes authentication against the UM LDAP system
 * @param  string  $accountName   Pawprint or SSO
 * @param  string  $credential    Password
 * @param  string  $ldapServer    address of LDAP server
 * @param  integer $ldapPort      Port on which to send request
 * @param  string  $errorMsg      error message
 * @param  boolean $requireSecure Security specification
 * @return Array   $account       Information about the account or a boolean false.
 * @return Bool    false          Authentication didn't work.
 */

function authenticateToUMLDAP($accountName,$credential,$ldapServer = 'ldap.missouri.edu', $ldapPort = 3268, &$errorMsg = "", $requireSecure = true){
    $error           = array();
    $query_result    = array();
    $attributes      = array("samaccountname", "proxyAddresses", "mail", "displayName");
    $formatted_result = array();

    // Connects
    $connection = ldap_connect($ldapServer, $ldapPort);

    // Checks connection
    if (! $connection ) {
      $errorMsg = "Failed to connect to $ldapServer:$ldapPort";
      return false;
    }

    // Checks protocol version
    if ( ! ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3) ){
      $errorMsg = "Failed to Set Protocol version 3";
      return false;
    }

    // Configure opt referrals
    if ( ! ldap_set_option($connection, LDAP_OPT_REFERRALS, 0) ) {
      $errorMsg = "Failed to connect disable referrals from server";
      return false;
    }

    // Checks TLS connection
    if ( ! ldap_start_tls($connection) && $requireSecure) {
      $errorMsg = "Unable to get a TLS connection, are you using the correct port?";
      return false;
    }

    // Exhausts all the possible ldap connections
    $valid_domains = array("tig.mizzou.edu", "cs.missouri.edu", "umsystem.umsystem.edu");    
    foreach ($valid_domains as $domain){
        if ($bind_status = ldap_bind($connection,$accountName."@".$domain,$credential))
            break;
    }

    // A break above leaves $bind_status = true;
    if ($bind_status) { 
        $ldapresults = ldap_search($connection, 'dc=edu', "(samaccountname=$accountName)", $attributes);
        if (!$ldapresults) {
          $errorMsg = "Failed to look up after bind";
          return false;
        } else {
          $result_count = ldap_count_entries($connection, $ldapresults);
          $query_result = ldap_get_entries($connection, $ldapresults);
          ldap_close($connection);
        }
    } else {
      // LDAP bind failed
      ldap_close($connection);
      $errorMsg = "Failed to bind to ($connection) as: $username";
      return false;
    }
    if ($result_count == 0) {
        $formatted_result['result'] = '0';
        $formatted_result['message'] = 'Invalid Username or Password';
    } else {
        $formatted_result['result'] = $result_count;
        $formatted_result['user']['fullname'] = $query_result[0]["displayname"][0];
        $formatted_result['user']['username'] = $query_result[0]["samaccountname"][0];
        $formatted_result['user']['emails']   = get_email($query_result);
    }
    return $formatted_result;
}

?>
