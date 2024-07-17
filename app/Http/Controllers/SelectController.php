<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Traits\AjaxTrait;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    use AjaxTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function select2Country(Request $request)
    {
        $select = ['id', 'name AS text'];
        try {

            $model = Country::select($select)
                ->where('name', 'like', '%'.$request->search.'%')
                ->select($select)
                ->simplePaginate(10);

            $morePages = true;
            $pagination_obj = json_encode($model);
            if (empty($model->nextPageUrl())) {
                $morePages = false;
            }

            $this->success = true;
            $this->code = \Illuminate\Http\Response::HTTP_OK;
            $this->data = $model->items();
            $this->pagination = ["more" => $morePages];
        } catch (\Exception $e) {
            $this->success = false;
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->json();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
