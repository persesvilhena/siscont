<?php

namespace Cont\Form\Filter;

use Cont\Model\Movimentacao;
use Zend\Filter\File\RenameUpload;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\MimeType;
use Zend\Validator\File\Size;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class MovimentacaoFilter extends InputFilter
{
    public function __construct()
    {
        $name = new Input('valor');
        $name->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $name->getValidatorChain()->addValidator(new NotEmpty())
            ->addValidator(new StringLength(['max' => 85]));
        $this->add($name);

        $description = new Input('descricao');
        $description->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $description->getValidatorChain()->addValidator(new NotEmpty());
        $this->add($description);

        $data = new Input('data');
        $data->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $data->getValidatorChain()->addValidator(new NotEmpty());
        $this->add($data);

        $priority = new Input('status');
        $priority->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $priority->getValidatorChain()->addValidator(new NotEmpty())
            ->addValidator(new InArray([
                'haystack' => array_keys(Movimentacao::getStatusDescription())
            ]));
        $this->add($priority);

        $grupo = new Input('grupo');
        $grupo->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $grupo->getValidatorChain()->addValidator(new NotEmpty())
            ->addValidator(new InArray([
                'haystack' => array_keys(Movimentacao::getGrupoDescription())
            ]));
        $this->add($grupo);


        /*$attachment = new FileInput('attachment');
        $attachment->setRequired(false);
        $attachment->getValidatorChain()->addValidator(new Size(['max' => '5MB']));
        $attachment->getValidatorChain()->addValidator(new MimeType(['image/jpeg', 'image/png']));
        $attachment->getFilterChain()->attach(new RenameUpload([
            'target' => __DIR__.'/../../../../../public/upload',
            'use_upload_name'      => false,
            'use_upload_extension' => true,
            'overwrite'            => true,
            'randomize'            => true,
        ]));
        $this->add($attachment);*/
    }
}