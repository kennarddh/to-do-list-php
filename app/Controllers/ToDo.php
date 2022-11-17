<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ToDo extends ResourceController
{
    protected $modelName = 'App\Models\ToDoModel';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond(["data" => $this->model->findAll()]);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);

        if ($data === null) {
            return $this->respond(["message" => "To do doesn't exist"], 404);
        }

        return $this->respond(["data" => $data]);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $title = $this->request->getJSON()->title;

        $this->model->insert([
            "title" => $title,
        ]);

        $id = $this->model->getInsertID();

        return $this->respond(["data" => ["id" => $id]]);
    }


    /**
     * Update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = $this->model->find($id);

        if ($data === null) {
            return $this->respond(["message" => "To do doesn't exist"], 404);
        }

        $title = $this->request->getJSON()->title;

        $success = $this->model->update($id, [
            "title" => $title,
        ]);

        if ($success)
            return $this->respond(["data" => [
                "id" => $id
            ]]);

        return $this->respond(["message" => "Internal server error"], 500);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $data = $this->model->find($id);

        if ($data === null) {
            return $this->respond(["message" => "To do doesn't exist"], 404);
        }

        $success = $this->model->delete($id);

        if ($success)
            return $this->respond(["data" => [
                "id" => $id
            ]]);

        return $this->respond(["message" => "Internal server error"], 500);
    }
}
