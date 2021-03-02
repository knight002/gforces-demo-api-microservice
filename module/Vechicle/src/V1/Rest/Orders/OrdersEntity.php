<?php

namespace Vechicle\V1\Rest\Orders;

class OrdersEntity
{
    public $id;
    public $uuid;
    public $model_id;
    public $total;
    public $model;

    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getModelId()
    {
        return $this->model_id;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function setModelId($model_id)
    {
        $this->model_id = $model_id;
    }

    public function setTotal($total): void
    {
        $this->total = $total;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function exchangeArray(array $array)
    {
        $this->id = $array['id'];
        $this->uuid = $array['uuid'];
        $this->model_id = $array['model_id'];
        $this->total = $array['total'];
        $this->model = array_intersect_key($array, array_flip(['make', 'model', 'm_uuid']));
    }

    public function getArrayCopy(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'total' => $this->total,
            'model' => $this->model,
        ];
    }
}
