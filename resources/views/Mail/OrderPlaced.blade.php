<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #004aad;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>Thank you for your order! We have received your payment and your order is now confirmed.</p>
            <p>Here are the details of your order:</p>
            <ul>
                <li><strong>Amount:</strong> ${{ $Amount }}</li>
                <li><strong>Invoice Number:</strong> {{ $InvoiceNum }}</li>
                <li><strong>Order Date:</strong> {{ $year }}</li>
            </ul>
            <p>We are processing your order and will notify you once it is shipped.</p>
            <p>If you have any questions or concerns, please contact us.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>{{ $companyName }}</p>
        </div>
    </div>
</body>
</html>