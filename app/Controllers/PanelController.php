<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\DiagnosticoModel;
use App\Models\EquipoModel;
use App\Models\UsuarioModel;
use Config\Services;

class PanelController extends BaseController
{
    public function equipos(): string
    {
        $clienteModel = new ClienteModel();

        $session = Services::session();
        $usuario = $session->get("usuario");

        $equipoModel = new EquipoModel();
        $equipos = $equipoModel->where("id_usuario", $usuario["id"])->findAll();
        foreach ($equipos as $key => $equipo) {
            $equipos[$key]["cliente"] = $clienteModel->find($equipo["id_cliente"]);
            $equipos[$key]["tecnico"] = $usuario["nombre"] . " " . $usuario["apellido_paterno"] . " " . $usuario["apellido_materno"];
        }

        return view('equipos', ["equipos" =>  $equipos, "clientes" => $clienteModel->findAll()]);
    }


    public function clientes(): string
    {
        $clienteModel = new ClienteModel();
        return view('cliente', ["clientes" => $clienteModel->findAll()]);
    }

    public function panel()
    {
        $session = Services::session();
        if ($session->has("usuario")) {

            $clienteModel = new ClienteModel();
            $equipoModel = new EquipoModel();
            $usuarioModel = new UsuarioModel();
            $diagnosticoModel = new DiagnosticoModel();

            return view("panel", [
                "num_clientes" => count($clienteModel->findAll()),
                "num_equipos" => count($equipoModel->findAll()),
                "num_usuarios" => count($usuarioModel->findAll()),
                "num_diagnosticos" => count($diagnosticoModel->findAll())
            ]);
        } else {
            return redirect()->to("login");
        }
    }

    public function buscar_equipo()
    {
        return view("buscar_equipo");
    }

    public function diagnostico($id)
    {
        $clienteModel = new ClienteModel();

        $session = Services::session();
        $usuario = $session->get("usuario");

        $equipoModel = new EquipoModel();
        $equipo = $equipoModel->where("id_usuario", $usuario["id"])->find($id);

        if (!is_null($equipo)) {
            $equipo["cliente"] = $clienteModel->find($equipo["id_cliente"]);
            $equipo["diagnosticos"] = (new DiagnosticoModel())->where("id_equipo", $equipo["id"])->findAll();
        }

        return view('diagnostico', ["equipo" =>   $equipo]);
    }
}
