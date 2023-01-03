<?php

// +----------------------------------------------------------------------
// | Kaadon
// +----------------------------------------------------------------------
// | 开发交流: https://developer.kaadon.com
// +----------------------------------------------------------------------
// | 开源协议  https://mit-license.org 
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/kaadon
// +----------------------------------------------------------------------

namespace Kaadon\UploadFile\driver;

use Kaadon\UploadFile\FileBase;
use Kaadon\UploadFile\driver\txcos\Cos;
use Kaadon\UploadFile\trigger\SaveDb;

/**
 * 腾讯云上传
 * Class Txcos
 * @package Kaadon\UploadFile\driver
 */
class Txcos extends FileBase
{

    /**
     * 重写上传方法
     * @return array|void
     */
    public function save()
    {
        parent::save();
        $upload = Cos::instance($this->uploadConfig)
            ->save($this->completeFilePath, $this->completeFilePath);
        if ($upload['save'] == true && $this->isSaveTable == true) {
            SaveDb::trigger($this->tableName, [
                'upload_type'   => $this->uploadType,
                'original_name' => $this->file->getOriginalName(),
                'mime_type'     => $this->file->getOriginalMime(),
                'file_ext'      => strtolower($this->file->getOriginalExtension()),
                'url'           => $upload['url'],
                'create_time'   => time(),
            ]);
        }
        $this->rmLocalSave();
        return $upload;
    }

}