<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Newsletter Data ===\n";

// Sample newsletter subscribers
$newsletterSubscribers = [
    [
        'email' => 'newsletter@health-fan.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(30),
    ],
    [
        'email' => 'sophie.wellness@example.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(25),
    ],
    [
        'email' => 'dr.martin@cardio-center.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(20),
    ],
    [
        'email' => 'yoga.lover@example.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(15),
    ],
    [
        'email' => 'nutrition.expert@example.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(10),
    ],
    [
        'email' => 'mindfulness.guru@example.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(5),
    ],
    [
        'email' => 'fitness.coach@example.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(3),
    ],
    [
        'email' => 'natural.health@example.com',
        'subscribed_at' => \Carbon\Carbon::now()->subDays(1),
    ],
];

// Clear existing newsletters
echo "Clearing existing newsletter data...\n";
\App\Models\Newsletter::truncate();

// Create newsletter subscribers
echo "Creating newsletter subscribers...\n";
foreach ($newsletterSubscribers as $subscriberData) {
    $subscriber = \App\Models\Newsletter::create($subscriberData);
    echo "✓ Created: " . $subscriber->email . " (ID: " . $subscriber->id . ")\n";
}

echo "\n=== Newsletter Data Created ===\n";
$totalSubscribers = \App\Models\Newsletter::count();
echo "Total newsletter subscribers: " . $totalSubscribers . "\n";

echo "\n=== Subscriber List ===\n";
$subscribers = \App\Models\Newsletter::orderBy('subscribed_at', 'desc')->get();
foreach ($subscribers as $subscriber) {
    echo "- " . $subscriber->email . " (subscribed: " . $subscriber->subscribed_at->format('d/m/Y') . ")\n";
}

echo "\n=== Complete ===\n";
