<?php

require dirname(__DIR__) . '/lib/op.php';
require dirname(__DIR__) . '/lib/parsedown.php';
require dirname(__DIR__) . '/app/extend.php';
require dirname(__DIR__) . '/app/config.php';
require dirname(__DIR__) . '/app/filter.php';
require dirname(__DIR__) . '/app/event.php';
require dirname(__DIR__) . '/app/route.php';

op::run();