<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Contact Us</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333;">
    <table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f4f4f9" style="margin: 20px 0;">
        <tr>
            <td>
                <table align="center" cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0070C5; color: #ffffff; text-align: center; padding: 15px;">
                            <img src="{{ url('img/logowhite.png') }}" alt="Bank Kalsel" style="max-width: 150px; margin-bottom: 10px;">
                            <h1 style="margin: 0; font-size: 20px;">Notifikasi Data Baru - Contact Us</h1>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="margin: 10px 0; font-size: 14px; line-height: 1.6;">Yth. Admin,</p>
                            <p style="margin: 10px 0; font-size: 14px; line-height: 1.6;">Kami telah menerima data baru dari formulir <strong>Formulir Pengaduan</strong> dengan rincian sebagai berikut:</p>
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 15px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px;">
                                <tr>
                                    <td style="font-size: 14px; padding: 5px 0;"><strong>Tentang:</strong> {{ $data['about'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; padding: 5px 0;"><strong>Nama:</strong> {{ $data['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; padding: 5px 0;"><strong>Email:</strong> {{ $data['email'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; padding: 5px 0;"><strong>Telepon:</strong> {{ $data['phone'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; padding: 5px 0;"><strong>Deskripsi:</strong> {{ $data['desc'] ?? 'Tidak ada deskripsi' }}</td>
                                </tr>
                            </table>
                            <p style="margin: 10px 0; font-size: 14px; line-height: 1.6;">Mohon segera ditindaklanjuti. Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi tim IT.</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #008A43; text-align: center; padding: 10px; font-size: 12px; color: #ffffff;">
                            <p style="margin: 0;">Pesan ini dikirim secara otomatis oleh sistem.</p>
                            <p style="margin: 0;">&copy; 2025 Bank Kalsel. Seluruh hak cipta dilindungi undang-undang.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>