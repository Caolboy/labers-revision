<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancelled</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        
        .cancelled-icon {
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
        
        .x-mark {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #dc3545;
            position: relative;
        }
        
        .x-mark::before,
        .x-mark::after {
            content: '';
            position: absolute;
            left: 18px;
            top: 10px;
            width: 4px;
            height: 20px;
            background-color: white;
            border-radius: 2px;
        }
        
        .x-mark::before {
            transform: rotate(45deg);
        }
        
        .x-mark::after {
            transform: rotate(-45deg);
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
            background: linear-gradient(135deg, #fdf2f2 0%, #fce8e6 100%);
            border-left: 4px solid #dc3545;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }
        
        .booking-details h3 {
            color: #721c24;
            margin: 0 0 15px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(220, 53, 69, 0.1);
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: #721c24;
        }
        
        .detail-value {
            color: #dc3545;
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
            margin-right: 15px;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 127, 63, 0.4);
        }
        
        .cta-button.secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }
        
        .cta-button.secondary:hover {
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
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
        
        .apologetic-message {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            color: #856404;
        }
        
        .apologetic-message h4 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 16px;
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
            
            .cta-button {
                display: block;
                margin: 10px 0;
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
            <h1>Booking Cancelled</h1>
            <div class="cancelled-icon">
                <div class="x-mark"></div>
            </div>
        </div>
        
        <div class="content">
            <div class="greeting">Hello {{ $booking->user->name }},</div>
            
            <div class="apologetic-message">
                <h4>📢 Important Notice</h4>
                We regret to inform you that your laboratory booking has been cancelled.
            </div>
            
            <div class="message">
                We understand this may cause inconvenience, and we sincerely apologize for any disruption 
                to your plans. The cancellation may be due to unforeseen circumstances, maintenance requirements, 
                or scheduling conflicts.
            </div>
            
            <div class="booking-details">
                <h3>📋 Cancelled Booking Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Booking Date:</span>
                    <span class="detail-value">{{ $booking->booking_date }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">❌ Cancelled</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Cancellation Date:</span>
                    <span class="detail-value">{{ now()->format('M d, Y') }}</span>
                </div>
            </div>
            
            <div class="message" style="margin-top: 30px; font-size: 14px; color: #888;">
                If you have any questions about this cancellation or need assistance with rebooking, 
                please don't hesitate to reach out to our support team. We're here to help make your next booking experience smooth and successful.
            </div>
        </div>
        
        <div class="footer">
            <p><strong>LABERS Laboratory Management System</strong></p>
            <p>We appreciate your understanding and look forward to serving you again.</p>
        </div>
    </div>
</body>
</html>