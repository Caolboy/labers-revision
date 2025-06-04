<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Approved</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #ff7f3f 0%, #ff6b2b 100%);
            padding: 30px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s linear infinite;
        }
        
        @keyframes float {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        .logo {
            background-color: #5d4e37;
            color: #ff7f3f;
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .header h1 {
            color: white;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        
        .success-icon {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }
        
        .checkmark {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #4CAF50;
            position: relative;
        }
        
        .checkmark::after {
            content: '';
            position: absolute;
            left: 15px;
            top: 8px;
            width: 8px;
            height: 16px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
        
        .content {
            padding: 40px;
            color: #333;
        }
        
        .greeting {
            font-size: 18px;
            color: #5d4e37;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .booking-details {
            background: linear-gradient(135deg, #fef7f0 0%, #fdf2e9 100%);
            border-left: 4px solid #ff7f3f;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }
        
        .booking-details h3 {
            color: #5d4e37;
            margin: 0 0 15px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 127, 63, 0.1);
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: #5d4e37;
        }
        
        .detail-value {
            color: #ff7f3f;
            font-weight: 500;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #ff7f3f 0%, #ff6b2b 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(255, 127, 63, 0.3);
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 127, 63, 0.4);
        }
        
        .footer {
            background-color: #5d4e37;
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        
        .footer p {
            margin: 0;
            opacity: 0.9;
        }
        
        .lab-illustration {
            width: 100%;
            max-width: 300px;
            margin: 20px auto;
            display: block;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100%;
                margin: 0;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">
                <img src="/labers1.png" alt="LABERS Logo" />
            </div>
            <h1>Booking Approved!</h1>
            <div class="success-icon">
                <div class="checkmark"></div>
            </div>
        </div>
        
        <div class="content">
            <div class="greeting">Hello {{ $booking->user->name }},</div>
            
            <div class="message">
                Great news! Your laboratory booking request has been approved and confirmed. 
                You can now proceed with your scheduled session.
            </div>
            
            <div class="booking-details">
                <h3>📋 Booking Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Booking Date:</span>
                    <span class="detail-value">{{ $booking->booking_date }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">✅ Approved</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->id }}</span>
                </div>
            </div>
            
            <div class="message">
                Please make sure to arrive on time and bring any required materials. 
                If you need to make any changes to your booking, please contact us as soon as possible.
            </div>
            
            <div class="message" style="margin-top: 30px; font-size: 14px; color: #888;">
                If you have any questions or concerns, please don't hesitate to contact our support team.
            </div>
        </div>
        
        <div class="footer">
            <p><strong>LABERS Laboratory Management System</strong></p>
            <p>Thank you for using our booking system!</p>
        </div>
    </div>
</body>
</html>