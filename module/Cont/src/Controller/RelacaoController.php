<?php

namespace Cont\Controller;

use Cont\Model\MovimentacaoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RelacaoController extends AbstractActionController
{
    private $ticketTable;

    public function __construct(MovimentacaoTable $ticketTable)
    {
        $this->ticketTable = $ticketTable;
    }

    public function indexAction()
    {
        //$this->layout()->setTemplate('layout/empty');
        echo "teste";
        /*$paginator = $this->ticketTable->findAll([
            'cont.grupo' => $this->identity()->id
        ], true);*/

        $paginator = $this->ticketTable->findAll([], true);

        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        $paginator->setItemCountPerPage(100);



        //echo "<pre>";
        //var_dump();
        //echo "</pre>";
        $tot_gasto = 0;
        $tot_pago = 0;
        $tot = $this->ticketTable->findAll([], false);
        foreach ( $tot as $n){
            if($n->status == 1){
                $tot_gasto = $tot_gasto + $n->valor;
            }else{
                $tot_pago = $tot_pago + $n->valor;
            }
        }

        return new ViewModel(['paginator' => $paginator, 'tot_gasto' => $tot_gasto, 'tot_pago' => $tot_pago]);
    }
}
