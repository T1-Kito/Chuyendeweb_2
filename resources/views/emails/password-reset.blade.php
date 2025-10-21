<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã Xác Thực Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .title {
            color: #1f2937;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .verification-code {
            background: #f8fafc;
            border: 2px dashed #2563eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .code {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 2px;
            word-break: break-all;
        }
        .instructions {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 15px;
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
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">WebChoThu</div>
            <h1 class="title">Mã Xác Thực Đặt Lại Mật Khẩu</h1>
        </div>

        <p>Xin chào,</p>
        
        <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản <strong>{{ $email }}</strong>.</p>

        <div class="verification-code">
            <p style="margin: 0 0 10px 0; color: #6b7280;">Mã xác thực của bạn:</p>
            <div class="code">{{ $verificationCode }}</div>
        </div>

        <div class="instructions">
            <h3 style="margin-top: 0; color: #1f2937;">Hướng dẫn sử dụng:</h3>
            <ol>
                <li>Copy mã xác thực 8 ký tự ở trên</li>
                <li>Quay lại trang web và dán mã vào ô "Mã xác thực"</li>
                <li>Nhấn "Xác Thực Mã" để tiếp tục</li>
                <li>Nhập mật khẩu mới và hoàn tất</li>
            </ol>
        </div>

        <div class="warning">
            <strong>⚠️ Lưu ý quan trọng:</strong>
            <ul style="margin: 10px 0 0 0;">
                <li>Mã xác thực có hiệu lực trong 24 giờ</li>
                <li>Không chia sẻ mã này với bất kỳ ai</li>
                <li>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này</li>
            </ul>
        </div>

        <p>Nếu bạn gặp khó khăn, vui lòng liên hệ với chúng tôi qua email hoặc hotline.</p>

        <div class="footer">
            <p><strong>WebChoThu - Dịch Vụ Cho Thuê Thiết Bị Chấm Công & Kiểm Soát Ra Vào</strong></p>
            <p>Email: info@webchothu.com | Hotline: 0981 201 889</p>
            <p>© {{ date('Y') }} WebChoThu. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
