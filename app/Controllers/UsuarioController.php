<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
}
