<?php

namespace App\Jobs;

use App\Services\UserService;
use Polly\Core\App;
use Polly\Core\Cronjob;
use Polly\Helpers\FileSystem;
use Polly\Helpers\Str;

/**
 * Class AutoCleanDirectoryJob.
 * Delete all files in a directory where the file .autoclean exists
 * @package App\Jobs
 */
class AutoCleanDirectoryJob extends Cronjob
{
    const FILENAME = ".autoclean";

    public function run(): bool
    {
        $contents = FileSystem::getDirectoryContent(App::getBasePath());
        $toCleanDirectories = [];
        foreach($contents as $fileOrDirectory)
            if(Str::contains($fileOrDirectory, AutoCleanDirectoryJob::FILENAME))
                $toCleanDirectories[] = dirname($fileOrDirectory);

        foreach($toCleanDirectories as $directory)
        {
            foreach(FileSystem::getDirectoryContent($directory) as $fileOrDirectory)
            {
                if(!str_ends_with($fileOrDirectory, AutoCleanDirectoryJob::FILENAME) && is_file($fileOrDirectory))
                {
                    $this->addResult("Deleted: ". $fileOrDirectory);
                    unlink($fileOrDirectory);
                }
            }
        }

        return true;
    }
}