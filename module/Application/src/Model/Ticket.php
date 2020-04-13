<?php

namespace Application\Model;

use Core\Model\CoreModelTrait;

class Ticket
{
    use CoreModelTrait;

    const LOW = 0;
    const MEDIUM = 1;
    const HIGH = 2;

    public $id;
    public $name;
    public $description;
    public $priority;
    public $created_at;
    public $user;

    public static function getPriorityDescription()
    {
        return [
            self::LOW => 'Baixo',
            self::MEDIUM => 'Médio',
            self::HIGH => 'Alto',
        ];
    }

    public static function getPriority($priority)
    {
        switch ($priority) {
            case self::LOW:
                return 'Baixo';
                break;
            case self::MEDIUM:
                return 'Médio';
                break;
            case self::HIGH:
                return 'Alto';
                break;
        }
    }
}