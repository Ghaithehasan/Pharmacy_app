<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ تأكيد حسابك - تجربة سحرية ✨</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

        body { font-family: 'Cairo', sans-serif; background: linear-gradient(135deg, #1f1c2c, #928dab); color: white; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; padding: 20px; border-radius: 12px; text-align: center; background: rgba(255, 255, 255, 0.1); box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); }
        h1 { font-size: 28px; margin-bottom: 10px; animation: fadeIn 1.5s ease-in-out; }
        p { font-size: 16px; margin-bottom: 20px; }
        .magic-code { font-size: 32px; font-weight: bold; background: rgba(255, 255, 255, 0.2); padding: 15px; border-radius: 8px; display: inline-block; animation: pulse 1.5s infinite alternate; }
        .verify-btn { display: inline-block; background: #ff9800; color: white; padding: 12px 20px; border-radius: 8px; font-size: 18px; text-decoration: none; transition: 0.3s; animation: glow 1.5s infinite alternate; }
        .verify-btn:hover { background: #ff5722; transform: scale(1.1); }
        .footer { margin-top: 25px; font-size: 14px; color: #ddd; }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        @keyframes glow {
            0% { box-shadow: 0 0 10px #ff9800; }
            100% { box-shadow: 0 0 20px #ff5722; }
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>🎉 مرحبًا بك في المستقبل، {{$user_name}}! 🎉</h1>
        <p>لقد وصلت إلى البوابة السرية لتفعيل حسابك، أدخل هذا الكود السحري أو اضغط الزر أدناه:</p>
        <div class="magic-code">{{$var_code}}</div>
        <br><br>
        <a href="{{$verification_link}}" class="verify-btn">✅ تأكيد الحساب</a>
        <p class="footer">🚀 شكراً لانضمامك إلينا! لا تتردد في التواصل معنا عند الحاجة.</p>
    </div>

</body>
</html>






















{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{ $message_m }}
</body>
</html> --}}
