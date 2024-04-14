<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiagnosticoModel;
use App\Models\EquipoModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use CodeIgniter\API\ResponseTrait;


class UsuarioController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        if ($this->request->is("GET")) {
            return view("login");
        }

        if ($this->request->is("POST")) {

            $reglas = [
                "usuario" => ["rules" => "required", "errors" => ["required" => REQUIRED]],
                "clave" => ["rules" => "required", "errors" => ["required" => REQUIRED]]
            ];

            if (!$this->validate($reglas)) {
                return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
            }

            $usuario = $this->request->getVar("usuario");
            $clave = $this->request->getVar("clave");

            $usuarioModel = new UsuarioModel();
            $objUsuario = $usuarioModel->where("usuario", $usuario)->first();

            if (is_null($objUsuario)) {
                return $this->respond(["mensajes" => ["El usuario no existe."]], ResponseInterface::HTTP_NOT_FOUND);
            }

            if (!password_verify($clave, $objUsuario["clave"])) {
                return $this->respond(["mensajes" => ["Clave incorrecta"]], ResponseInterface::HTTP_NOT_FOUND);
            }
            $session = Services::session();
            $session->set("usuario", $objUsuario);
            return $this->respond(["mensajes" => ["Sesión ok"]]);
        }
    }

    public function index()
    {
        $session = Services::session();
        if ($session->has("usuario")) {
            return redirect()->to("");
        }
    }

    public function logout()
    {
        $session = Services::session();
        $session->remove("usuario");
        $session->destroy();
        return redirect()->to("/login");
    }

    public function listar()
    {
        $usuarioModel = new UsuarioModel();
        return $this->respond(["lista" => $usuarioModel->select("id,nombre, apellido_paterno, apellido_materno,dni, tipo, usuario")->findAll()]);
    }

    public function nuevo()
    {
        $reglas = [
            "usuario" => ["rules" => "required", "errors" => ["required" => REQUIRED]],
            "clave" => ["rules" => "required", "errors" => ["required" => REQUIRED]]
        ];

        $usuarioModel = new UsuarioModel();
        if (!$this->validate($usuarioModel->getValidationRules(), $usuarioModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }
        if (!$this->validate($reglas)) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $nombre = $this->request->getVar("nombre");
        $apellido_paterno = $this->request->getVar("apellido_paterno");
        $apellido_materno = $this->request->getVar("apellido_materno");
        $dni = $this->request->getVar("dni");
        $tipo = $this->request->getVar("tipo");
        $usuario = $this->request->getVar("usuario");
        $clave = $this->request->getVar("clave");

        $res = $usuarioModel->db->query("INSERT INTO usuarios(nombre, apellido_paterno, apellido_materno, dni,tipo,usuario,clave) VALUES (?,?,?,?,?,?,?);", [
            $nombre, $apellido_paterno, $apellido_materno, $dni, $tipo, $usuario, $clave
        ]);

        return $this->respondCreated([
            "nombre" => $nombre,
            "apellido_paterno" => $apellido_paterno,
            "apellido_materno" => $apellido_materno,
            "dni" => $dni,
            "tipo" => $tipo,
            "usuario" => $usuario,
            "clave" => $clave,
            "id" => $usuarioModel->where("nombre", $nombre)->where("usuario", $usuario)->first()["id"]
        ]);
    }

    public function editar()
    {

        $usuarioModel = new UsuarioModel();
        if (!$this->validate($usuarioModel->getValidationRules(), $usuarioModel->getValidationMessages())) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $reglas = [
            "id" => ["rules" => "required", "errors" => ["required" => REQUIRED]]
        ];

        if (!$this->validate($reglas)) {
            return $this->respond(["mensajes" => $this->validator->getErrors()], ResponseInterface::HTTP_CONFLICT);
        }

        $nombre = $this->request->getVar("nombre");
        $apellido_paterno = $this->request->getVar("apellido_paterno");
        $apellido_materno = $this->request->getVar("apellido_materno");
        $dni = $this->request->getVar("dni");
        $tipo = $this->request->getVar("tipo");
        $id = $this->request->getVar("id");

        $usuarioModel
            ->where("id", $id)
            ->set("nombre", $nombre)
            ->set("apellido_paterno", $apellido_paterno)
            ->set("apellido_materno", $apellido_materno)
            ->set("dni", $dni)
            ->set("tipo", $tipo)
            ->set("tipo", $tipo)
            ->update();

        return $this->respond([
            "nombre" => $nombre,
            "apellido_paterno" => $apellido_paterno,
            "apellido_materno" => $apellido_materno,
            "dni" => $dni,
            "tipo" => $tipo,
            "id" => $id
        ]);
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
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);
        if (is_null($usuario)) {
            return $this->respond(["mensajes" => "No se encontró el usuario."], ResponseInterface::HTTP_CONFLICT);
        }

        $equipoModel = new EquipoModel();
        $equipos = $equipoModel->where("id_usuario", $usuario["id"])->findAll();

        $diagnosticoModel = new DiagnosticoModel();

        foreach ($equipos as $key => $equipo) {
            $diagnosticoModel->where("id_equipo", $equipo["id"])->delete();
            $equipoModel->delete($equipo["id"]);
        }

        $usuarioModel->delete($id);
        return $this->respondDeleted(["mensajes" => "Usuario eliminado con éxito."]);
    }
}
