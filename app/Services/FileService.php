<?php

namespace App\Services;

class FileService
{
    public function handleUploadedFile($model, $file, string $path)
    {
        if (!is_null($file)) {
            if ($model->getMedia()) {
                $model->clearMediaCollectionExcept($path, $model->getFirstMedia()); // This will remove all associated media in the 'files' collection except the first media
            }

            if (filter_var($file, FILTER_VALIDATE_URL)) {
                $model->addMediaFromUrl($file)->toMediaCollection($path);
            }
           $model->addMedia($file)->toMediaCollection($path);
           ///inserted lang
           $this->fileService->handleUploadedFile($p_c_f_request, $request->file('pcf_rfq'), 'pcf_approved_pdf');
        }
    }

    public function handleUploadedFiles($model, $files, string $path): void
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                if (filter_var($file, FILTER_VALIDATE_URL)) {
                    $model->addMediaFromUrl($file)->toMediaCollection($path);
                } else {
                    $model->addMedia($file)->toMediaCollection($path);
                }
            }
        }
    }
}