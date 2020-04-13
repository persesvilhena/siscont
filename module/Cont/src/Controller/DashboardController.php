<?php

namespace Cont\Controller;

use Cont\Model\MovimentacaoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;

class DashboardController extends AbstractActionController
{
    private $ticketTable;
    public $meses;

    public function __construct(MovimentacaoTable $ticketTable)
    {
        $this->ticketTable = $ticketTable;
    }

    public function indexAction()
    {
        /*$paginator = $this->ticketTable->findAll([
            'cont.grupo' => $this->identity()->id
        ], true);*/

        $paginator = $this->ticketTable->findAll([], true);

        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        $paginator->setItemCountPerPage(100);

        $meses = $this->ticketTable->RetornaMeses();
        /*foreach ($meses as $n) {
            var_dump($n);
        }*/
        //echo "<pre>";
        $mes = array();
        if ($meses instanceof ResultInterface && $meses->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($meses);

            foreach ($resultSet as $row) {
                //var_dump($row['meses']);
                array_push($mes, $row['meses']);
            }
            //echo "teste";
        }
        //var_dump($mes);

        //var_dump($resre);
        //var_dump($this->ticketTable->RetornaMeses());
        //echo "</pre>";
        $tot_gasto[0] = 0;
        $tot_gasto[1] = 0;
        $tot_gasto[2] = 0;
        $tot_gasto[3] = 0;
        $tot_gasto[4] = 0;
        $tot_pago[0] = 0;
        $tot_pago[1] = 0;
        $tot_pago[2] = 0;
        $tot_pago[3] = 0;
        $tot_pago[4] = 0;

        $tot = $this->ticketTable->findAll([], false);
        foreach ( $tot as $n){
            if($n->status == 1){
                $tot_gasto[$n->grupo] = $tot_gasto[$n->grupo] + $n->valor;
            }else{
                $tot_pago[$n->grupo] = $tot_pago[$n->grupo] + $n->valor;
            }
        }
        $tot_dif[0] = round(($tot_pago[0] - $tot_gasto[0]), 2);
        $tot_dif[1] = round(($tot_pago[1] - $tot_gasto[1]), 2);
        $tot_dif[2] = round(($tot_pago[2] - $tot_gasto[2]), 2);
        $tot_dif[3] = round(($tot_pago[3] - $tot_gasto[3]), 2);
        $tot_dif[4] = round(($tot_pago[4] - $tot_gasto[4]), 2);

        return new ViewModel(
            [
                'paginator' => $paginator,
                'tot_gasto' => $tot_gasto,
                'tot_pago' => $tot_pago,
                'tot_dif' => $tot_dif,
                'meses' => $mes
            ]);
    }
}
