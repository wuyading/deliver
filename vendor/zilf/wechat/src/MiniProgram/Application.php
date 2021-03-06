<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChat\MiniProgram;

use EasyWeChat\BasicService;
use EasyWeChat\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \EasyWeChat\MiniProgram\Auth\AccessToken            $access_token
 * @property \EasyWeChat\MiniProgram\DataCube\Client             $data_cube
 * @property \EasyWeChat\MiniProgram\AppCode\Client              $app_code
 * @property \EasyWeChat\MiniProgram\Auth\Client                 $auth
 * @property \EasyWeChat\OfficialAccount\Server\Guard            $server
 * @property \EasyWeChat\MiniProgram\Encryptor                   $encryptor
 * @property \EasyWeChat\MiniProgram\TemplateMessage\Client      $template_message
 * @property \EasyWeChat\OfficialAccount\CustomerService\Client  $customer_service
 * @property \EasyWeChat\BasicService\Media\Client               $media
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        // Base services
        BasicService\Media\ServiceProvider::class,
    ];
}
