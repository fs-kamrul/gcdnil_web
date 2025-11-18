<?php

namespace Modules\KamrulDashboard\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;
//use League\Flysystem\UnableToRetrieveMetadata;
use Mimey\MimeTypes;
use DboardMedia;
//use Storage;

class UploadsManager
{
    /**
     * @var MimeTypes
     */
    protected $mimeType;

    public function __construct(MimeTypes $mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function fileDetails(string $path): array
    {
        return [
            'filename' => File::basename($path),
            'url' => $path,
            'mime_type' => $this->fileMimeType($path),
            'size' => $this->fileSize($path),
            'modified' => $this->fileModified($path),
        ];
    }

    public function fileMimeType(string $path): ?string
    {
        if (File::extension($path) == 'jfif') {
            return 'image/jpeg';
        }

        return $this->mimeType->getMimeType(File::extension(DboardMedia::getRealPath($path)));
    }

    public function fileSize(string $path): int
    {
        try {
            return Storage::size($path);
        } catch (UnableToRetrieveMetadata) {
            return 0;
        }
    }

    public function fileModified(string $path): string
    {
        return Carbon::createFromTimestamp(Storage::lastModified($path));
    }

    public function createDirectory(string $folder)
    {
        $folder = $this->cleanFolder($folder);

        if (Storage::exists($folder)) {
            return trans('media::media.folder_exists', compact('folder'));
        }

        return Storage::makeDirectory($folder);
    }

    protected function cleanFolder(string $folder): string
    {
        return DIRECTORY_SEPARATOR . trim(str_replace('..', '', $folder), DIRECTORY_SEPARATOR);
    }

    public function deleteDirectory(string $folder): bool|string
    {
        $folder = $this->cleanFolder($folder);

        $filesFolders = array_merge(Storage::directories($folder), Storage::files($folder));

        if (! empty($filesFolders)) {
            return trans('media::media.directory_must_empty');
        }

        return Storage::deleteDirectory($folder);
    }

    public function deleteFile(string $path): bool
    {
        $path = $this->cleanFolder($path);

        return Storage::delete($path);
    }

    public function saveFile(
        string $path,
        string $content,
        UploadedFile $file = null,
        array $visibility = ['visibility' => 'public']
    ): bool {
        if (! DboardMedia::isChunkUploadEnabled() || ! $file) {
            $data = Storage::put($this->cleanFolder($path), $content, $visibility);
            return $data;
        }

        $currentChunksPath = DboardMedia::getConfig('chunk.storage.chunks') . '/' . $file->getFilename();
        $disk = Storage::disk(DboardMedia::getConfig('chunk.storage.disk'));

        try {
            $stream = $disk->getDriver()->readStream($currentChunksPath);
            if ($result = Storage::writeStream($path, $stream, $visibility)) {
                $disk->delete($currentChunksPath);
            }
        } catch (Exception $exception) {
            return Storage::put($this->cleanFolder($path), $content, $visibility);
        }
        return $result;
    }
}
