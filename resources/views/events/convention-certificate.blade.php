<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convention Certificate</title>
    <style>
        /* Use the full width and height of the Letter page */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Letter Page dimensions (8.5 x 11 inches = 216mm x 279mm) */
        @page {
            size: letter;
            margin: 0;
        }

        /* Set the background image to cover the full Letter page */
        .certificate {
            width: 216mm;
            height: 279mm;
            background-image: url('{{ $bgimage }}');
            background-size: contain; /* Ensures the image fits within the Letter page */
            background-position: center center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents repeating the image */
            background-attachment: fixed; /* Ensures the image stays fixed */
            position: relative;
        }

        /* Example content style */
        .content {
            position: absolute;
            top: 50%; /* Adjust this as necessary */
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
        }

        .content h1 {
            font-size: 36px;
            font-weight: bold;
        }

        .content p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <!-- Example overlay content -->
        <div class="content">
            <h1>Convention Certificate</h1>
            <p>This is to certify that [Name] attended the convention on [Date].</p>
        </div>
    </div>
</body>
</html>
