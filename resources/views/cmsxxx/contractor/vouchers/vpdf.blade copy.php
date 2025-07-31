<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code PDF</title>
    <style>
        .qr-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 0 -10px;
            box-sizing: border-box;
            padding: 10px;
            gap: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #333;
            text-align: center;
            align-content: center
        }
        .qr-box {
            width: 25%;
            text-align: center;
            padding: 10px;
            box-sizing: border-box;
        }
        img {
            max-width: 100%;
        }
        body {
            font-family: sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="qr-grid">
        @foreach($codes as $code)
            <div class="qr-box">
                <img src="data:image/png;base64,{{ base64_encode(QrCode::format('svg')->size(200)->generate($code)) }}">
                <div>{{ $code }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
