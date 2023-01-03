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

namespace Kaadon\UploadFile\trigger;


use think\facade\Db;

/**
 * 保存到数据库
 * Class SaveDb
 * @package Kaadon\UploadFile\trigger
 */
class SaveDb
{

    /**
     * 保存上传文件
     * @param $tableName
     * @param $data
     */
    public static function trigger($tableName, $data)
    {
        if (isset($data['original_name'])) {
            $data['original_name'] = htmlspecialchars($data['original_name'], ENT_QUOTES);
        }
        Db::name($tableName)->save($data);
    }

}