<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 10:49
 */
return [
    'view_replace_str'=>[
        '__ROOT__' => '/',
        '__ADMIN__' => '/static/admin'
    ],
    'dispatch_error_tmpl' => 'public/tips',
    'dispatch_success_tmpl' => 'public/tips',
    'exception_handle'       => '\\app\\admin\\service\\AjaxException',
    'url_common_param'=>true,

];