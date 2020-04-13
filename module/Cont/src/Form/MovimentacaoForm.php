<?php

namespace Cont\Form;

use Cont\Form\Filter\MovimentacaoFilter;
use Cont\Model\Movimentacao;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Date;
use Zend\Form\Element\DateSelect;
use Zend\Form\Element\File;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class MovimentacaoForm extends Form
{
    public function __construct()
    {
        parent::__construct('movimentacao', []);

        $this->setInputFilter(new MovimentacaoFilter());
        $this->setAttributes([
            'method' => 'POST',
            'enctype' => 'multipart/form-data'
        ]);

        $name = new Text('valor');
        $name->setLabel('Valor')
            ->setAttributes([
                'class' => 'form-control',
                'maxlength' => 85
            ]);
        $this->add($name);

        $description = new Textarea('descricao');
        $description->setLabel('Descrição')
            ->setAttributes([
                'class' => 'form-control',
                'cols' => 30,
                'rows' => 10
            ]);
        $this->add($description);

        $data = new DateSelect('data');
        $data->setLabel('Data')
            ->setAttributes([
                'type' => 'date',
                'class' => 'form-control',
                'style' => 'line-height: 16px;',
                'value' => '2019-01-01'
            ]);
        $this->add($data);



        /*$data = new Date('data');
        $data->setLabel('Datapqp');
        $data->setAttributes([
            'min'  => '2012-01-01',
            'max'  => '2020-01-01',
            'step' => '1', // days; default step interval is 1 day
        ]);
        $data->setOptions([
            'format' => 'Y-m-d',
        ]);
        $this->add($data);*/

        /*$this->add([
            'type' => 'email',
            'name' => 'data',
            'options' => [
                'label' => 'Appointment Date',
                'format' => 'Y-m-d',
            ],
            'attributes' => [
                'class' => 'form-control',
                'type' => 'date',
                'min' => '2012-01-01',
                'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
            ],
        ]);*/

        $priority = new Select('status');
        $priority->setLabel('Status')
            ->setOptions([
                'value_options' => Movimentacao::getStatusDescription()
            ])
            ->setAttributes([
                'class' => 'form-control'
            ]);
        $this->add($priority);

        $priority = new Select('grupo');
        $priority->setLabel('Grupo')
            ->setOptions([
                'value_options' => Movimentacao::getGrupoDescription()
            ])
            ->setAttributes([
                'class' => 'form-control'
            ]);
        $this->add($priority);


        /*$attachment = new File('attachment');
        $attachment->setLabel('Arquivos')
            ->setAttribute('multiple', 'multiple');
        $this->add($attachment);*/

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600
            ]
        ]);
        $this->add($csrf);
    }
}