<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #1b1b18;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border: 3px solid #000;
            border-radius: 12px;
            overflow: hidden;
        }
        .header {
            background-color: #f5a623;
            padding: 24px 32px;
            border-bottom: 3px solid #000;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #000;
        }
        .content {
            padding: 32px;
            font-size: 15px;
            line-height: 1.7;
            color: #1b1b18;
        }
        .content p {
            margin: 0 0 16px;
        }
        .content a {
            color: #00473e;
            font-weight: bold;
        }
        .footer {
            padding: 16px 32px;
            background-color: #f9f9f9;
            border-top: 2px solid #e0e0e0;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            {!! $body !!}
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>
