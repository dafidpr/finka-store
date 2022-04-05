<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->generateDefaultLayout();
    }

    private function generateDefaultLayout()
    {
        if (request()->route()) {
            $action = request()->route()->getAction();
            $controller = class_basename($action['controller']);
            list($controller, $method) = explode('@', $controller);
            $controller = strtolower(str_replace('Controller', '', $controller));

            if(\Request::ajax()){
                $this->defaultLayout = $controller .'.'. $method;
            } else {
                $this->defaultLayout = 'layouts.app';
            }
        }
    }

    public function defaultLayout($url)
    {
        if(\Request::ajax()){
            $this->defaultLayout = $url;
        } else {
            $this->defaultLayout = 'layouts.app';
        }

        return $this->defaultLayout;
    }

    protected function handleDuplicateData(QueryException $e, callable $callback)
    {
        if ($e->getCode() == 23000) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data ini tidak dapat dihapus karena masih terhubung dengan data lain'
            ], 500);
        } else {
            return $callback($e);
        }
    }
}
