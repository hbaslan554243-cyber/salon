<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Salon Manager</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.12); padding: 40px; width: 360px; }
        .login-header { text-align: center; margin-bottom: 28px; }
        .login-header h1 { font-size: 24px; color: #6b3fa0; }
        .login-header p { color: #888; font-size: 13px; margin-top: 4px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 4px; font-size: 14px; font-weight: bold; color: #555; }
        .form-control { width: 100%; padding: 9px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        .form-control:focus { outline: none; border-color: #6b3fa0; box-shadow: 0 0 0 2px rgba(107,63,160,0.15); }
        .btn-login { width: 100%; padding: 10px; background: #6b3fa0; color: white; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; margin-top: 8px; }
        .btn-login:hover { background: #5a3490; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <h1>💅 Salon Manager</h1>
            <p>Sign in to your account</p>
        </div>

        @if($errors->any())
            <div class="alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>
