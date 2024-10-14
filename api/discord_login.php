<?php
require '../config/config.php'; // Load API credentials
require '../common/session.php';

$authUrl = "https://discord.com/oauth2/authorize?client_id=$clientId&response_type=code&redirect_uri=" . urlencode($redirectUri) . "&scope=identify+email";
header('Location: ' . $authUrl);
exit();
?>
