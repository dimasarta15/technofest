<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Facades\Image;
use Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadImage($file, $module, $custName = null)
    {
        if (!empty($custName)) {
            $fileUid = $file->storeAs("public/$module", $custName);
            // if (Storage::disk('public')->exists($fileUid))
        } else {
            $fileUid = $file->store("public/$module");
            $image = Image::make(Storage::disk('public')->get(str_replace('public/', '', $fileUid)));
            $image->fit(415, 415, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::disk('public')->put("$module/small_".basename($fileUid), (string) $image->encode());
        }

        if ($fileUid)
            return $fileUid;

        return $fileUid;
    }

    public function removeImage($file)
    {
        $storage = Storage::disk('public')->exists($file);
        if ($storage) {
            return Storage::disk('public')->delete($file);
        }

        return false;
    }

/*     public function _uploadFiles($request, $data, $type)
    {
        if (!empty($request->foto)) {
            // Insert to Table Images
            foreach ($request->foto as $key => $value) {
                if ($key == 0)
                    $cover = 1;
                else
                    $cover = 0;

                $img = new Images;
                $img->id_parent = $data->id;
                
                if ($type != 'toko')
                    $img->type = 'produk';
                else 
                    $img->type = 'toko';
                
                $gambar = $value->store('/'.$type, 'public');
                $img->foto = pathinfo($gambar)['basename'];
                $img->cover = $cover;

                $img->save();
            }
        }
    } */
}
