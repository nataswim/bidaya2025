<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $notebook->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        h1 {
            color: {{ $notebook->color }};
            border-bottom: 3px solid {{ $notebook->color }};
            padding-bottom: 10px;
        }
        .item {
            margin-bottom: 20px;
            padding: 15px;
            border-left: 3px solid {{ $notebook->color }};
            background: #f9f9f9;
        }
        .item-title {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 5px;
        }
        .item-note {
            font-style: italic;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>{{ $notebook->title }}</h1>
    
    @if($notebook->description)
        <p><strong>Description :</strong> {{ $notebook->description }}</p>
    @endif
    
    <p><strong>Type de contenu :</strong> {{ $notebook->content_type_label }}</p>
    <p><strong>Nombre d'éléments :</strong> {{ $notebook->items->count() }}</p>
    <p><strong>Date d'export :</strong> {{ now()->format('d/m/Y H:i') }}</p>
    
    <hr>
    
    @foreach($notebook->items as $item)
        <div class="item">
            <div class="item-title">{{ $loop->iteration }}. {{ $item->content_title }}</div>
            
            @if($item->personal_note)
                <div class="item-note">
                    Note : {{ $item->personal_note }}
                </div>
            @endif
        </div>
    @endforeach
</body>
</html>