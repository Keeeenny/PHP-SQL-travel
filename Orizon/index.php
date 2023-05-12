<?php

$isEditing = false;

require 'vendor/autoload.php';

require 'core/bootstrap.php';

Router::load('routes.php')

    ->direct(Request::uri(), Request::method());
