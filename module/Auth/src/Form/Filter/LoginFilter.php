<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 21:34
 */

namespace Auth\Form\Filter;


use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class LoginFilter extends InputFilter
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


        $password = new Input('password');
        $password->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');
        $password->getValidatorChain()
            ->addValidator(new NotEmpty())
            ->addValidator(new StringLength(['max' => 48, 'min' => 5]));
        $this->add($password);
    }
}