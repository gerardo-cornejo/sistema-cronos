<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class ApiSessionCheckerFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        if (!$session->has("usuario")) {
            $response = service('response');
            $response->setJSON(["mensajes" => ["La sesión ha expirado."]]);
            $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            return $response;
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
