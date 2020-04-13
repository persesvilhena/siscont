<?php

namespace Cont\Controller;

use Cont\Model\Movimentacao;
use Exception;
use Cont\Form\MovimentacaoForm;
use Cont\Model\MovimentacaoTable;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element\Csrf;
use Zend\View\Model\ViewModel;

class MovimentacaoController extends AbstractActionController
{
    private $movimentacaoTable;

    public function __construct(MovimentacaoTable $movimentacaoTable)
    {
        $this->movimentacaoTable = $movimentacaoTable;
    }


    public function plustAction(){
        echo 'teste';
    }

    public function plusAction()
    {
        $form = new MovimentacaoForm();

        if ($this->getRequest()->isPost()) {
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $post['valor'] = str_replace(',', '.', $post['valor']);
            /*echo "<pre>";
            var_dump($post);
            echo "</pre>";*/
            $form->setData($post);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    //$data['user'] = $this->identity()->id;

                    $this->movimentacaoTable->save($data);

                    $this->flashMessenger()->addSuccessMessage('Ticket criado com sucesso');

                } catch (Exception $exception) {
                    $this->flashMessenger()->addErrorMessage($exception->getMessage());
                }

                return $this->redirect()->refresh();
            }
        }

        return new ViewModel([
            'form' => $form->prepare()
        ]);
    }






    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        try {
            //echo $id;
            /**
             * @var $ticket Movimentacao
             */
            $ticket = $this->movimentacaoTable->getBy(['id' => $id]);

            $form = new MovimentacaoForm();

            $form->setAttribute('action', $this->url()->fromRoute('cont.lanc', [
                'action' => 'edit',
                'id' => $ticket->id
            ]));

            $form->setData($ticket->getArrayCopy());

            if ($this->getRequest()->isPost()) {
                $post = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    $this->getRequest()->getFiles()->toArray()
                );

                $form->setData($post);

                if ($form->isValid()) {
                    $data = $form->getData();

                    try {
                        $data['id'] = $ticket->id;
                        $this->movimentacaoTable->save($data);
                        $this->flashMessenger()->addSuccessMessage('Ticket editado com sucesso');
                    } catch (Exception $exception) {
                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                    }

                    return $this->redirect()->refresh();
                }
            }

            return new ViewModel([
                'form' => $form->prepare()
            ]);

        }catch (Exception $exception) {
            $this->flashMessenger()->addErrorMessage('Registro não encontrado');
        }

        //return $this->redirect()->toRoute('cont.dash');
    }





    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        try {
            /**
             * @var $ticket Ticket
             */
            $ticket = $this->movimentacaoTable->getBy(['id' => $id]);
            $form = new Form();
            $csrf = new Csrf('csrf');
            $csrf->setOptions([
                'csrf_options' => [
                    'timeout' => 600
                ]
            ]);
            $form->add($csrf);

            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost());
                if ($form->isValid()) {
                    try {
                        //$this->attachmentTable->deleteAttachments($ticket->id);
                        $this->movimentacaoTable->delete($ticket->id);
                        $this->flashMessenger()->addSuccessMessage('Ticket removido com sucesso');
                        return $this->redirect()->toRoute('cont.dash');
                    } catch (Exception $exception) {
                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                        return $this->redirect()->toRoute('cont.dash');
                    }
                }
            }

            return new ViewModel([
                'movimentacao' => $ticket,
                'form' => $form->prepare()
            ]);
        } catch (Exception $exception) {
            $this->flashMessenger()->addErrorMessage($exception->getMessage());
            return $this->redirect()->toRoute('cont.dash');
        }
    }
}
