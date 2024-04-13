<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\EquipoModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Database;
use Config\Services;

class ClienteController extends BaseController
{
    use ResponseTrait;

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

        $clienteModel = new ClienteModel();

        $cliente = $clienteModel->find($id);
        if (is_null($cliente)) {
            return $this->respond(["mensajes" => ["No se encontró el cliente"]], ResponseInterface::HTTP_NOT_FOUND);
        }

        $equipoModel = new EquipoModel();
        $equipos = $equipoModel->where("id_cliente", $id)->findAll();

        $db = Database::connect();
        foreach ($equipos as $key => $equipo) {
            $db->query("DELETE FROM diagnostico WHERE id_equipo=?", [$equipo["id"]]);
        }
        $db->close();
        $equipoModel->where("id_cliente", $id)->delete();
        $clienteModel->delete($id);
        return $this->respond(["mensajes" => ["Cliente eliminado con éxito"]]);
    }

    public function nuevo()
    {
        $longitud_documentos = [
            "dni" => 8,
            "ruc" => 11,
            "pasaporte" => 20,
            "ce" => 12
        ];

        $clienteModel = new ClienteModel();

        if (!$this->validate($clienteModel->getValidationRules(), $clienteModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }
        $nombre = $this->request->getVar("nombre");
        $tipo_doi = $this->request->getVar("tipo_doi");
        $apellido_paterno = $this->request->getVar("apellido_paterno");
        $apellido_materno = $this->request->getVar("apellido_materno");
        $numero_doi = $this->request->getVar("numero_doi");

        $longitud = $longitud_documentos[$tipo_doi];

        $regla_dinamica = [
            "numero_doi" => [
                "rules" => "required|max_length[$longitud]",
                "errors" => ["required" => REQUIRED, "max_length" => MAX_LENGTH]
            ]
        ];

        if (!$this->validate($regla_dinamica)) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $data = [
            "nombre" => $nombre,
            "apellido_paterno" => $apellido_paterno,
            "apellido_materno" => $apellido_materno,
            "tipo_doi" => $tipo_doi,
            "numero_doi" => $numero_doi
        ];

        $data["id"] = $clienteModel->insert($data);
        return $this->respondCreated($data);
    }
    
    public function editar()
    {
        $longitud_documentos = [
            "dni" => 8,
            "ruc" => 11,
            "pasaporte" => 20,
            "ce" => 12
        ];

        $clienteModel = new ClienteModel();

        if (!$this->validate($clienteModel->getValidationRules(), $clienteModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }
        $nombre = $this->request->getVar("nombre");
        $tipo_doi = $this->request->getVar("tipo_doi");
        $apellido_paterno = $this->request->getVar("apellido_paterno");
        $apellido_materno = $this->request->getVar("apellido_materno");
        $numero_doi = $this->request->getVar("numero_doi");

        $longitud = $longitud_documentos[$tipo_doi];

        $regla_dinamica = [
            "numero_doi" => [
                "rules" => "required|exact_length[$longitud]",
                "errors" => ["required" => REQUIRED, "exact_length" => EXACT_LENGTH]
            ],
            "id" => [
                "rules" => "required|numeric",
                "errors" => ["required" => REQUIRED, "numeric" => NUMERIC]
            ]
        ];

        if (!$this->validate($regla_dinamica)) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }
        $id = $this->request->getVar("id");
        $data = [
            "nombre" => $nombre,
            "apellido_paterno" => $apellido_paterno,
            "apellido_materno" => $apellido_materno,
            "tipo_doi" => $tipo_doi,
            "numero_doi" => $numero_doi
        ];

        $clienteModel->update($id, $data);
        $data["id"] = $id;
        return $this->respondUpdated($data);
    }

    public function listar()
    {
        $clienteModel = new ClienteModel();
        return $this->respond(["lista" => $clienteModel->findAll()]);
    }
}
