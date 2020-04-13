<?php

namespace Application\Form;

use Application\Form\Filter\TicketFilter;
use Application\Model\Ticket;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\File;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class TicketForm extends Form
{
    public function __construct()
    {
        parent::__construct('ticket', []);

        $this->setInputFilter(new TicketFilter());
        $this->setAttributes([
            'method' => 'POST',
            'enctype' => 'multipart/form-data'
        ]);

        $name = new Text('name');
        $name->setLabel('Nome')
            ->setAttributes([
                'class' => 'form-control',
                'maxlength' => 85
            ]);
        $this->add($name);

        $description = new Textarea('description');
        $description->setLabel('Descrição')
            ->setAttributes([
                'class' => 'form-control',
                'cols' => 30,
                'rows' => 10
            ]);
        $this->add($description);

        $priority = new Select('priority');
        $priority->setLabel('Prioridade')
            ->setOptions([
                'value_options' => Ticket::getPriorityDescription()
            ])
            ->setAttributes([
                'class' => 'form-control'
            ]);
        $this->add($priority);

        $attachment = new File('attachment');
        $attachment->setLabel('Arquivos')
            ->setAttribute('multiple', 'multiple');
        $this->add($attachment);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600
            ]
        ]);
        $this->add($csrf);
    }
}