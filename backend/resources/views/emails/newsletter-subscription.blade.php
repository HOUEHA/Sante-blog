<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur Ma Santé, Ma responsabilité</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .btn {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌿 Ma Santé, Ma responsabilité</h1>
        <p>Votre guide vers une vie plus saine</p>
    </div>
    
    <div class="content">
        <h2>Bienvenue et merci pour votre confiance!</h2>
        
        <p>Merci de vous être abonné à notre newsletter. Vous faites maintenant partie de notre communauté engagée pour une meilleure santé et un meilleur bien-être.</p>
        
        <p>À travers notre newsletter, vous recevrez :</p>
        
        <ul>
            <li>📝 Nos derniers articles sur la santé et le bien-être</li>
            <li>🥗 Des conseils nutritionnels pratiques</li>
            <li>🏃‍♂️ Des astuces pour une activité physique régulière</li>
            <li>🧘 Des techniques de gestion du stress</li>
            <li>💊 Des informations sur la prévention santé</li>
        </ul>
        
        <p>Nous sommes ravis de vous accompagner dans votre parcours vers une vie plus saine et équilibrée.</p>
        
        <a href="{{ url('/') }}" class="btn">Visiter notre site</a>
        
        <p><small>Date d'inscription : {{ $subscribedAt ? $subscribedAt->format('d/m/Y à H:i') : 'N/A' }}</small></p>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé à {{ $email }} car vous vous êtes abonné à la newsletter de Ma Santé, Ma responsabilité.</p>
        <p>Si vous ne souhaitez plus recevoir nos emails, vous pouvez vous désabonner à tout moment.</p>
        <p>&copy; {{ date('Y') }} Ma Santé, Ma responsabilité. Tous droits réservés.</p>
    </div>
</body>
</html>
