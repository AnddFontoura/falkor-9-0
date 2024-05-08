<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    protected $field;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = $this->field->paginate(10);
        return view('system.fields.index', ['fields' => $fields, 'request' => $request->all()]);
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

    public function search(Request $request)
    {
        $searchedFields = array();

        if(
            ($request->get('name') != null && $request->get('name') != '') ||
            ($request->get('state_id') != null && $request->get('state_id') != '') ||
            ($request->get('city_id') != null && $request->get('city_id') != '')
        ){
            $searchfield = $this->field;
            $searchedFields = $searchfield::where('name','like', '%'.$request->get('name').'%')
                ->orWhere('city_id', 'like', '%'.$request->get('city_id').'%')
                ->get()
                ->toJson();
        }

        return response($searchedFields, 200);
    }
}
