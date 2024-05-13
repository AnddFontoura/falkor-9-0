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
    protected string $viewFolder = 'system.field.';
    protected string $saveRedirect = 'system/field';

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

        return view($this->viewFolder.'index', compact('fields', 'cities', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(int $id = null): View
    {
        $field = null;
        $cities = $this->cityModel->orderBy('name', 'asc')->get();

        if($id) {
            $field = $this->model->find($id);
        }

        return view($this->viewFolder . 'form', compact('field', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id = null)
    {
        $request->validate([
            'cityId' => 'required|integer|min:1|exists:cities,id',
            'fieldName' => 'required|string|min:1|max:254|',
            'fieldNickname' => 'nullable|string|min:1|max:254',
            'fieldAddress' => 'required|string|min:1|max:1000',
            'googleLocation' => 'required|string|url|min:1|max:254'
        ]);

        $data = $request->only([
            'cityId',
            'fieldName',
            'fieldNickname',
            'fieldAddress',
            'googleLocation'
        ]);
    
        if($id){ 
            $field = $this->model->where('id', $id)->first();
            
            $field->update([
                'city_id' => $data['cityId'],
                'name' => $data['fieldName'],
                'nickname' => $data['fieldNickname'] ?? null,
                'address' => $data['fieldAddress'],
                'google_location' => $data['googleLocation']
            ]);

            $message = 'Campo atualizado com sucesso.';
        } else {
            $this->model->create([
                'city_id' => $data['cityId'],
                'name' => $data['fieldName'],
                'nickname' => $data['fieldNickname'] ?? null,
                'address' => $data['fieldAddress'],
                'google_location' => $data['googleLocation']
            ]);

            $message = 'Campo criado com sucesso.';
        }

        return redirect($this->saveRedirect)->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $fieldId)
    {
        $field = $this->model->where('id', $fieldId)->first();

        return view($this->viewFolder . 'show', compact('field'));
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
