<?php

namespace App\Console\Commands;

use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearTrashFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-trash-files-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear trash files';

    public function __construct(private readonly MediaLibraryRepository $libraryRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $media_ids = $this->libraryRepository->get()->pluck('id')->toArray();

        foreach(Storage::directories('public') as $directory) {

            if (!in_array(basename($directory), $media_ids)) {
                $is_deleted = Storage::deleteDirectory("app/".$directory);
                dump($directory, $is_deleted);
            }
        }
    }
}
