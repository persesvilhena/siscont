<?php

namespace Application\Model;

use Core\Model\CoreModelTrait;

class Attachment
{
    use CoreModelTrait;

    public $id;
    public $name;
    public $file;
    public $ticket;
}