<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class OauthConfig extends BaseConfig
{
    public array $oauthConfigs = [
        
        'google' => [
                'client_id' => '666214815604-chtc9iedrkrsr31mac4rp9p3qlr8fqpu.apps.googleusercontent.com',
                'client_secret' => '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',
                'allow_login' => true,
            // ...
        ],
    ];
}
