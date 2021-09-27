<?php

namespace DingNotice;

use DingNotice\Contracts\DingTalkInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                DingTalkInterface::class => DingNoticeFactory::class,
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for ding.',
                    'source' => __DIR__ . '/../publish/ding.php',
                    'destination' => BASE_PATH . '/config/autoload/ding.php',
                ],
            ],
        ];
    }

}
