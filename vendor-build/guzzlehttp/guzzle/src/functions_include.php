<?php

namespace ExpressionEngine\Dependency;

// Don't redefine the functions if included multiple times.
if (!\function_exists('ExpressionEngine\\Dependency\\GuzzleHttp\\describe_type')) {
    require __DIR__ . '/functions.php';
}
