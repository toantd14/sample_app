<?php

namespace Modules\Api\Repositories;

interface RepositoryInterface
{
    /**
     * Get.
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function get($id);

    /**
     * Get all.
     *
     * @return Collection
     */
    public function all();

    /**
     * Store.
     *
     * @param array $data
     *
     * @return
     */
    public function store($data);

    /**
     * Show.
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function show($id);

    /**
     * Update.
     *
     * @param int $id
     * @param array $data
     *
     * @return Model
     */
    public function update($id, $data);

    /**
     * Delete.
     *
     * @param Collection|array|int $ids
     *
     * @return int
     */
    public function destroy($ids);

    /**
     * Check exist.
     *
     * @param int $id
     *
     * @return boolean
     */
    public function exist($id);

    public function with(array $withModel = ['']);

    public function updateOrCreate($dataCompare, $dataUpdate);
}
