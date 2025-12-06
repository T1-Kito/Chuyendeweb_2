<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ từ website</title>
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
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
        }
        .logo {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .subtitle {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 32px;
        }
        .info-section {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #374151;
            min-width: 120px;
        }
        .info-value {
            color: #1f2937;
            flex: 1;
        }
        .message-box {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin: 24px 0;
            color: #1e3a8a;
        }
        .message-title {
            font-weight: 600;
            margin-bottom: 12px;
            color: #1d4ed8;
        }
        .message-content {
            white-space: pre-wrap;
            line-height: 1.8;
        }
        .newsletter-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
        .footer {
            padding: 16px 32px 24px;
            background: #f1f5f9;
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="logo">WebChoThu</div>
        <p class="subtitle">Thông báo liên hệ mới từ website</p>
    </div>
    <div class="content">
        <p>Bạn có một tin nhắn liên hệ mới từ website:</p>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Họ và tên:</span>
                <span class="info-value">{{ $name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">
                    <a href="mailto:{{ $email }}" style="color: #2563eb; text-decoration: none;">{{ $email }}</a>
                </span>
            </div>
            @if($phone)
            <div class="info-row">
                <span class="info-label">Số điện thoại:</span>
                <span class="info-value">
                    <a href="tel:{{ $phone }}" style="color: #2563eb; text-decoration: none;">{{ $phone }}</a>
                </span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Chủ đề:</span>
                <span class="info-value">
                    @php
                        $subjectLabels = [
                            'general' => 'Thông tin chung',
                            'rental' => 'Tư vấn thuê thiết bị',
                            'support' => 'Hỗ trợ kỹ thuật',
                            'partnership' => 'Hợp tác kinh doanh',
                            'other' => 'Khác',
                        ];
                        echo $subjectLabels[$subjectType] ?? $subjectType;
                    @endphp
                </span>
            </div>
            @if($newsletter)
            <div class="info-row">
                <span class="info-label">Đăng ký nhận tin:</span>
                <span class="info-value">
                    <span class="newsletter-badge">Có</span>
                </span>
            </div>
            @endif
        </div>

        <div class="message-box">
            <div class="message-title">Nội dung tin nhắn:</div>
            <div class="message-content">{{ $messageContent }}</div>
        </div>

        <p style="margin-top: 24px; color: #6b7280; font-size: 14px;">
            <strong>Thời gian:</strong> {{ now()->format('d/m/Y H:i:s') }}
        </p>
    </div>
    <div class="footer">
        <p>Email: support@webchothu.com · Hotline: 0981 201 889</p>
        <p>© {{ date('Y') }} WebChoThu. Tất cả các quyền được bảo lưu.</p>
    </div>
</div>
</body>
</html>

