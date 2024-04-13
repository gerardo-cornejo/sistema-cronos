<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\DiagnosticoModel;
use App\Models\EquipoModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use CodeIgniter\API\ResponseTrait;

class EquipoController extends BaseController
{
    use ResponseTrait;

    public function listar()
    {
        $session = Services::session();
        $usuario = $session->get("usuario");
        $equipoModel = new EquipoModel();

        $clienteModel = new ClienteModel();

        $equipos = $equipoModel->where("id_usuario", $usuario["id"])->findAll();
        foreach ($equipos as $key => $equipo) {
            $equipos[$key]["tecnico"] = $usuario["nombre"] . " " . $usuario["apellido_paterno"] . " " . $usuario["apellido_materno"];
            $equipos[$key]["cliente"] = $clienteModel->find($equipo["id_cliente"]);
        }
        return $this->respond(["lista" => $equipos]);
    }

    public function nuevo()
    {
        $session = Services::session();
        $usuario = $session->get("usuario");

        $equipoModel = new EquipoModel();
        if (!$this->validate($equipoModel->getValidationRules(), $equipoModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $marca = $this->request->getVar("marca");
        $modelo = $this->request->getVar("modelo");
        $serie = $this->request->getVar("serie");
        $id_cliente = $this->request->getVar("id_cliente");

        $clienteModel = new ClienteModel();
        if (is_null($clienteModel->find($id_cliente))) {
            return $this->respond(["mensajes" => ["No se encontró el cliente con id $id_cliente"]], ResponseInterface::HTTP_NOT_FOUND);
        }

        $data = [
            "id_usuario" => $usuario["id"],
            "id_cliente" => $id_cliente,
            "marca" => $marca,
            "modelo" => $modelo,
            "serie" => $serie,
            "codigo_barras" => $equipoModel->generarCodigoBarras()
        ];

        $equipoModel->db->query("INSERT INTO equipo (id_usuario,id_cliente,marca,modelo,serie,codigo_barras) VALUES (?,?,?,?,?,?);", [
            $usuario["id"], $id_cliente, $marca, $modelo, $serie, $equipoModel->generarCodigoBarras()
        ]);

        return $this->respondCreated($equipoModel->where("codigo_barras", $data["codigo_barras"])->first());
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
        $equipoModel = new EquipoModel();

        $session = Services::session();
        $usuario = $session->get("usuario");

        $cliente = $equipoModel->where("id_usuario", $usuario["id"])->find($id);
        if (is_null($cliente)) {
            return $this->respond(["mensajes" => ["No se encontró el cliente"]], ResponseInterface::HTTP_NOT_FOUND);
        }

        //Eliminar diagnosticos si existen
        $diagnosticoModel = new DiagnosticoModel();
        $diagnosticoModel->where("id_equipo", $id)->delete();


        $equipoModel->delete($id);
        return $this->respond(["mensajes" => ["Equipo eliminado con éxito"]]);
    }

    public function editar()
    {
        $session = Services::session();
        $usuario = $session->get("usuario");

        $equipoModel = new EquipoModel();
        if (!$this->validate($equipoModel->getValidationRules(), $equipoModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $marca = $this->request->getVar("marca");
        $modelo = $this->request->getVar("modelo");
        $serie = $this->request->getVar("serie");
        $id_cliente = $this->request->getVar("id_cliente");
        $id = $this->request->getVar("id");

        $clienteModel = new ClienteModel();
        if (is_null($clienteModel->find($id_cliente))) {
            return $this->respond(["mensajes" => ["No se encontró el cliente con id $id_cliente"]], ResponseInterface::HTTP_NOT_FOUND);
        }

        $clienteModel->db->query("UPDATE equipo SET marca=?, modelo=?, serie=?, id_cliente=? WHERE  id=?", [
            $marca, $modelo, $serie, $id_cliente,
            $id
        ]);

        return $this->respond([
            "marca" => $marca,
            "modelo" => $modelo,
            "serie" => $serie,
            "id" => $id,
            "id_cliente" => $id_cliente
        ]);
    }

    public function buscado($codigo_barras)
    {
        $equipoModel = new EquipoModel();
        $equipo = $equipoModel->where("codigo_barras", $codigo_barras)->first();
        if (!is_null($equipo)) {
            $equipo["cliente"] = (new ClienteModel())->find($equipo["id_cliente"]);
        }
        return view("equipo_encontrado", ["equipo" => $equipo]);
    }
}
