<?php

namespace App\Tbuy\MediaLibrary\Repositories;

use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface MediaLibraryRepository
{
    public function get(): Collection;

    public function addMedia(HasMedia $model, UploadedFile $file, MediaLibraryCollection $collection): Media;

    public function delete(HasMedia $model, MediaLibraryCollection $collection, ?string $fileName = null): bool;

    /**
     * @param HasMedia $model
     * @param array<UploadedFile> $files
     * @param MediaLibraryCollection $collection
     * @return bool
     */
    public function addAllMedia(HasMedia $model, array $files, MediaLibraryCollection $collection): bool;

    public function getMedia(HasMedia $model, MediaLibraryCollection $collection): Collection;
}
