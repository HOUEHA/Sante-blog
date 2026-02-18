<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST SIMPLE USER CREATION ===\n";

try {
    // Test direct user creation
    echo "\n1. Test création utilisateur direct...\n";
    
    $user = new \App\Models\User();
    $user->name = 'Test Direct User';
    $user->email = 'directtest' . time() . '@example.com';
    $user->password = \Illuminate\Support\Facades\Hash::make('password123');
    $user->role = 'user';
    $user->is_active = true;
    $user->email_verified_at = now();
    
    $user->save();
    
    echo "✅ Utilisateur créé avec ID: " . $user->id . "\n";
    echo "   Email: " . $user->email . "\n";
    echo "   Role: " . $user->role . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur création directe: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

try {
    // Test UserController store method directly
    echo "\n2. Test UserController::store() direct...\n";
    
    $controller = new \App\Http\Controllers\Api\UserController();
    $request = new \Illuminate\Http\Request([
        'name' => 'Test Controller User',
        'email' => 'controllertest' . time() . '@example.com',
        'password' => 'password123',
        'role' => 'user',
        'is_active' => true
    ]);
    
    $response = $controller->store($request);
    
    echo "✅ Réponse du controller: " . $response->getStatusCode() . "\n";
    echo "   Content: " . $response->getContent() . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur controller: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TEST TERMINÉ ===\n";
