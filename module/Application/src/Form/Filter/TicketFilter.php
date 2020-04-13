<?php

namespace Application\Form\Filter;

use Application\Model\Ticket;
use Zend\Filter\File\RenameUpload;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\MimeType;
use Zend\Validator\File\Size;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class TicketFilter extends InputFilter
{
    public function __construct()
    {
        $name = new Input('name');
        $name->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $name->getValidatorChain()->addValidator(new NotEmpty())
            ->addValidator(new StringLength(['max' => 85]));
        $this->add($name);

        $description = new Input('description');
        $description->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $description->getValidatorChain()->addValidator(new NotEmpty());
        $this->add($description);

        $priority = new Input('priority');
        $priority->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $priority->getValidatorChain()->addValidator(new NotEmpty())
            ->addValidator(new InArray([
                'haystack' => array_keys(Ticket::getPriorityDescription())
            ]));
        $this->add($priority);

        $attachment = new FileInput('attachment');
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
        $this->add($attachment);
    }
}