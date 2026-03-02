<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Assets - CloudDrive</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: rgba(15, 23, 42, 0.6);
            --border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background: var(--bg);
            background-image: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container { width: 100%; max-width: 500px; }

        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { font-size: 2.5rem; font-weight: 600; margin-bottom: 10px; background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .header p { color: var(--text-muted); font-size: 1.1rem; }

        .card { background: var(--card-bg); backdrop-filter: blur(12px); border: 1px solid var(--border); border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }

        .form-group { margin-bottom: 24px; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--text-muted); }
        .form-control { width: 100%; background: var(--input-bg); border: 1px solid var(--border); border-radius: 12px; padding: 14px 16px; color: var(--text); font-size: 1rem; transition: all 0.3s ease; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

        .file-upload-wrapper { position: relative; border: 2px dashed var(--border); border-radius: 12px; padding: 30px; text-align: center; cursor: pointer; transition: all 0.3s ease; }
        .file-upload-wrapper:hover { border-color: var(--primary); background: rgba(99, 102, 241, 0.05); }
        .file-upload-wrapper input[type="file"] { position: absolute; left: 0; top: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
        .file-upload-icon { font-size: 2rem; margin-bottom: 10px; color: var(--primary); }

        .btn { width: 100%; background: var(--primary); color: white; border: none; border-radius: 12px; padding: 16px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-top: 10px; }
        .btn:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); }

        .footer-link { text-align: center; margin-top: 24px; }
        .footer-link a { color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s ease; }
        .footer-link a:hover { color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Upload Assets</h1>
            <p>Upload files to your Google Drive folders</p>
        </div>

        <div class="card">
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="folder_id">Select Destination Folder</label>
                    <select name="folder_id" id="folder_id" class="form-control">
                        <option value="">Root Directory</option>
                        @foreach($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->folder_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Upload File</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-icon">↑</div>
                        <p id="file-name-display">Drop your file here or click to browse</p>
                        <input type="file" name="file" id="file-input" required onchange="updateFileName(this)">
                    </div>
                </div>

                <button type="submit" class="btn">Upload to Drive</button>
            </form>
        </div>

        <div class="footer-link">
            <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files.length > 0) {
                display.innerText = input.files[0].name;
                display.style.color = '#fff';
            } else {
                display.innerText = 'Drop your file here or click to browse';
                display.style.color = '#94a3b8';
            }
        }
    </script>
</body>
</html>
