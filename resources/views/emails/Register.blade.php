<!DOCTYPE html>
<html>
<head>
    <title>Password Akun {{ $data['menuju'] }}</title>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #2c5282;
            border-bottom: 2px solid #2c5282;
            padding-bottom: 10px;
        }
        table {
            margin: 20px 0;
            border-collapse: collapse;
        }
        td {
            padding: 8px 15px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2c5282;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2>Informasi Akun {{ $data['menuju'] }}</h2>
    <p>Yth. Bapak/Ibu {{ $data['menuju'] }}</p>
    <p>Berikut adalah informasi akun yang telah didaftarkan oleh {{ $data['oleh'] }}:</p>

    <table>
        <tr>
            <td>Email</td>
            <td>: {{ $data['data']['email'] }}</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>: {{ $data['data']['password'] }}</td>
        </tr>
    </table>

    <p>Silakan gunakan informasi di atas untuk login ke sistem.</p>
    <p>Demi keamanan akun Anda, segera ubah password setelah berhasil login.</p>

    {{-- <a href="{{ url('/login') }}" class="button">Login Sekarang</a> --}}

    <div class="footer">
        <p>Terima kasih,</p>
        <p>{{ $data['oleh'] }}</p>
        <small>Email ini dibuat secara otomatis. Mohon tidak membalas email ini.</small>
    </div>
</body>
</html>
