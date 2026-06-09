<?php

namespace App\Domains\Images\Services;

use App\Domains\Images\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function store(
        UploadedFile $file,
        ?string $directory = 'images'
    ): Image {
        $path = $file->store($directory, 'public');

        return Image::create([
            'path'          => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime'          => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);
    }

    public function delete(Image $image): void
    {
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();
    }

    public function find(int $id): ?Image
    {
        return Image::find($id);
    }
}