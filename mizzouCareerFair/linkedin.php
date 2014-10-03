<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/MemberProfile" data-id="http://www.linkedin.com/in/reidhoffman" data-format="inline" data-related="false"></script>
<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/ryan-pliske/94/6b9/341" data-format="inline" data-related="false"></script>

<?php

include('OAuth.php');
define("CONSUMER_KEY", "your consumer key you got in step 3 above");
define("CONSUMER_SECRET", "your secret you got in step 3 above");
 
$oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);

?>