<?php
/** 
* @author Nando (c) 2018
* Simple Ajax Trait
*/
namespace App\Traits;

trait AjaxTrait
{

    public $success = true;
    public $data = null;
    public $code = \Illuminate\Http\Response::HTTP_OK;
    public $pagination = null;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function json() : \Illuminate\Http\JsonResponse
    {
        $result = array();
        $result['success'] = $this->success;
        $result['data'] = $this->data;
        $result['pagination'] = $this->pagination;

        return response()->json($result, $this->code, [], JSON_PRETTY_PRINT);
    }
}