<?php

namespace Vechicle\V1\Rest\Orders;

/**
 *
 * @author lukasz
 */
interface RestApiGeneralInterface
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create(\stdClass $data);

    /**
     * Delete a resource
     *
     * @param  string $id Id of a document
     * @return mixed
     */
    public function delete(string $id);

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return mixed
     */
    public function deleteList($data);

    /**
     * Fetch a resource
     *
     * @param  string $id Id of a document
     * @return mixed
     */
    public function fetch(string $id);

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return mixed
     */
    public function fetchAll($params = []);

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  string $id Id of a document
     * @param  \stdClass $data
     * @return mixed
     */
    public function patch(string $id, \stdClass $data);

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return null|array
     */
    public function patchList($data): ?array;

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return mixed
     */
    public function replaceList($data);

    /**
     * Update a resource
     *
     * @param  string $id Id of a document
     * @param  mixed $data
     * @return mixed
     */
    public function update(string $id, $data);
}
