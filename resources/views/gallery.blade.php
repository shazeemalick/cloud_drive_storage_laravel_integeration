<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Assets - CloudDrive</title>
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
            background-image: radial-gradient(at 0% 100%, rgba(99, 102, 241, 0.1) 0px, transparent 50%);
            color: var(--text);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container { max-width: 1000px; margin: 0 auto; }

        .header { text-align: center; margin-bottom: 60px; }
        .header h1 { font-size: 2.5rem; font-weight: 600; margin-bottom: 10px; background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .header p { color: var(--text-muted); }

        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
        .file-card { background: var(--card-bg); backdrop-filter: blur(12px); border: 1px solid var(--border); border-radius: 20px; padding: 24px; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; }
        .file-card:hover { transform: translateY(-5px); border-color: rgba(99, 102, 241, 0.4); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); }

        .file-icon { font-size: 2.5rem; margin-bottom: 16px; color: var(--primary); }
        .file-name { font-weight: 600; font-size: 1.1rem; margin-bottom: 4px; word-break: break-all; }
        .file-folder { color: #fbbf24; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; }
        .file-date { color: var(--text-muted); font-size: 0.8rem; margin-bottom: 20px; }

        .download-btn { display: block; text-align: center; background: rgba(255, 255, 255, 0.05); color: var(--text); text-decoration: none; padding: 12px; border-radius: 12px; font-weight: 600; transition: all 0.3s ease; border: 1px solid var(--border); }
        .download-btn:hover { background: var(--primary); border-color: var(--primary); }

        .empty-state { text-align: center; padding: 60px; color: var(--text-muted); }
        .back-btn { display: inline-block; margin-bottom: 20px; color: var(--text-muted); text-decoration: none; transition: 0.3s; }
        .back-btn:hover { color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-btn">← Back to Dashboard</a>

        <div class="header">
            <h1>Asset Gallery</h1>
            <p>All your uploaded assets for {{ $email }}</p>
        </div>

        @if($files->count() > 0)
            <div class="gallery-grid">
                @foreach($files as $file)
                    <div class="file-card">
                        <div>
                            <div class="file-icon">📄</div>
                            <div class="file-folder">📁 {{ $file->folder ? $file->folder->folder_name : 'Root' }}</div>
                            <div class="file-name">{{ $file->file_name }}</div>
                            <div class="file-date">Uploaded {{ $file->created_at->format('M d, Y') }}</div>
                        </div>
                        <a href="{{ route('file.download', $file->id) }}" class="download-btn">Download</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>No assets found. Start by uploading some files!</p>
            </div>
        @endif
    </div>
</body>
</html>
