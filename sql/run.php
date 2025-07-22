<?php

foreach (glob(__DIR__. "/runs/*.php") as $file) {
   require $file;
}