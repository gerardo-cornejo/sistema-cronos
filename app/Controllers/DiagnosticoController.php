<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiagnosticoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class DiagnosticoController extends BaseController
{
    use ResponseTrait;

    public function listar(int $id_equipo)
    {
        $diagnosticoModel = new DiagnosticoModel();
        $lista = $diagnosticoModel->where("id_equipo", $id_equipo)->findAll();
        return $this->respond(["lista" => $lista]);
    }

    public function eliminar()
    {
        $reglas = [
            "id" => [
                "rules" => "required|numeric",
                "errors" => ["required" => REQUIRED, "numeric" => NUMERIC]
            ]
        ];

        if (!$this->validate($reglas)) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }
        $id = $this->request->getVar("id");

        $diagnosticoModel = new DiagnosticoModel();
        $diagnostico = $diagnosticoModel->find($id);
        if (is_null($diagnostico)) {
            return $this->respond(["mensajes" => ["No se encontró el cliente"]], ResponseInterface::HTTP_NOT_FOUND);
        }

        $diagnosticoModel->delete($id);
        return $this->respond(["mensajes" => ["Diagnóstico eliminado con éxito"]]);
    }

    public function guardar()
    {
        $diagnosticoModel = new DiagnosticoModel();

        if (!$this->validate($diagnosticoModel->getValidationRules(), $diagnosticoModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }
        $data = [
            "id_equipo" => $this->request->getVar("id_equipo"),
            "diagnostico" => $this->request->getVar("diagnostico"),
            "precio" => $this->request->getVar("precio")
        ];

        $data["id"] = $diagnosticoModel->insert($data);
        return $this->respondCreated($data);
    }

    public function editar()
    {
        $diagnosticoModel = new DiagnosticoModel();

        if (!$this->validate($diagnosticoModel->getValidationRules(), $diagnosticoModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $id = $this->request->getVar("id");
        $data = [
            "id_equipo" => $this->request->getVar("id_equipo"),
            "diagnostico" => $this->request->getVar("diagnostico"),
            "precio" => $this->request->getVar("precio")

        ];

        $diagnosticoModel->where("id", $id)->update($id, $data);
        $data["id"] = $id;
        return $this->respondCreated($data);
    }
}
