<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *    title="Votre API avec Laravel",
 *    version="1.0.0",
 *    description="Une description de votre API. Cette API permet de faire X, Y, Z...",
 *    termsOfService="http://example.com/terms/",
 *    contact={
 *       "email": "support@example.com"
 *    },
 *    license={
 *       "name": "API License",
 *       "url": "http://example.com/license/"
 *    }
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


}
