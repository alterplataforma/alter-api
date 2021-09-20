<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Service\AlterConfiguration;
use Illuminate\Http\Request;

class AlterConfigurationController extends ApiController
{
    protected $config;

    public function __construct(AlterConfiguration $config)
    {
        $this->config = $config;
    }

    public function index()
    {
        //
    }

    public function get_row(Request $request)
    {
        $options = explode(",", $request->fields);
        $config = $this->config::all()->first();
        $data = [];
        foreach ($options as  $value) {
            array_push($data, array($value => $config[$value]));
        }
        return $this->successResponse($data);
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
