<?php

/**
 * Created by PhpStorm.
 * User: LinFei
 * Created time 2022/10/10 10:52:22
 * E-mail: fly@eyabc.cn
 */
declare (strict_types=1);

namespace LinFly\Annotation\Handle;

use LinFly\Annotation\Bootstrap\AnnotationBootstrap;

if (!AnnotationBootstrap::isIgnoreProcess()) {
    RouteAnnotationHandle::createRoute();
}
