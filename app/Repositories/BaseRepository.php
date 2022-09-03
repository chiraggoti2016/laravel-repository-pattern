<?php
namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // remove record from the database
    public function edit($id)
    {
        return $this->model->findOrFail($id);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->findData($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findData($id)
    {
        return $this->model->findOrFail($id);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function bulkDelete($ids)
    {
        foreach ($ids as $key => $id) {
            $data = $this->model->findOrFail($id);
            $data->delete();
        }
        return $data;
    }

    public function updateOrCreateData($attribute,$values)
    {
        return $this->model->updateOrCreate($attribute,$values);
    }

}

?>
