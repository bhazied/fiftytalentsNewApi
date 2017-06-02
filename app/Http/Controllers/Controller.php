<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getDestroyResponse($status, $entityName)
    {
        $response = ['status' => $status];
        if ($status) {
            return array_merge($response, ['message' => Lang::get('messages.repository.deleted_success', ['entity' => $entityName])]);
        }
        return array_merge($response, ['message' => Lang::get('messages.repository.delated_failure', ['entity' => $entityName])]);
    }

    public function getUpdateResponse($status, $entityName)
    {
        $response = ['status' => $status];
        if ($status) {
            return array_merge($response, ['message' => Lang::get('messages.repository.updated_success', ['entity' => $entityName])]);
        }
        return array_merge($response, ['message' => Lang::get('messages.repository.updated_failure', ['entity' => $entityName])]);
    }
}
