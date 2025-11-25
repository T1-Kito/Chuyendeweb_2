<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã xác thực hai lớp</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background-color: #f9fafb;
            margin: 0;
            padding: 24px;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .header {
            padding: 32px 32px 16px;
            text-align: center;
        }
        .logo {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #2563eb;
            margin-bottom: 6px;
        }
        .subtitle {
            margin: 0;
            color: #6b7280;
        }
        .content {
            padding: 0 32px 32px;
        }
        .greeting {
            font-size: 18px;
            margin: 0 0 16px;
        }
        .card {
            background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 24px 0;
            border: 1px solid #bfdbfe;
        }
        .card-title {
            font-weight: 600;
            color: #1d4ed8;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13px;
        }
        .code {
            font-family: 'Courier New', monospace;
            font-size: 28px;
            font-weight: 700;
            color: #1e3a8a;
            letter-spacing: 6px;
        }
        .info {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 16px 20px;
            border-radius: 0 12px 12px 0;
            margin: 24px 0;
            color: #374151;
        }
        .footer {
            padding: 16px 32px 24px;
            background: #f1f5f9;
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }
        ul {
            margin: 12px 0;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="logo">WebChoThu</div>
        <p class="subtitle">Xác minh đăng nhập an toàn hơn</p>
    </div>
    <div class="content">
        <p class="greeting">Xin chào {{ $name }},</p>
        <p>Chúng tôi đã nhận yêu cầu bật xác thực hai lớp (2FA) cho tài khoản của bạn. Vui lòng sử dụng mã dưới đây để hoàn tất quá trình:</p>
        <div class="card">
            <div class="card-title">MÃ XÁC THỰC</div>
            <div class="code">{{ $code }}</div>
        </div>
        <div class="info">
            <strong>Lưu ý quan trọng:</strong>
            <ul>
                <li>Mã có hiệu lực trong 10 phút kể từ khi email được gửi.</li>
                <li>Không chia sẻ mã này với bất kỳ ai. Nhân viên WebChoThu không bao giờ yêu cầu bạn cung cấp mã.</li>
                <li>Nếu bạn không yêu cầu bật 2FA, hãy bỏ qua email này hoặc liên hệ với chúng tôi ngay.</li>
            </ul>
        </div>
        <p>Sau khi nhập mã thành công, xác thực hai lớp sẽ được kích hoạt cho tài khoản của bạn để bảo vệ tốt hơn.</p>
        <p>Trân trọng,<br><strong>Đội ngũ WebChoThu</strong></p>
    </div>
    <div class="footer">
        <p>Email: support@webchothu.com · Hotline: 0981 201 889</p>
        <p>© {{ date('Y') }} WebChoThu. Tất cả các quyền được bảo lưu.</p>
    </div>
</div>
</body>
</html>
