<?php

namespace Luna\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Luna\Module\Module;

class Controller
{
    protected Module $module;
    protected Model $model;

    public function __construct(Request $request)
    {
        $this->module = new ($request->route('module'));
    }

    public function index(Request $request): Response
    {
        return response()->json([
            'method'  => 'index',
            'module'  => $this->module,
            'model'   => $this->module::$model,
            'columns' => $this->module->columns(),
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->json([$this->module, 'create']);
    }

    public function store(Request $request): Response
    {
        return response()->json([$this->module, 'store']);
    }

    public function show(Request $request, string $id): Response
    {
        return response()->json([$this->module, 'show']);
    }

    public function edit(Request $request, string $id): Response
    {
        return response()->json([$this->module, 'edit']);
    }

    public function update(Request $request, string $id): Response
    {
        return response()->json([$this->module, 'update']);
    }

    public function destroy(Request $request, string $id): Response
    {
        return response()->json([$this->module, 'destroy']);
    }
}
