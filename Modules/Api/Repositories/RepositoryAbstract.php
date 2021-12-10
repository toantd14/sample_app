<?php

namespace Modules\Api\Repositories;

abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * @var string Model name
     */
    protected $model;

    /**
     * @var string Table name
     */
    protected $table;

    /**
     * @var array Validation rules for store
     */
    protected $storeRules;

    /**
     * @var array Validation rules for update
     */
    protected $updateRules;

    /**
     * @var array Column names
     */
    protected $columnNames;

    /**
     * Construct
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Get all.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find.
     *
     * @param int $id
     *
     * @return array
     */
    public function get($id)
    {
        $model = $this->model::find($id);

        return empty($model) ? [] : $model;
    }

    public function with(array $withModel = [''])
    {
        $model = $this->with($withModel);

        return $model;
    }

    /**
     * Store.
     *
     * @param array $data
     *
     * @return void
     */
    public function store($data)
    {
        return $this->model::create($data);
    }

    /**
     * Show.
     *
     * @param int $id
     *
     * @return array
     */
    public function show($id)
    {
        return $this->model::find($id);
    }

    /**
     * Update.
     *
     * @param array $id
     * @param array $data
     *
     * @return void
     */
    public function update($id, $data)
    {
        return $this->model::find($id)->update($data);
    }

    /**
     * Destroy.
     *
     * @param Collection|array|int $ids
     *
     * @return void
     */
    public function destroy($ids)
    {
        $this->model::destroy($ids);
    }

    /**
     * Check exist.
     *
     * @param int $id
     *
     * @return boolean
     */
    public function exist($id)
    {
        return !empty($this->find($id));
    }

    public function updateOrCreate($dataCompare, $dataUpdate)
    {
        return $this->model::updateOrCreate($dataCompare, $dataUpdate);
    }

}
