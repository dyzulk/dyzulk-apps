<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">

    <style>
        body {
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #26577C;
        }

        h1 {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 40px;
            font-weight: 800;
        }

        .email-container {
            font-family: 'Segoe UI', Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px;
            border: 1px solid #eee;
            background-color: #fff;
            padding-top: 20px;
            padding-bottom: 40px;
            padding-left: 40px;
            padding-right: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #E55604;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;           
        }

        .btn:hover {
            opacity: 0.8;
            transition: 0.3s;
        }

        .header-logo {
            display: block;
            margin: 0 auto;
            max-width: 100%;
        }

        .tipis {
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }

        .copyright {
            font-family: 'Segoe UI', Arial, sans-serif;
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #EBE4D1;
        }

        .unsubscribe {
            text-align: center;
            font-size: 12px;
            color: #EBE4D1;
            text-decoration: none;
            display: block;
            margin-top: 5px;
        }

        .link-container {
            margin-top: 20px;
            margin-bottom: 20px;
            max-width: 75%;
        }

        .link {
            font-size: 14px;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hr2 {
            margin-bottom: 20px;
        }

        .email {
            color: #E55604;
            font-size: 30px;
        }
        
        .untuk {
            font-size: 30px;
        }

    </style>
</head>

<body>

    <div class="email-container">
        <img class="header-logo" src="https://dyzulk.me/dist/img/favicon.png" alt="Logo" width="100">
        <h1>Pemulihan password<br/><span class="untuk">Untuk </span><span class="email"><?=$email.'.';?></span></h1>
        <p>Terima kasih telah bersama dengan Dyzulk Apps. Untuk memperbarui password Anda. Silakan klik tautan di bawah ini.</p>
        <a href="<?=$link;?>" target="_blank" class="btn">Perbarui Password</a>
        <p class="tipis">Demi keamanan, tautan ini hanya akan aktif selama 24jam</p>
        <hr>
        
        <p>Jika Anda mengalami masalah saat mengklik tombol "<b>Perbarui Password</b>", salin dan tempel tautan di bawah ini ke browser web Anda:</p>
        <div class="link-container">
            <a href="<?=$link;?>" target="_blank" class="link"><?=$link;?></a>
        </div>
        <hr class="hr2">
        <p class="tipis">Jika Anda tidak meminta email ini, harap abaikan saja.</p>
    </div>

    <div class="copyright">
        Copyright © 2023 Dyzulk Apps. All rights reserved.
    </div>

</body>

</html>
