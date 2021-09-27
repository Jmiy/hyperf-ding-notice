<?php
/**
 * Created by PhpStorm.
 * User: Jmiy
 * Date: 2021-09-27
 * Time: 10:50
 */

namespace DingNotice\Contracts;


interface HttpClientInterface
{
    public function send($params): array;
}
