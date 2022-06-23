<?php
/**
 * Created by : PhpStorm
 * Web: https://www.kaadon.com
 * User: ipioo
 * Date: 2022/1/11 00:00
 */
/**
 * 上传文件
 */
//public function upload()
//{
//    if (!request()->isPost()) {
//        return error("当前请求不合法1！");
//    }
//
//    $type = request()->param('type/s',null);
//    if (empty($type)  || !in_array($type,['service','member','merchant'])){
//        $type = 'service';
//    }
//    $data         = [
//        'file' => request()->file('file'),
//    ];
//    $uploadConfig = get_config('upload', 'default');
//    empty($data['upload_type']) && $data['upload_type'] = $uploadConfig['upload_type'];
//    $rule = [
//        'file|文件' => "require|file|fileExt:jpg,jpeg,png,gif|fileSize:{$uploadConfig['upload_allow_size']}",
//    ];
//    try {
//        validate($data, $rule);
//        $upload = Uploadfile::instance()
//            ->setUploadType($data['upload_type'])
//            ->setUploadConfig($uploadConfig)
//            ->setApiClassName($type)
//            ->setFile($data['file'])
//            ->isSave(false)
//            ->save();
//    } catch (\Exception $e) {
//        return error($e->getMessage());
//    }
//    if ($upload['save'] == true) {
//        return success( ['url' => $upload['url']],$upload['msg']);
//    } else {
//        return error($upload['msg']);
//    }
//}
