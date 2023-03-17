<?php

/**
 * Created by PhpStorm.
 * User: LinFei
 * Created time 2022/10/10 10:57:15
 * E-mail: fly@eyabc.cn
 */
declare (strict_types=1);

return [
    // 注解扫描路径
    'include_paths' => [
        // 应用目录
        'app',
    ],
    // 扫描排除的路径 支持通配符: *
    'exclude_paths' => [
        'app/model',
    ],
    // 路由设置
    'route' => [
        // 如果注解路由 @Route() 未传参则默认使用方法名作为path
        'use_default_method' => false,
    ],
];
