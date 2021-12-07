<?php

if (!session_id()) {
    // No session is currently in progress, so start one.
    session_start();
}

require 'sanitize.php';

//
// Check for user authentication
//
// If user is not authenticated, redirect them to our login page.
//
if (!isset($_SESSION['authenticated'])) {

    $scriptName = sanitizeString(INPUT_SERVER, 'SCRIPT_NAME');

    // redirect to login.php
    header("Location: http://localhost:9090/login.php?url=" . urlencode($scriptName));

}