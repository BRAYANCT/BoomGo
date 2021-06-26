<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\Web\BusinessWebResource;
use App\Services\BusinessServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageWebController extends Controller
{
    private $businessService;

    private $prefixView = "web.pages.";

    public function __construct()
    {
        $this-> businessService = new BusinessServiceImpl();
    }

    /**
     * Muestra la pagina de inicio
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Boom Go";
        $description = "Empresa innovadora, somos un directorio de tiendas virtuales, encuentra tu categoría necesaria además crea tu tienda virtual y potencia tus compras y ventas en linea.";

        $parameters = array(
//            ['limit',5],
            'perPage' => 6,
            ['orderBy','last']
        );

        $relationshipNames = array('priceRange','reviews');
        $businesses = $this->businessService->findAllWithPagination($parameters,$relationshipNames);
        $businessesResource = BusinessWebResource::collection($businesses);

        return view($this->prefixView.'index',compact('title','description','businesses','businessesResource'));
    }


    /**
     * Muestra la pagina de inicio
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCookiePolicies()
    {
        $title = "Políticas de cookies";
        $description = "";

        return view($this->prefixView.'cookie-policies',compact('title','description'));
    }

    /**
     * Muestra la pagina de inicio
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPrivacyPolicies()
    {
        $title = "Políticas de privacidad";
        $description = "";

        return view($this->prefixView.'privacy-policies',compact('title','description'));
    }

}
