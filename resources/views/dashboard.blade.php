<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CloudDrive</title>
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
        }

        .navbar {
            padding: 24px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo { font-size: 1.5rem; font-weight: 600; background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .user-nav { display: flex; align-items: center; gap: 24px; }
        .user-email { color: var(--text-muted); font-size: 0.9rem; }
        .logout-btn { color: #ef4444; text-decoration: none; font-size: 0.9rem; font-weight: 600; }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 40px; }

        .header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; }
        .header h2 { font-size: 2rem; font-weight: 600; }

        .actions { display: flex; gap: 16px; }
        .btn { padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-secondary { background: rgba(255, 255, 255, 0.05); color: white; border: 1px solid var(--border); }
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.1); }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 48px; }
        .stat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 20px; padding: 24px; backdrop-filter: blur(12px); }
        .stat-label { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 8px; }
        .stat-value { font-size: 1.8rem; font-weight: 600; }

        .section-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }

        .folder-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-bottom: 48px; }
        .folder-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px; transition: 0.3s; text-decoration: none; color: white; }
        .folder-card:hover { border-color: var(--primary); transform: translateY(-3px); background: rgba(99, 102, 241, 0.05); }
        .folder-icon { font-size: 1.5rem; color: #fbbf24; }

        .recent-files { background: var(--card-bg); border: 1px solid var(--border); border-radius: 24px; padding: 32px; backdrop-filter: blur(12px); }
        .file-list { list-style: none; }
        .file-item { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid var(--border); }
        .file-item:last-child { border-bottom: none; }
        .file-info { display: flex; align-items: center; gap: 16px; }
        .file-icon { font-size: 1.25rem; color: var(--primary); }
        .file-name { font-weight: 600; }
        .file-meta { color: var(--text-muted); font-size: 0.85rem; }

        /* Modal Styles */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(8px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--bg); border: 1px solid var(--border); border-radius: 24px; padding: 40px; width: 100%; max-width: 400px; }
        .modal-content h3 { margin-bottom: 24px; font-size: 1.5rem; }
        .modal-content input { width: 100%; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border); border-radius: 12px; padding: 14px; color: white; margin-bottom: 24px; }

        .alert { padding: 16px; border-radius: 12px; margin-bottom: 24px; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">CloudDrive</div>
        <div class="user-nav">
            <span class="user-email">{{ $email }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn" style="background:none; border:none; cursor:pointer;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="header">
            <div>
                <h2>My Drive</h2>
            </div>
            <div class="actions">
                <button class="btn btn-secondary" onclick="openModal()">+ New Folder</button>
                <a href="{{ route('upload.form') }}" class="btn btn-primary">↑ Upload File</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Files</div>
                <div class="stat-value">{{ $files->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Folders</div>
                <div class="stat-value">{{ $folders->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Storage Usage</div>
                <div class="stat-value">Cloud</div>
            </div>
        </div>

        <h3 class="section-title"><span>📂</span> Folders</h3>
        <div class="folder-grid">
            @forelse($folders as $folder)
                <div class="folder-card">
                    <span class="folder-icon">folder</span>
                    <div>
                        <div class="folder-name">{{ $folder->folder_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $folder->disk == 'google' ? 'Primary' : 'Secondary' }}</div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted);">No folders created yet.</p>
            @endforelse
        </div>

        <div class="recent-files">
            <div class="section-title" style="margin-bottom: 0;">
                <span>📄</span> Recent Files
                <a href="{{ route('gallery.index') }}" style="margin-left: auto; font-size: 0.9rem; color: var(--primary); text-decoration: none;">View All →</a>
            </div>
            <ul class="file-list">
                @forelse($files as $file)
                    <li class="file-item">
                        <div class="file-info">
                            <span class="file-icon">insert_drive_file</span>
                            <div>
                                <div class="file-name">{{ $file->file_name }}</div>
                                <div class="file-meta">
                                    {{ $file->folder ? $file->folder->folder_name : 'Root' }} • 
                                    <span style="color: var(--primary);">{{ ($file->folder ? $file->folder->disk : 'google') == 'google' ? 'Primary' : 'Secondary' }}</span> • 
                                    {{ $file->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('file.download', $file->id) }}" class="btn btn-secondary" style="padding: 8px 16px;">Download</a>
                    </li>
                @empty
                    <li class="file-item" style="color: var(--text-muted);">No files uploaded yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div id="folderModal" class="modal">
        <div class="modal-content">
            <h3>New Folder</h3>
            <form action="{{ route('folders.create') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <input type="text" name="folder_name" placeholder="Folder name" required autofocus style="margin-bottom: 12px;">
                    <select name="disk" required style="width: 100%; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border); border-radius: 12px; padding: 14px; color: white;">
                        <option value="google">Primary Drive</option>
                        <option value="google_two">Secondary Drive</option>
                    </select>
                </div>
                <div style="display: flex; gap: 12px;">
                    <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() { document.getElementById('folderModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('folderModal').style.display = 'none'; }
        window.onclick = function(event) {
            if (event.target == document.getElementById('folderModal')) closeModal();
        }
    </script>
</body>
</html>
