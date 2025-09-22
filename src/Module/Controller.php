<?php

namespace Luna\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Luna\Module\Module;
use Luna\Utils\InertiaRender;

class Controller
{
    protected Module $module;
    protected Model $model;

    public function __construct(Request $request)
    {
        $this->module = new ($request->route('module'));
    }

    public function index(Request $request)
    {
        $pagination = $this->module::$model::paginate();

        if (isset($this->module::$paginationResource)) {
            $pagination = new ($this->module::$paginationResource)($pagination);
        }

        return InertiaRender::render('Luna/modules/Index', [
            'luna' => [
                'module'  => [
                    'name'        => $this->module::$name,
                    'description' => $this->module::$description,
                    'columns'     => $this->module->columns(),
                    'pagination'  => $pagination,
                ],
            ]
        ]);
    }

    public function create(Request $request)
    {
        return response()->json([$this->module, 'create']);
    }

    public function store(Request $request)
    {
        return response()->json([$this->module, 'store']);
    }

    public function show(Request $request, string $id)
    {
        return response()->json([$this->module, 'show']);
    }

    public function edit(Request $request, string $id)
    {
        return response()->json([$this->module, 'edit']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json([$this->module, 'update']);
    }

    public function destroy(Request $request, string $id)
    {
        return response()->json([$this->module, 'destroy']);
    }
}
