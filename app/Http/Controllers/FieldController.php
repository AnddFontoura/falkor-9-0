<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\State;
use App\Models\FieldPhoto;
use Illuminate\Support\Facades\Storage;
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
     * Using for Store and Update
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
            'googleLocation' => 'required|string|url|min:1|max:254',
            'photo' => 'nullable|image'
        ]);

        $data = $request->only([
            'cityId',
            'fieldName',
            'fieldNickname',
            'fieldAddress',
            'googleLocation',
            'photo'
        ]);
    
        $fieldPhotoModel = new FieldPhoto();
        $fieldPhotoPath = null;

        if(isset($data['photo'])) {
            $fieldPhotoPath = $this->uploadService->uploadFileToFolder('public', 'field_photos', $data['photo']);
        }
    
        if($id){ 
            $field = $this->model->where('id', $id)->first();
            $fieldPhotoModel = $fieldPhotoModel->where('field_id', $field)->first() ?? null;
            
            $field->update([
                'city_id' => $data['cityId'],
                'name' => $data['fieldName'],
                'nickname' => $data['fieldNickname'] ?? null,
                'address' => $data['fieldAddress'],
                'google_location' => $data['googleLocation']
            ]);

            $message = 'Campo atualizado com sucesso.';
        } else {
            $field = $this->model->create([
                'city_id' => $data['cityId'],
                'name' => $data['fieldName'],
                'nickname' => $data['fieldNickname'] ?? null,
                'address' => $data['fieldAddress'],
                'google_location' => $data['googleLocation']
            ]);
            
            if($field && isset($fieldPhotoPath)) {
                $fieldPhotoModel->create([
                    'field_id' => $field->id,
                    'main' => 1,
                    'photo' => $fieldPhotoPath
                ]);
            }
        
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $field = $this->model->where('id', $id)->first();
        $photo = $field->photos->first()->photo ?? '';
        $fieldPhotoModel = FieldPhoto::where('field_id', $id)->first();

        if($field->photos->isNotEmpty()) {
            /** 
             * metodo deleteFileOnFolder ta dando erro;
             * ele espera 3 parametros que incluem $folderPath e $filePath
             * porem os dois sao salvos no mesmo nome.
             * o metodo esta executando $folderPath/$folderPath/$filePath
            */
            Storage::disk('public')->delete($photo);
            $fieldPhotoModel->delete();
        }
        $field->delete();
        
        return redirect()->back();
    }

    public function uploadPhotoForm(int $id): View
    {
        $field = $this->model->where('id', $id)->first();
        $photosFromField = $field->photos;
        return view('system.field.upload_form', compact('field', 'photosFromField'));
    }

    public function uploadPhoto(Request $request, int $id)
    {
        $field = $this->model->where('id', $id)->first();
        $fieldPhotoPath = null;
        $fieldPhotoModel = new FieldPhoto();

        $request->validate($fieldPhotoModel->rulesForNewPhotos());

        $data = $request->only([
            'photos.*',
        ]);

        if(isset($data['photos'])) {
            foreach ($data['photos'] as $key => $photos) {
                foreach ($photos as $photo) {
                    $fieldPhotoPath = $this->uploadService->uploadFileToFolder('public', 'field_photos', $photo);
                    $fieldPhotoModel->create([
                        'field_id' => $field->id,
                        'main' => 0,
                        'photo' => $fieldPhotoPath
                    ]);
                }
            }

            return redirect()->route('system.field.upload_photo', [$field->id]);
        }
    }
}
