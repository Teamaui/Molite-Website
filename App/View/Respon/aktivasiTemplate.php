<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #098DB3;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
        }

        .email-body a {
            color: #ffffff;
        }

        .email-body p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .activation-link {
            display: inline-block;
            background-color: #098DB3;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 4px;
            text-align: center;
            margin: 20px 0;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            background-color: #f9f9f9;
            border-top: 1px solid #eaeaea;
        }

        .email-footer a {
            color: #098DB3;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Aktivasi Akun</h1>
        </div>
        <div class="email-body">
            <p>Halo {{USER_NAME}},</p>
            <p>Terima kasih telah membuat akun di aplikasi Molita! Silakan klik tautan di bawah ini untuk mengaktifkan akun Anda:</p>
            <a href="http://localhost/Molita/Public/index.php/aktivasi-akun/{{USER_ID}}/{{ACTIVATION_TOKEN}}" class="activation-link">Aktivasi Akun</a>
            <p>Jika Anda tidak membuat akun ini, abaikan email ini atau hubungi tim dukungan kami.</p>
        </div>

        <div class="email-footer">
            <p>Butuh bantuan? <a href="http://localhost/Molita/Public">Hubungi Dukungan</a></p>
            <p>&copy; 2024 Molita. Hak cipta dilindungi.</p>
        </div>
    </div>
</body>

</html>
