<?php
require __DIR__ . '/vendor/autoload.php'; // Google API Client

// ===== CORS Setup =====
$allowed_origins = [
    'http://localhost:3000',            // Local dev
    'https://www.okafricatours.com'     // Production
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
}
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

// ===== Handle preflight OPTIONS =====
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// ===== Get token from frontend =====
$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'] ?? '';

if (!$token) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No token provided'
    ]);
    exit;
}

// ===== Initialize Google Client =====
$client = new Google_Client(['client_id' => '233039971302-2jl3cimu8nkugilsq736kq1dd0up7as3.apps.googleusercontent.com']);

// ===== Verify token =====
try {
    $payload = $client->verifyIdToken($token);

    if ($payload) {
        $email = $payload['email'] ?? '';
        $name  = $payload['name'] ?? '';
        $sub   = $payload['sub'] ?? ''; // Unique Google user ID

        // TODO: Database logic (insert/update user)
        // Example:
        // saveUserToDatabase($sub, $email, $name);

        echo json_encode([
            'status' => 'success',
            'user' => [
                'google_id' => $sub,
                'email'     => $email,
                'name'      => $name
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid or expired token'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Token verification failed: ' . $e->getMessage()
    ]);
}
exit;
