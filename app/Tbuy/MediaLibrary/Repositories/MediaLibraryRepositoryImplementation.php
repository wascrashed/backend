<?php

namespace App\Tbuy\MediaLibrary\Repositories;

use App\Enums\MorphType;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryRepositoryImplementation implements MediaLibraryRepository
{
    public function get(): Collection
    {
        return Media::query()->get();
    }

    public function addMedia(HasMedia $model, UploadedFile $file, MediaLibraryCollection $collection): Media
    {
        return $model->addMedia($file)->toMediaCollection($collection->value);
    }

    public function delete(HasMedia $model, MediaLibraryCollection $collection, ?string $fileName = null): bool
    {
        $type = MorphType::getType($model::class);

        Media::query()
            ->where('model_type', $type)
            ->where('model_id', $model->id)
            ->where('collection_name', $collection->value)
            ->when($fileName, fn(Builder $builder) => $builder->where('file_name', $fileName))
            ->delete();

        return true;
    }

    public function addAllMedia(HasMedia $model, array $files, MediaLibraryCollection $collection): bool
    {
        DB::transaction(function () use ($model, $files, $collection) {
            foreach ($files as $file) {
                $this->addMedia($model, $file, $collection);
            }
        });

        return true;
    }

    public function getMedia(HasMedia $model, MediaLibraryCollection $collection): Collection
    {
        return $this->get()
            ->where('model_id', $model->id)
            ->where('model_type', MorphType::getType($model::class))
            ->where('collection_name', $collection->value);
    }

}
