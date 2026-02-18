<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing Newsletter Subscription ===\n";

// Test newsletter subscription
$newsletterData = [
    'email' => 'test@example.com'
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
    } else {
        echo "FAILED: Newsletter subscription failed\n";
        echo "Response: " . json_encode($responseData) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Testing Duplicate Subscription ===\n";

// Test duplicate subscription
$request2 = Request::create('/api/newsletter/subscribe', 'POST', [], [], [], [], json_encode($newsletterData));
$request2->headers->set('Content-Type', 'application/json');
$request2->headers->set('Accept', 'application/json');

try {
    $controller2 = new \App\Http\Controllers\Api\NewsletterController();
    $response2 = $controller2->subscribe($request2);
    
    echo "Response Status: " . $response2->getStatusCode() . "\n";
    $responseData2 = $response2->getData(true);
    echo "Response: " . json_encode($responseData2) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Checking Newsletter Database ===\n";
$newsletters = \App\Models\Newsletter::all();
echo "Total newsletters: " . $newsletters->count() . "\n";

foreach ($newsletters as $newsletter) {
    echo "- ID: " . $newsletter->id . ", Email: " . $newsletter->email . ", Active: " . ($newsletter->is_active ? 'YES' : 'NO') . ", Subscribed: " . $newsletter->subscribed_at . "\n";
}

echo "\n=== Test Complete ===\n";
