<?php
namespace App\Controllers;
class CatController
{
    private $model;

    /**
     * Inject CatModel dependency
     */
    public function __construct(CatModel $model)
    {
        $this->model = $model;
    }

    /**
     * GET /cats
     */
    public function index()
    {
        $cats = $this->model->getAll();
        $this->jsonResponse($cats);
    }

    /**
     * GET /cats/{id}
     */
    public function show($id)
    {
        $cat = $this->model->getById($id);

        if (!$cat) {
            $this->jsonResponse(["error" => "Cat not found"], 404);
            return;
        }

        $this->jsonResponse($cat);
    }

    /**
     * POST /cats
     */
    public function store()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'], $data['owner'], $data['birth'], $data['gender'])) {
            $this->jsonResponse(["error" => "Missing required fields"], 400);
            return;
        }

        $this->model->create(
            $data['name'],
            $data['owner'],
            $data['birth'],
            $data['gender']
        );

        $this->jsonResponse(["message" => "Cat created"], 201);
    }

    /**
     * PUT /cats/{id}
     */
    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'], $data['owner'], $data['birth'], $data['gender'])) {
            $this->jsonResponse(["error" => "Missing required fields"], 400);
            return;
        }

        $updated = $this->model->update(
            $id,
            $data['name'],
            $data['owner'],
            $data['birth'],
            $data['gender']
        );

        if (!$updated) {
            $this->jsonResponse(["error" => "Update failed"], 400);
            return;
        }

        $this->jsonResponse(["message" => "Cat updated"]);
    }

    /**
     * DELETE /cats/{id}
     */
    public function destroy($id)
    {
        $deleted = $this->model->delete($id);

        if (!$deleted) {
            $this->jsonResponse(["error" => "Delete failed"], 400);
            return;
        }

        $this->jsonResponse(["message" => "Cat deleted"]);
    }

    /**
     * Helper function for JSON responses
     */
    private function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}
