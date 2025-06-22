<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;    // Import model Video
use App\Http\Requests\StoreVideoRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdateVideoRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus file

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua video edukasi.
     */
    public function index()
    {
        // Ambil semua data video, diurutkan berdasarkan terbaru
        $videos = Video::latest()->paginate(10); 

        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat video baru.
     */
    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan video baru ke database dan mengunggah file video serta thumbnail.
     *
     * @param  \App\Http\Requests\StoreVideoRequest  $request
     */
    public function store(StoreVideoRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StoreVideoRequest
            $data = $request->validated();

            // Handle file upload 'file_video'
            $videoFilePath = null;
            if ($request->hasFile('file_video')) {
                $videoFile = $request->file('file_video');
                // Simpan file ke direktori 'videos' di storage
                $videoFilePath = $videoFile->store('videos', 'public');
                $data['file_video'] = $videoFilePath;
            }

            // Handle file upload 'thumbnail'
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                // Simpan file ke direktori 'thumbnails' di storage
                $thumbnailPath = $thumbnailFile->store('thumbnails', 'public');
                $data['thumbnail'] = $thumbnailPath;
            }

            // Set views_count default 0
            $data['views_count'] = 0;

            Video::create($data);

            // Flash message sukses
            Session::flash('success', 'Video edukasi berhasil ditambahkan!');
            return redirect()->route('admin.video.index');

        } catch (\Exception $e) {
            // Jika ada error setelah upload, pastikan file yang sudah terupload dihapus
            if (isset($videoFilePath) && Storage::disk('public')->exists($videoFilePath)) {
                Storage::disk('public')->delete($videoFilePath);
            }
            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            // Log error untuk debugging
            Log::error('Gagal menyimpan video: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan video: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail video tertentu dan menambah views count.
     *
     * @param  \App\Models\Video  $video
     */
    public function show(Video $video)
    {
        // Tambah views count setiap kali video dilihat di halaman detail
        $video->incrementViews();
        return view('admin.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data video.
     *
     * @param  \App\Models\Video  $video
     */
    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data video di database dan mengunggah file baru jika ada.
     *
     * @param  \App\Http\Requests\UpdateVideoRequest  $request
     * @param  \App\Models\Video  $video
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        try {
            // Data sudah divalidasi oleh UpdateVideoRequest
            $data = $request->validated();

            $oldVideoFilePath = $video->file_video;
            $oldThumbnailPath = $video->thumbnail;
            $newVideoFilePath = null;
            $newThumbnailPath = null;

            // Handle file upload 'file_video' jika ada
            if ($request->hasFile('file_video')) {
                $videoFile = $request->file('file_video');
                $newVideoFilePath = $videoFile->store('videos', 'public');
                $data['file_video'] = $newVideoFilePath;

                // Hapus video lama jika ada dan berhasil upload video baru
                if ($oldVideoFilePath && Storage::disk('public')->exists($oldVideoFilePath)) {
                    Storage::disk('public')->delete($oldVideoFilePath);
                }
            } else {
                // Jika tidak ada file video baru di-upload, biarkan file lama
                unset($data['file_video']);
            }

            // Handle file upload 'thumbnail' jika ada
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $newThumbnailPath = $thumbnailFile->store('thumbnails', 'public');
                $data['thumbnail'] = $newThumbnailPath;

                // Hapus thumbnail lama jika ada dan berhasil upload thumbnail baru
                if ($oldThumbnailPath && Storage::disk('public')->exists($oldThumbnailPath)) {
                    Storage::disk('public')->delete($oldThumbnailPath);
                }
            } else {
                // Jika tidak ada thumbnail baru di-upload, biarkan file lama
                unset($data['thumbnail']);
            }
            
            // views_count tidak diubah manual dari sini

            $video->update($data);

            // Flash message sukses
            Session::flash('success', 'Video edukasi berhasil diperbarui!');
            return redirect()->route('admin.video.index');

        } catch (\Exception $e) {
            // Jika ada error setelah upload file baru, pastikan file baru yang sudah terupload dihapus
            if (isset($newVideoFilePath) && $newVideoFilePath && Storage::disk('public')->exists($newVideoFilePath)) {
                Storage::disk('public')->delete($newVideoFilePath);
            }
            if (isset($newThumbnailPath) && $newThumbnailPath && Storage::disk('public')->exists($newThumbnailPath)) {
                Storage::disk('public')->delete($newThumbnailPath);
            }
            // Log error untuk debugging
            Log::error('Gagal memperbarui video: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui video: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus video dari database dan file video serta thumbnailnya.
     *
     * @param  \App\Models\Video  $video
     */
    public function destroy(Video $video)
    {
        try {
            // Hapus file video terkait jika ada
            if ($video->file_video && Storage::disk('public')->exists($video->file_video)) {
                Storage::disk('public')->delete($video->file_video);
            }
            // Hapus thumbnail terkait jika ada
            if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $video->delete();

            // Flash message sukses
            Session::flash('success', 'Video edukasi berhasil dihapus!');
            return redirect()->route('admin.video.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus video: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus video: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle the active status of a video.
     * Mengubah status aktif/non-aktif video.
     *
     * @param  \App\Models\Video  $video
     * @param  \Illuminate\Http\Request  $request
     */
    public function toggleStatus(Request $request, Video $video)
    {
        try {
            $video->is_active = !$video->is_active;
            $video->save();

            $status = $video->is_active ? 'aktif' : 'non-aktif';
            Session::flash('success', "Status video '{$video->judul}' berhasil diubah menjadi {$status}.");
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status video: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengubah status video: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}