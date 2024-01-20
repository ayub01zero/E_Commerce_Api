<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        /* Container for the email to center it */
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header with a larger font and bolder */
        .email-header {
            font-size: 28px;
            color: #4a4a4a;
            border-bottom: 2px solid #eeeeee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        /* Body content with a softer color */
        .email-body {
            font-size: 16px;
            color: #5a5a5a;
            line-height: 1.5;
        }

        /* Footer with a smaller font and lighter color */
        .email-footer {
            font-size: 12px;
            color: #cccccc;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            Welcome to {{ $applicationName }}!
        </div>
        <div class="email-body">
            Hello {{ $name }},
            <br><br>
            Thank you for registering with us. We are glad to have you on board.
            <br><br>
            Best regards,
            <br>
            {{ $teamName }}
        </div>
        <div class="email-footer">
            © {{ $year }} {{ $companyName }}
        </div>
    </div>
</body>
</html>