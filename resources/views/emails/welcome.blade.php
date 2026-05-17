<!doctype html>
<html>
<body style="margin:0;background:#0a0a0f;color:#e8e8f0;font-family:Inter,Arial,sans-serif;">
<div style="max-width:640px;margin:0 auto;padding:32px;background:#12121a;">
    <h1 style="font-family:Rajdhani,Arial,sans-serif;color:#e8e8f0;">Welcome, {{ $user->name }}</h1>
    <p style="color:#8888aa;">Congratulations! Your Gaming News Portal account has been created successfully.</p>
    <p style="color:#8888aa;">You can now read gaming news, leave comments, and manage your profile.</p>
    <p><a href="{{ route('home') }}" style="display:inline-block;background:#7b2fff;color:#e8e8f0;padding:12px 18px;text-decoration:none;">Open portal</a></p>
</div>
</body>
</html>
