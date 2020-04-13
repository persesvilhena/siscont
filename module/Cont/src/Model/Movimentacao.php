<?php

namespace Cont\Model;

use Core\Model\CoreModelTrait;

class Movimentacao
{
    use CoreModelTrait;

    const CRE = 0;
    const DEB = 1;

    public $id;
    public $valor;
    public $status;
    public $grupo;
    public $data;
    public $descricao;

    public static function getStatusDescription()
    {
        return [
            self::CRE => 'Crédito',
            self::DEB => 'Débito'
        ];
    }

    public static function getStatus($priority)
    {
        switch ($priority) {
            case self::CRE:
                return 'Crédito';
                break;
            case self::DEB:
                return 'Débito';
                break;
        }
    }


    public static function getGrupoDescription()
    {
        return [
            0 => 'Meu',
            1 => 'Mamae',
            2 => 'Pacoka',
            3 => 'Maurao',
            4 => 'Gordinho'
        ];
    }

    public static function getGrupo($priority)
    {
        switch ($priority) {
            case 0:
                return 'Meu';
                break;
            case 1:
                return 'Mamae';
                break;
            case 2:
                return 'Pacoka';
                break;
            case 3:
                return 'Maurao';
                break;
            case 4:
                return 'Gordinho';
                break;
        }
    }
}