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

    /**
     * Render a response using the Inertia response factory.
     *
     * @param  string $component
     * @param  array  $props
     * @return \Inertia\Response
     */
    protected function render(string $component, array $props = [])
    {
        return InertiaRender::render($component, $props);
    }

    public function index(Request $request)
    {
        return $this->render('Luna/Modules/Index', [
            'module'  => $this->module,
            'model'   => $this->module::$model,
            'columns' => $this->module->columns(),
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
