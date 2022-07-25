<?php

function debug($p = [])
{
    echo '<pre>';
    var_dump($p);
    echo '</pre>';
    exit;
}
