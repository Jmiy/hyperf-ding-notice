<?php

use DingNotice\DingTalk;

use Hyperf\Utils\ApplicationContext;
use DingNotice\Contracts\DingTalkInterface;

if (!function_exists('ding')){

    /**
     * @return bool|DingTalk
     */
    function ding(){

        $container = ApplicationContext::getContainer();
        if (!$container->has(DingTalkInterface::class)) {
            return null;
        }

        $arguments = func_get_args();

        $dingTalk = $container->get(DingTalkInterface::class);

        if (empty($arguments)) {
            return $dingTalk;
        }

        if (is_string($arguments[0])) {
            $robot = $arguments[1] ?? 'default';
            return $dingTalk->with($robot)->text($arguments[0]);
        }

    }
}