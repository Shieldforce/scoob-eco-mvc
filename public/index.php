<?php

require __DIR__ . '/../vendor/autoload.php';

use ScoobEcoCore\Boot\Start;

ini_set('display_errors', 0);
error_reporting(E_ALL);

new Start();