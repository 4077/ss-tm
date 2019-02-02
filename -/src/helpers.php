<?php

function sstm()
{
    return \ss\tm\Svc::getInstance();
}

function sstmc()
{
    $args = func_get_args();

    if ($args) {
        return call_user_func_array([sstm()->moduleRootController, 'c'], $args);
    } else {
        return sstm()->moduleRootController;
    }
}