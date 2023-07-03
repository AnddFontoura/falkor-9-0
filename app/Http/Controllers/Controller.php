<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewFolder;
    protected $saveRedirect;
    protected $model;
    protected $modelRelated = [];
    protected $requestFields = [];

    public function index(Request $request)
    {
        $data = null;

        $data = $this->filterOptions($request);

        $data = $data->paginate();

        return view($this->viewFolder . '.index', [$data => $data]);
    }

    protected function filterOptions(Request $request)
    {
        $filters = $request->only($this->requestFields);

        $data = $this->model->select();

        foreach ($filters as $key => $value) {
            $data = $data->where($key, $value);
        }

        return $data;
    }

    public function form(int $id = null)
    {
        $formInfo = null;

        if($id) {
            $formInfo = $this->model->where('id', $id)->first();
        }

        return view($this->viewFolder. '.form', [$formInfo => $formInfo]);
    }

    public function save(Request $request, int $id = null)
    {
        $message = null;

        $data = $request->only($this->requestFields);

        if ($id) {
            $this->model->where('id', $id)->update($data);
            $message = "Dado Inserido com sucesso";
        } else {
            $this->model->create($data);
            $message = "Dado Inserido com sucesso";
        }

        return redirect($this->saveRedirect)->with('message', $message);
    }

    public function view(int $id)
    {
        $viewInfo = $this->model->where('id', $id)->first();

        if(!$viewInfo) {
            return redirect($this->saveRedirect)->with('message', 'Registro não encontrado, pode ter sido apagado ou o número está incorreto');
        }

        return view($this->viewFolder . '.view', [$viewInfo]);
    }
}
