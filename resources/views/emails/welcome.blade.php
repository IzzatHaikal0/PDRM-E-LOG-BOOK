<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang ke Sistem PDRM</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        {{-- Header --}}
        <div style="background-color: #00205B; padding: 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0;">Sistem PDRM</h2>
        </div>

        {{-- Content --}}
        <div style="padding: 30px;">
            <p style="color: #333; font-size: 16px;">Salam Sejahtera <strong>{{ $user->name }}</strong>,</p>
            
            <p style="color: #555; line-height: 1.6;">
                Akaun anda telah berjaya didaftarkan dalam sistem. Berikut adalah maklumat log masuk sementara anda. 
                Sila tukar kata laluan anda sebaik sahaja anda berjaya log masuk.
            </p>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin: 20px 0;">
                <p style="margin: 5px 0; color: #555;"><strong>URL Sistem:</strong> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
                <p style="margin: 5px 0; color: #555;"><strong>ID Pengguna (Emel):</strong> {{ $user->email }}</p>
                <p style="margin: 5px 0; color: #555;"><strong>Kata Laluan Sementara:</strong> <span style="font-family: monospace; background-color: #e2e8f0; padding: 2px 6px; border-radius: 4px;">{{ $password }}</span></p>
            </div>

            <p style="color: #555;">Terima kasih.</p>
        </div>

        {{-- Footer --}}
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #888;">
            &copy; {{ date('Y') }} Sistem PDRM. Emel ini dijana secara automatik.
        </div>
    </div>

</body>
</html>