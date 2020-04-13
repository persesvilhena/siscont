<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 21:15
 */

namespace Auth;


class Module
{
    public function getConfig(){
        return include __DIR__.'/../config/module.config.php';
    }

}