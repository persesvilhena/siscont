<?php

namespace Auth\Authentication;

use User\Model\UserTable;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;

class Adapter implements AdapterInterface
{
    protected $email;
    protected $password;
    private $userTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate()
    {

        /**
         * @var $user \User\Model\User
         */
        if ($user = $this->userTable->getUserByEmail($this->email)) {
            if ($user->email_confirmed != 1) {
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
                    'Você ainda não validou seu cadastro, verifique seu email para validar.'
                ]);
            }

            if ($user->token != null) {
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
                    'Parece que alguem tentou recuperar a sua senha.
                    Para a sua segurança verifique seu email e crie uma nova senha.'
                ]);
            }

            $bcrypt = new Bcrypt();
            if ($bcrypt->verify($this->password, $user->password)) {
                return new Result(Result::SUCCESS, $user);
            }
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
            'Login ou senha inválido!'
        ]);
    }
}