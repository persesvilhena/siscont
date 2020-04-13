<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 26/02/2019
 * Time: 01:56
 */

namespace User\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class NewPasswordFilter extends InputFilter
{

    public function __construct()
    {


        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');
        $email->getValidatorChain()
            ->addValidator(new NotEmpty())
            ->addValidator(new StringLength(['max' => 255]));
        $this->add($email);


    }

}