<?php

namespace Application\Controller;

use Application\Model\TicketTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DashboardController extends AbstractActionController
{
    private $ticketTable;

    public function __construct(TicketTable $ticketTable)
    {
        $this->ticketTable = $ticketTable;
    }

    public function indexAction()
    {
        $paginator = $this->ticketTable->findAll([
            'user' => $this->identity()->id
        ], true);

        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        $paginator->setItemCountPerPage(10);

        return new ViewModel(['paginator' => $paginator]);
    }
}
