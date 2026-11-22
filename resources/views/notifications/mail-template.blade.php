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
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header img {
            width: 32px;
            height: 32px;
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
        .cta-button {
            display: inline-block;
            margin: 24px 0;
            padding: 12px 24px;
            background-color: #f5a623;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            border: 3px solid #000;
            border-radius: 6px;
            font-size: 16px;
        }
        .cta-button:hover {
            background-color: #e09615;
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
            <img src="{{ config('app.url') }}/favicons/favicon-96x96.png" alt="Logo">
            <h1>{{ config('app.front_name', 'Le Retzien Libre') }}</h1>
        </div>
        <div class="content">
            {!! $body !!}
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.front_name', 'Le Retzien Libre') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>
