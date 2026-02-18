<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel article: {{ $article->title }}</title>
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
        .article-preview {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .category-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 10px;
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
        <p>Nouvel article disponible!</p>
    </div>
    
    <div class="content">
        <h2>📰 Nouveau article publié</h2>
        
        <p>Nous sommes ravis de vous informer qu'un nouvel article vient d'être publié sur notre site.</p>
        
        <div class="article-preview">
            @if($article->category)
                <span class="category-badge">{{ $article->category->name }}</span>
            @endif
            
            <h3>{{ $article->title }}</h3>
            
            <p><strong>Extrait :</strong> {{ Str::limit(strip_tags($article->excerpt), 150) }}</p>
            
            <p><strong>Temps de lecture :</strong> {{ $article->read_time }} minutes</p>
            
            @if($article->featured_image_url)
                <div style="text-align: center; margin: 15px 0;">
                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" style="max-width: 100%; height: auto; border-radius: 8px;">
                </div>
            @endif
        </div>
        
        <p>Cet article pourrait vous intéresser et vous apporter des informations précieuses pour votre santé et votre bien-être.</p>
        
        <a href="{{ $articleUrl }}" class="btn">Lire l'article complet</a>
        
        <p><small>Publié le {{ $article->published_date->format('d/m/Y') }}</small></p>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé car vous êtes abonné à la newsletter de Ma Santé, Ma responsabilité.</p>
        <p>Pour vous désabonner, cliquez sur le lien ci-dessous.</p>
        <p>&copy; {{ date('Y') }} Ma Santé, Ma responsabilité. Tous droits réservés.</p>
    </div>
</body>
</html>
