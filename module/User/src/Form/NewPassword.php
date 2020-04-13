<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 26/02/2019
 * Time: 18:08
 */

namespace User\Form;

use User\Form\Filter\NewPasswordFilter;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Form;

class NewPassword extends Form
{
    public function __construct()
    {
        parent::__construct('new-password', []);

        $this->setInputFilter(new NewPasswordFilter());
        $this->setAttributes(['method' => 'POST']);

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'E-mail',
            'class' => 'form-control',
            'maxlength' => 255

        ]);
        $this->add($email);


        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600
            ]
        ]);
        $this->add($csrf);
    }
}