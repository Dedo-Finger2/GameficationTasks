<?php

namespace App\Controllers;

class RouteErrorHandleController
{
    public function notAllowed()
    {
        http_response_code(405);
        var_dump("Method not Allowed!");
    }

    public function notFound()
    {
        http_response_code(404);
        var_dump("Method not Found!");
    }
}
