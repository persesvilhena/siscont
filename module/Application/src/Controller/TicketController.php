<?php

namespace Application\Controller;

use Application\Model\Ticket;
use Exception;
use Application\Form\TicketForm;
use Application\Model\AttachmentTable;
use Application\Model\TicketTable;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element\Csrf;
use Zend\View\Model\ViewModel;

class TicketController extends AbstractActionController
{
    private $ticketTable;
    private $attachmentTable;

    public function __construct(TicketTable $ticketTable, AttachmentTable $attachmentTable)
    {
        $this->ticketTable = $ticketTable;
        $this->attachmentTable = $attachmentTable;
    }

    public function plusAction()
    {
        $form = new TicketForm();

        if ($this->getRequest()->isPost()) {
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $data['user'] = $this->identity()->id;

                    $ticket = $this->ticketTable->save($data);
                    $this->attachmentTable->saveAttachments($data, $ticket);

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
            /**
             * @var $ticket Ticket
             */
            $ticket = $this->ticketTable->getBy(['id' => $id]);

            $form = new TicketForm();
            $form->setAttribute('action', $this->url()->fromRoute('ticket', [
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
                        $ticket = $this->ticketTable->save($data);
                        $this->attachmentTable->saveAttachments($data, $ticket);
                        $this->flashMessenger()->addSuccessMessage('Ticket editado com sucesso');
                    } catch (Exception $exception) {
                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                    }

                    return $this->redirect()->refresh();
                }
            }

            return new ViewModel([
                'form' => $form->prepare(),
                'attachments' => $this->attachmentTable->findAll(['ticket' => $ticket->id])
            ]);

        }catch (Exception $exception) {
            $this->flashMessenger()->addErrorMessage('Registro não encontrado');
        }

        return $this->redirect()->toRoute('dashboard');
    }





    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        try {
            /**
             * @var $ticket Ticket
             */
            $ticket = $this->ticketTable->getBy(['id' => $id]);
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
                        $this->attachmentTable->deleteAttachments($ticket->id);
                        $this->ticketTable->delete($ticket->id);
                        $this->flashMessenger()->addSuccessMessage('Ticket removido com sucesso');
                        return $this->redirect()->toRoute('dashboard');
                    } catch (Exception $exception) {
                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                        return $this->redirect()->toRoute('dashboard');
                    }
                }
            }

            return new ViewModel([
                'ticket' => $ticket,
                'form' => $form->prepare()
            ]);
        } catch (Exception $exception) {
            $this->flashMessenger()->addErrorMessage($exception->getMessage());
            return $this->redirect()->toRoute('dashboard');
        }
    }
}
