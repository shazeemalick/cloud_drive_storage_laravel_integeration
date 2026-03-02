<?php

namespace App\Http\Controllers;
 
use App\Models\UserFile;
use App\Models\UserFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
 
class ApiController extends Controller
{
    /**
     * Create a folder on Google Drive and return its ID.
     */
    public function createFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'folder_name' => 'required|string|max:255',
            'disk' => 'nullable|string|in:google,google_two',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
 
        $disk = $request->disk ?? 'google';
        
        try {
            Storage::disk($disk)->makeDirectory($request->folder_name);
            
            $folder = UserFolder::create([
                'email' => $request->email,
                'disk' => $disk,
                'folder_name' => $request->folder_name,
                'google_drive_id' => $request->folder_name,
            ]);
 
            return response()->json([
                'status' => 'success',
                'message' => 'Folder created successfully',
                'data' => [
                    'folder_id' => $folder->id,
                    'folder_name' => $folder->folder_name,
                    'disk' => $folder->disk
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
 
    /**
     * Upload a file and return its ID.
     */
    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'file' => 'required|file',
            'folder_id' => 'nullable|exists:user_folders,id',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
 
        try {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            
            $folderPath = '';
            $disk = 'google';
            
            if ($request->folder_id) {
                $folder = UserFolder::find($request->folder_id);
                $folderPath = $folder->folder_name . '/';
                $disk = $folder->disk;
            }
 
            $path = Storage::disk($disk)->putFileAs($folderPath, $file, $fileName);
            
            $userFile = UserFile::create([
                'email' => $request->email,
                'folder_id' => $request->folder_id,
                'file_id' => $path,
                'file_name' => $fileName,
            ]);
 
            return response()->json([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'data' => [
                    'file_id' => $userFile->id,
                    'file_name' => $userFile->file_name,
                    'path' => $path
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
 
    /**
     * Get file metadata.
     */
    public function getFile($id)
    {
        $file = UserFile::with('folder')->find($id);
 
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found'], 404);
        }
 
        return response()->json([
            'status' => 'success',
            'data' => $file
        ]);
    }
 
    /**
     * Download file.
     */
    public function downloadFile($id)
    {
        $file = UserFile::find($id);
 
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found'], 404);
        }
 
        try {
            $disk = $file->folder ? $file->folder->disk : 'google';
            $content = Storage::disk($disk)->get($file->file_id);
            $mimeType = Storage::disk($disk)->mimeType($file->file_id);
 
            return response($content)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', "attachment; filename=\"{$file->file_name}\"");
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
