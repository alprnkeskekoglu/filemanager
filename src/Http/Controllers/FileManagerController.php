<?php

namespace Dawnstar\FileManager\Http\Controllers;

use Carbon\Carbon;
use Dawnstar\FileManager\Foundation\MediaUpload;
use Dawnstar\FileManager\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends BaseController
{
    public function index(string $type = null, Request $request)
    {
        if(!$request->get('selectableType')) {
            canUser("file_manager.index", false);
        }

        if (is_null($type)) {
            $type = 'all';
        }

        $requestParams = $this->getRequestParams($request);
        $trans = $this->getTransForIndex();

        return view('FileManagerView::pages.filemanager.index', compact('type', 'requestParams', 'trans'));
    }

    public function upload(Request $request)
    {
        $requestParams = $this->getRequestParams($request);
        return view('FileManagerView::pages.filemanager.upload', compact('requestParams'));
    }

    public function uploadFromComputer(Request $request)
    {
        $mediaUpload = new MediaUpload();

        foreach ($request->file('files') as $file) {
            $mediaUpload->fromComputer($file);
        }

        return response()->json(['message' => __('FileManagerLang.upload.success_msg')]);
    }

    public function uploadFromUrl(Request $request)
    {
        $url = $request->get('url');

        if (is_null($url)) {
            throw new \Exception(__('FileManagerLang::upload.errors.invalid_url'));
        }

        $mediaUpload = new MediaUpload();
        $uploadedFile = $mediaUpload->fromUrl($url);

        return response()->json(['message' => __('FileManagerLang.upload.success_msg', ['filename' => $uploadedFile->file_name])]);
    }

    private function getTransForIndex()
    {
        return [
            'file' => __('FileManagerLang::index.file'),
            'date_n_o' => __('FileManagerLang::index.date.new_old'),
            'date_o_n' => __('FileManagerLang::index.date.old_new'),
            'alphabetic_a_z' => __('FileManagerLang::index.alphabetic.a_z'),
            'alphabetic_z_a' => __('FileManagerLang::index.alphabetic.z_a'),
            'size_b_s' => __('FileManagerLang::index.size.big_small'),
            'size_s_b' => __('FileManagerLang::index.size.small_big'),
            'search' => __('FileManagerLang::index.search'),
            'add_files' => __('FileManagerLang::index.add_files'),
        ];
    }

    private function getRequestParams($request)
    {
        $maxMediaCount = $request->get('maxMediaCount') ?: '0';
        $selectableType = $request->get('selectableType');
        $selectedMediaIds = $request->get('selectedMediaIds') ?: '';

        return ['selectableType' => $selectableType, 'maxMediaCount' => $maxMediaCount, 'selectedMediaIds' => $selectedMediaIds];
    }
}
