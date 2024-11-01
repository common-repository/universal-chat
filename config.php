<?php

// -----
// Important: read the instructions in README.md or at:
// https://github.com/piwik/piwik/tree/master/misc/proxy-hide-piwik-url#piwik-proxy-hide-url
// -----

// Edit the line below, and replace http://your-piwik-domain.example.org/piwik/
// with your Piwik URL ending with a slash.
// This URL will never be revealed to visitors or search engines.
$PIWIK_URL = 'http://localhost:8080/universal/piwik/';

// Edit the line below, and replace xyz by the token_auth for the user "UserTrackingAPI"
// which you created when you followed instructions above.
$TOKEN_AUTH = 'b15dea2825fc2a2d764a6e8949487351';

// Maximum time, in seconds, to wait for the Piwik server to return the 1*1 GIF
$timeout = 30;

// By default, the HTTP User Agent will be set to the user agent of the client requesting piwik.php
// Edit the line below to force the proxy to always use a specific user agent string.
$user_agent = '';
