<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - CloudDrive</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background: var(--bg);
            background-image: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 { font-size: 2.5rem; margin-bottom: 12px; background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        p { color: var(--text-muted); margin-bottom: 32px; }

        .input-group { margin-bottom: 24px; text-align: left; }
        label { display: block; margin-bottom: 8px; color: var(--text-muted); }
        input { width: 100%; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border); border-radius: 12px; padding: 14px; color: white; font-size: 1rem; }
        
        .btn { width: 100%; background: var(--primary); color: white; border: none; border-radius: 12px; padding: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn:hover { background: var(--primary-hover); transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="card">
        <h1>CloudDrive</h1>
        <p>Enter your email to access your personal dashboard.</p>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <button type="submit" class="btn">Continue to Dashboard</button>
        </form>
    </div>
</body>
</html>
