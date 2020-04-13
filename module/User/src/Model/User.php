<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 22/02/2019
 * Time: 15:34
 */

namespace User\Model;

use Core\Model\CoreModelTrait;

class User
{
    use CoreModelTrait;

    public $id;
    public $name;
    public $email;
    public $password;
    public $token;
    public $email_confirmed;

}