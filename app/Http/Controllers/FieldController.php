<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\State;
use Illuminate\View\View;

class FieldController extends Controller
{
    protected $model;

    public function __construct(Field $model)
    {
        $this->model = $model;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $this->validate($request, [
            'fieldName' => 'nullable|string|min:1|max:254',
            'city_id' => 'nullable|integer',
            'state_id' => 'nullable|integer'
        ]);
        
        $filter = request()->only([
            'fieldName',
            'city_id',
            'state_id'
        ]);

        $fields = $this->model->select('fields.*');

        if(isset($filter['fieldName']) && $filter['fieldName']) {
            $fields = $fields->where('fields.name', 'like', '%' . $filter['fieldName'] . '%');
        }

        if(isset($filter['city_id']) && $filter['city_id']) {
            $fields = $fields->where('fields.city_id', $filter['city_id']);
        }

        if(isset($filter['state_id']) && $filter['state_id']) {
            $fields = $fields
                        ->join('cities', 'cities.id', '=', 'fields.city_id')
                        ->where('cities.state_id', $filter['state_id']);
        }

        $fields = $fields->paginate();

        $cities = $this->cityModel->orderBy('name', 'asc')->get();
        $states = $this->stateModel->orderBy('name', 'asc')->get();

        return view('system.fields.index', compact('fields', 'cities', 'states'));
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
        
    }
}
