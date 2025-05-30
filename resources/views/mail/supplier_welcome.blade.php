<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>مرحبًا بك، {{ $supplierName }}!</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; text-align: right; background-color: #f8f9fa; padding: 20px; }
        .container { max-width: 600px; background: #ffffff; margin: auto; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { color: #007bff; text-align: center; }
        p { font-size: 16px; color: #555; }
        .btn { display: block; width: 200px; margin: 20px auto; padding: 10px; text-align: center; background-color: #007bff; color: white; font-weight: bold; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🌟 مرحبًا {{ $supplierName }}!</h2>
        <p>يسعدنا أن نرحب بك في نظام الموردين لدينا، ونتطلع إلى تعاون مثمر مع شركتك.</p>
        <p>يمكنك الآن إدارة بياناتك، الاطلاع على الطلبات، والفواتير، من خلال لوحة التحكم الخاصة بك.</p>
        <a href="{{ $dashboardUrl }}" class="btn">🔍 الانتقال إلى لوحة التحكم</a>
        <p>إذا كنت بحاجة إلى أي دعم، لا تتردد في التواصل معنا عبر البريد الإلكتروني: <strong>{{ $supportEmail }}</strong>.</p>
        <p>نتمنى لك تجربة رائعة معنا! 🚀</p>
        <p>مع أطيب التحيات،<br><strong>فريق إدارة الموردين</strong></p>
    </div>
</body>
</html>
