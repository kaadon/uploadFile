<?php

// +----------------------------------------------------------------------
// | Kaadon
// +----------------------------------------------------------------------
// | PHP交流群: 763822524
// +----------------------------------------------------------------------
// | 开源协议  https://mit-license.org 
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/kaadon/Kaadon
// +----------------------------------------------------------------------

namespace Kaadon\Upload\driver;

use Kaadon\Upload\driver\qnoss\Oss;
use Kaadon\Upload\trigger\SaveDb;

/**
 * 七牛云上传
 * Class Qnoss
 * @package Kaadon\Upload\driver
 */
class Qnoss extends FileBase
{

    /**
     * 重写上传方法
     * @return array
     */
    public function save(): array
    {
        parent::save();
        $upload = Oss::instance($this->uploadConfig)
            ->save($this->completeFilePath, $this->completeFilePath);
        if ($upload['save'] && $this->isSaveTable) {
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