<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG LOGIN ===\n";

// 1. Check if admin user exists
echo "\n1. Vérification utilisateur admin...\n";
$adminUser = \App\Models\User::where('email', 'constant.houeha@gmail.com')->first();

if ($adminUser) {
    echo "✅ Utilisateur admin trouvé:\n";
    echo "   ID: " . $adminUser->id . "\n";
    echo "   Email: " . $adminUser->email . "\n";
    echo "   Role: " . $adminUser->role . "\n";
    echo "   Is Active: " . ($adminUser->is_active ? 'Yes' : 'No') . "\n";
    echo "   Email Verified: " . ($adminUser->email_verified_at ? 'Yes' : 'No') . "\n";
    
    // Test password verification
    echo "\n2. Test mot de passe...\n";
    $testPassword = 'password@123';
    if (\Illuminate\Support\Facades\Hash::check($testPassword, $adminUser->password)) {
        echo "✅ Mot de passe correct\n";
    } else {
        echo "❌ Mot de passe incorrect\n";
        echo "   Test password: " . $testPassword . "\n";
        echo "   Hashed password: " . $adminUser->password . "\n";
    }
} else {
    echo "❌ Utilisateur admin non trouvé!\n";
    
    // Create admin user
    echo "\n3. Création utilisateur admin...\n";
    $adminUser = \App\Models\User::updateOrCreate(
        ['email' => 'constant.houeha@gmail.com'],
        [
            'name' => 'Constant Houeha',
            'password' => \Illuminate\Support\Facades\Hash::make('password@123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]
    );
    
    echo "✅ Utilisateur admin créé:\n";
    echo "   ID: " . $adminUser->id . "\n";
    echo "   Email: " . $adminUser->email . "\n";
    echo "   Role: " . $adminUser->role . "\n";
}

// 4. Test API login endpoint
echo "\n4. Test API login endpoint...\n";
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'constant.houeha@gmail.com',
        'password' => 'password@123'
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "❌ Erreur cURL: " . $err . "\n";
} else {
    echo "✅ Réponse API (HTTP $httpCode):\n";
    echo $response . "\n";
    
    $responseData = json_decode($response, true);
    if (isset($responseData['token'])) {
        echo "✅ Token reçu: " . substr($responseData['token'], 0, 50) . "...\n";
    }
}

echo "\n=== DEBUG TERMINÉ ===\n";
