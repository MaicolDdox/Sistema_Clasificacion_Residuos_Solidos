<?php

namespace Modules\Wastes\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EvidenceImageService
{
    public function store(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }

    public function replace(UploadedFile $file, string $folder, ?string $oldPath = null): string
    {
        $newPath = $this->store($file, $folder);
        $this->delete($oldPath);

        return $newPath;
    }

    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }
}
