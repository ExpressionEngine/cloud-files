<?php

namespace ExpressionEngine\Dependency;

// Don't redefine the functions if included multiple times.
if (!\function_exists('ExpressionEngine\\Dependency\\GuzzleHttp\\Promise\\promise_for')) {
    require __DIR__ . '/functions.php';
}
