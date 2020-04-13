<?php

namespace Cont\Model;

use Core\Model\AbstractCoreModelTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class MovimentacaoTable extends AbstractCoreModelTable
{
    public function findAll(array $params, $paginated = false)
    {
        if ($paginated) {
            return $this->fetchPaginatedResults($params);
        }

        return $this->tableGateway->select($params);
    }

    private function fetchPaginatedResults(array $params)
    {
        // Create a new Select object for the table:
        $select = new Select($this->tableGateway->getTable());
        //$select->join(['u' => 'users'], 'u.id = user', [], Select::JOIN_LEFT)
           // ->where($params);

        $select->where($params);
        $select->order('data');


        // Create a new result set based on the Album entity:
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Movimentacao());

        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
        // our configured select object:
            $select,
            // the adapter to run it against:
            $this->tableGateway->getAdapter(),
            // the result set to hydrate:
            $resultSetPrototype
        );


        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function RetornaMeses(){
        $statement = $this->tableGateway->getAdapter()->createStatement('select left(data, 7) as meses from cont group by year(data), month(data)');
        $statement->prepare();
        $result = $statement->execute();
        return $result;
    }

    public function RetornaMeses2()
    {
        //$id  = (int) $id;

        $rowset = $this->tableGateway->select(function (Sql\Select $select)// use ($id)
        {
            //$select->where
                //->AND->NEST->equalTo('candidate_id', $id)
                //->AND->equalTo('qualification_category', 'Educational');
        });

        return $rowset;
    }
}