<?php

namespace Vechicle\V1\Rest\Orders;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Paginator\Adapter\DbSelect;
use stdClass;

/**
 * Description of OrdersTableGateway
 *
 * @author lukasz
 */
class OrdersTableGateway extends TableGateway implements RestApiGeneralInterface
{
    public function patch(string $id, \stdClass $data)
    {
        $table = $this->getTable();
        $ordersTable = new TableGateway($table, $this->getAdapter(), new RowGatewayFeature('id'));
        $results = $ordersTable->select(['uuid' => $id]);

        if ($results->count() === 0) {
            return new ApiProblem(404, 'Order not found');
        }

        //update order
        $order = $results->current();
        $order->total = $data->total;
        $order->save();

        //set the vechicle
        $modelsTable = new TableGateway('models', $this->getAdapter(), new RowGatewayFeature('id'));
        $sel = [
            'make' => $data->model['make'],
            'model' => $data->model['model'],
        ];
        $results = $modelsTable->select($sel);

        if ($results->count() === 0) {    //no model found
            $sel['uuid'] = $this->getUuid();
            $rs = $modelsTable->insert($sel);
            $liid = $modelsTable->getLastInsertValue();

            $order->model_id = $liid;
            $order->save();
        } else {
            $model = $results->current();
            $model->make = $data->model['make'];
            $model->model = $data->model['model'];
            $model->save();

            $order->model_id = $model->id;
            $order->save();
        }

        return $order->toArray();
    }

    public function fetch($id)
    {
        $table = $this->getTable();
        $select = $this->getSql()->select();
        $modelsFields = ['m_uuid' => 'uuid', 'make', 'model'];
        $select
            ->columns(['uuid', 'model_id', 'total'])
            ->join(['m' => 'models'], $table . '.model_id = m.id', $modelsFields, Select::JOIN_LEFT)
            ->where(['orders.uuid' => $id]);
        $rs = $this->selectWith($select);
        return $rs;
    }

    public function create(stdClass $data)
    {
        $table = $this->getTable();

        $insert = $this->getSql()->insert();
        $insert->columns(['uuid', 'model_id']);

        $data->uuid = $data->uuid ?? $this->getUuid();
        $insert->values((array) $data);
        $cnt = $this->executeInsert($insert);
        if ($cnt) {
            $liid = $this->adapter->getDriver()->getLastGeneratedValue();
            $results = $this->select(['id' => $liid]);

            $current = $results->current();
            return $current;
        }
    }

    public function replaceList($data): mixed
    {
        return new ApiProblem(405, 'Not implemented');
    }

    public function fetchAll($params = []): mixed
    {
        return new ApiProblem(405, 'Not implemented');
    }

    public function patchList($data): ?array
    {
        return new ApiProblem(405, 'Not implemented');
    }

    public function deleteList($data): mixed
    {
        return new ApiProblem(405, 'Not implemented');
    }

    private function getUuid()
    {
        $curr = $this->getAdapter()->getDriver()->createStatement('SELECT UUID() AS uuid;')->execute()->current();
        return $curr['uuid'];
    }
}
