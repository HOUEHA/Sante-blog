<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing Newsletter Subscription with New Email ===\n";

// Test newsletter subscription with new email
$newsletterData = [
    'email' => 'newuser' . time() . '@example.com'
];

echo "Testing newsletter subscription with:\n";
echo "- Email: " . $newsletterData['email'] . "\n\n";

$request = Request::create('/api/newsletter/subscribe', 'POST', [], [], [], [], json_encode($newsletterData));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\NewsletterController();
    $response = $controller->subscribe($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    $responseData = $response->getData(true);
    
    if ($response->getStatusCode() === 201) {
        echo "SUCCESS: Newsletter subscription successful!\n";
        echo "Message: " . $responseData['message'] . "\n";
        echo "Newsletter ID: " . $responseData['newsletter']['id'] . "\n";
        echo "Email: " . $responseData['newsletter']['email'] . "\n";
        echo "Active: " . ($responseData['newsletter']['is_active'] ? 'YES' : 'NO') . "\n";
        echo "Subscribed At: " . ($responseData['newsletter']['subscribed_at'] ?? 'N/A') . "\n";
    } else {
        echo "FAILED: Newsletter subscription failed\n";
        echo "Response: " . json_encode($responseData) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Checking Newsletter Database ===\n";
$newsletters = \App\Models\Newsletter::all();
echo "Total newsletters: " . $newsletters->count() . "\n";

echo "\n=== Test Complete ===\n";
