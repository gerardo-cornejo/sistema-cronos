<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;


class SessionCheckerFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        if (!$session->has("usuario")) {
            return redirect()->to("/login");
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
