<?php
require '../common/db.php';
require '../common/session.php';
require '../config/config.php';
require '../vendor/autoload.php';

use GuzzleHttp\Client;

$redirectUri = 'http://localhost/mrsypz/api/callback.php';

if (!isset($_GET['code'])) {
    die('No code returned');
}

$client = new Client();
$response = $client->post('https://discord.com/api/oauth2/token', [
    'form_params' => [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'grant_type' => 'authorization_code',
        'code' => $_GET['code'],
        'redirect_uri' => $redirectUri,
        'scope' => 'identify email',
    ],
]);

$accessTokenData = json_decode($response->getBody(), true);
$accessToken = $accessTokenData['access_token'];

$response = $client->get('https://discord.com/api/users/@me', [
    'headers' => [
        'Authorization' => "Bearer $accessToken",
    ],
]);

$userData = json_decode($response->getBody(), true);

$query = "SELECT * FROM users WHERE discord_id = '" . mysqli_real_escape_string($conn, $userData['id']) . "'";
$result = mysqli_query($conn, $query);
$existingUser = mysqli_fetch_assoc($result);

if (!$existingUser) {
    $query = "INSERT INTO users (discord_id, username, email) VALUES ('" .
        mysqli_real_escape_string($conn, $userData['id']) . "', '" .
        mysqli_real_escape_string($conn, $userData['username']) . "', '" .
        (isset($userData['email']) ? mysqli_real_escape_string($conn, $userData['email']) : 'NULL') . "')";

    if (mysqli_query($conn, $query)) {
        echo "User registered successfully!";
        setUserSession($userData['id'], $userData['username']);
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    setUserSession($existingUser['discord_id'], $existingUser['username']);
    echo "Welcome back, " . htmlspecialchars($existingUser['username']);
    exit();
}

mysqli_close($conn);