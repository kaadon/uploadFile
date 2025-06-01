<?php

// +----------------------------------------------------------------------
// | Kaadon
// +----------------------------------------------------------------------
// | 开源协议  https://mit-license.org 
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/kaadon/Kaadon
// +----------------------------------------------------------------------

namespace Kaadon\Upload;

use Kaadon\Upload\driver\Alioss;
use Kaadon\Upload\driver\Local;
use Kaadon\Upload\driver\qnoss;
use Kaadon\Upload\driver\Txcos;

/**
 * 上传组件
 * Class UploadFile
 * @package Kaadon\Upload
 */
class UploadFile
{
    /**
     * 当前实例对象
     * @var object
     */
    protected static $instance;

    /**
     * 上传方式
     * @var string
     */
    protected $uploadType = 'local';
    /**
     * 上传方式
     * @var string
     */
    protected $apiClassName = 'admin';

    /**
     * 上传配置文件
     * @var array
     */
    protected $uploadConfig;

    /**
     * 需要上传的文件对象
     */
    protected $file;
    /**
     * 是否需要保存
     */
    protected $save = true;

    /**
     * 保存上传文件的数据表
     * @var string
     */
    protected $tableName = 'system_uploadfile';

    /**
     * 获取对象实例
     * @return Uploadfile|object
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 设置上传对象
     * @param $value
     */
    public function setFile($value)
    {
        $this->file = $value;
    }
    /**
     * 设置上传对象
     * @param $value
     */
    public function setApiClassName($value)
    {
        $this->apiClassName = $value;
    }

    /**
     * 设置上传对象
     * @param bool $value
     */
    public function isSave(bool $value = true)
    {
        $this->save = $value;
    }

    /**
     * 设置上传文件
     * @param $value
     */
    public function setUploadConfig($value)
    {
        $this->uploadConfig = $value;
    }

    /**
     * 设置上传方式
     * @param $value
     */
    public function setUploadType($value)
    {
        $this->uploadType = $value;
    }

    /**
     * 设置保存数据表
     * @param $value
     */
    public function setTableName($value)
    {
        $this->tableName = $value;
    }

    /**
     * 保存文件
     * @return array
     */
    public function save(): array
    {
        $obj = null;
        if ($this->uploadType == 'local') {
            $obj = new Local();
        } elseif ($this->uploadType == 'alioss') {
            $obj = new Alioss();
        } elseif ($this->uploadType == 'qnoss') {
            $obj = new Qnoss();
        } elseif ($this->uploadType == 'txcos') {
            $obj = new Txcos();
        }
        $obj->setUploadConfig($this->uploadConfig)
            ->setUploadType($this->uploadType)
            ->setTableName($this->tableName)
            ->setFile($this->file)
            ->setApiClassPath($this->apiClassName)
            ->setIsSaveTable($this->save);
        if ($this->uploadType == 'local' && !empty($this->uploadConfig['local_domain'])) {
            $obj->setStaticDomain('//' . $this->uploadConfig['local_domain']);
        }
        return $obj->save();
    }
}