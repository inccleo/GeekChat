<?php

/**
 * Here is your custom functions.
 */
function getUserId(string $token): string
{
    return (string)\support\Redis::hGet('openids', $token);
}