<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 21:30
 */

namespace Auth\Form;


use Auth\Form\Filter\LoginFilter;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login', []);

        $this->setInputFilter(new LoginFilter()); // chama o filtro do form

        $this->setAttributes(['method' => 'POST']);

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'E-mail',
            'class' => 'form-control',
            'maxlength' => 255

        ]);
        $this->add($email);

        $password = new Password('password');
        $password->setAttributes([
            'placeholder' => 'Password',
            'class' => 'form-control',
            'maxlength' => 48

        ]);
        $this->add($password);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600
            ]
        ]);
        $this->add($csrf);
    }
}