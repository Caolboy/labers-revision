<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #ff7849 0%, #ff9563 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .confirmation-text {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }
        
        .booking-details {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #ff7849;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
            flex: 1;
        }
        
        .detail-value {
            color: #212529;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }
        
        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status.cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        
        .footer-message {
            margin-bottom: 15px;
            font-size: 16px;
            color: #495057;
        }
        
        .contact-info {
            font-size: 13px;
            line-height: 1.5;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #ff7849 0%, #ff9563 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }
        
        .button:hover {
            transform: translateY(-1px);
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .booking-details {
                padding: 20px;
            }
            
            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .detail-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">
                <div class="logo-text">LABERS</div>
            </div>
            <h1>Booking Confirmed!</h1>
            <p>Your reservation has been successfully processed</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hi {{ $booking->user->name }},
            </div>
            
            <div class="confirmation-text">
                Great news! Your {{ $type }} booking has been successfully submitted and is being processed.
            </div>
            
            <div class="booking-details">
                <div class="detail-item">
                    <div class="detail-label">📅 Date:</div>
                    <div class="detail-value">{{ $booking->booking_date }}</div>
                </div>
                
                @if ($type === 'room')
                    <div class="detail-item">
                        <div class="detail-label">🏢 Room:</div>
                        <div class="detail-value">{{ $booking->room->room_number }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">🔬 Lab:</div>
                        <div class="detail-value">{{ $booking->room->lab->name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">⏰ Time Slot:</div>
                        <div class="detail-value">{{ $booking->timeSlot->slot }}</div>
                    </div>
                @else
                    <div class="detail-item">
                        <div class="detail-label">🔧 Equipment:</div>
                        <div class="detail-value">{{ $booking->equipment->name }}</div>
                    </div>
                @endif
                
                <div class="detail-item">
                    <div class="detail-label">📊 Status:</div>
                    <div class="detail-value">
                        <span class="status {{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-message">
                Thank you for using our Lab Booking System!
            </div>
            <div class="contact-info">
                If you have any questions or need to make changes to your booking,<br>
                please contact us or visit your dashboard.
            </div>
        </div>
    </div>
</body>
</html>