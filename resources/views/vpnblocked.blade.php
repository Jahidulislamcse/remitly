<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted</title>
    <style>
        /* Reset & base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f3f4f6;
            font-family: "Segoe UI", Arial, sans-serif;
            padding: 1rem;
        }

        .box {
            background: white;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #e11d48;
            margin-bottom: 0.75rem;
            font-size: 1.75rem;
        }

        p {
            color: #374151;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .box {
                padding: 1.5rem;
            }
            h2 {
                font-size: 1.4rem;
            }
            p {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Access Restricted</h2>
        <p>You can not use this application using vpn for security.</p>
    </div>
</body>
</html>