<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 21/02/2019
 * Time: 00:56
 */

namespace Core\Model;

use Zend\Hydrator\Reflection;

trait CoreModelTrait
{
    public function exchangeArray(array $data){
        (new Reflection())->hydrate($data, $this);
    }

    public function getArrayCopy(){
        return (new Reflection())->extract($this);
    }
}