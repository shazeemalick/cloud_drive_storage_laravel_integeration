<?php

namespace App\Http\Controllers;
 
use App\Models\UserFile;
use App\Models\UserFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class DriveController extends Controller
{
    /**
     * Show the login/welcome page.
     */
    public function index()
    {
        if (session()->has('user_email')) {
            return redirect()->route('dashboard');
        }
        return view('welcome');
    }
 
    /**
     * Handle simple email-based login.
     */
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        // Find or create the user record
        $user = \App\Models\User::firstOrCreate(
            ['email' => $request->email],
            ['name' => explode('@', $request->email)[0], 'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16))]
        );

        session(['user_email' => $request->email]);
        return redirect()->route('dashboard');
    }
 
    /**
     * Handle logout.
     */
    public function logout()
    {
        session()->forget('user_email');
        return redirect()->route('upload.index');
    }
 
    /**
     * Show the user dashboard.
     */
    public function dashboard()
    {
        $email = session('user_email');
        if (!$email) return redirect()->route('upload.index');
 
        $folders = UserFolder::where('email', $email)->get();
        $files = UserFile::where('email', $email)->latest()->take(5)->get();
 
        return view('dashboard', compact('folders', 'files', 'email'));
    }
 
    /**
     * Create a new folder on Google Drive and in DB.
     */
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
            'disk' => 'required|string|in:google,google_two',
        ]);
        $email = session('user_email');
        $disk = $request->disk;
 
        // Create folder on Google Drive
        Storage::disk($disk)->makeDirectory($request->folder_name);
        
        UserFolder::create([
            'email' => $email,
            'disk' => $disk,
            'folder_name' => $request->folder_name,
            'google_drive_id' => $request->folder_name,
        ]);
 
        return back()->with('success', "Folder created successfully on " . ($disk == 'google' ? 'Primary' : 'Secondary') . " Drive!");
    }
 
    /**
     * Show upload form with folder selection.
     */
    public function uploadForm()
    {
        $email = session('user_email');
        if (!$email) return redirect()->route('upload.index');
 
        $folders = UserFolder::where('email', $email)->get();
        return view('upload', compact('folders'));
    }
 
    /**
     * Handle file upload to a specific folder.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'folder_id' => 'nullable|exists:user_folders,id',
        ]);
 
        $email = session('user_email');
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        
        $folderPath = '';
        $disk = 'google'; // Default to primary if no folder
        
        if ($request->folder_id) {
            $folder = UserFolder::find($request->folder_id);
            $folderPath = $folder->folder_name . '/';
            $disk = $folder->disk;
        }
 
        // Upload to the specific folder's disk
        $path = Storage::disk($disk)->putFileAs($folderPath, $file, $fileName);
        
        UserFile::create([
            'email' => $email,
            'folder_id' => $request->folder_id,
            'file_id' => $path,
            'file_name' => $fileName,
        ]);
 
        return redirect()->route('dashboard')->with('success', 'File uploaded successfully!');
    }
 
    /**
     * Show all user assets.
     */
    public function gallery(Request $request)
    {
        $email = session('user_email');
        if (!$email) return redirect()->route('upload.index');
 
        $files = UserFile::where('email', $email)->with('folder')->get();
        return view('gallery', compact('files', 'email'));
    }
 
    /**
     * Download a file from Google Drive.
     */
    public function download($id)
    {
        $userFile = UserFile::findOrFail($id);
        
        // Use folder's disk if available, otherwise default primary
        $disk = $userFile->folder ? $userFile->folder->disk : 'google';
        
        $content = Storage::disk($disk)->get($userFile->file_id);
        
        return response($content)
            ->header('Content-Type', Storage::disk($disk)->mimeType($userFile->file_id))
            ->header('Content-Disposition', "attachment; filename=\"{$userFile->file_name}\"");
    }
}
