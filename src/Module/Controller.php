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
        $perPageOptions = $this->module::$perPageOptions ?? [20];
        $perPage        = $request->query('per_page', $perPageOptions[0]);
        $query          = $this->module::$model::query();
        $sortBy         = $request->query('sort_by');
        $sortDir        = $request->query('sort_dir');
        $search         = $request->query('search');
        $locCode        = $request->query('location_code');

        if ($sortBy && $sortDir) {
            $query->orderBy($sortBy, $sortDir);
        }

        if ($search) {
            $searchables = collect($this->module->searchables())->pluck('attributes.searchable')->flatten()->toArray();

            $query->where(function ($q) use ($searchables, $search) {
                foreach ($searchables as $field) {
                    $q->orWhere($field, 'LIKE', "%{$search}%");
                }
            });
        }

        if ($locCode) {
            $query->where('location_code', $locCode);
        }

        if (isset($this->module::$with)) {
            $query->with($this->module::$with);
        }

        $pagination = $query->paginate($perPage);

        if (isset($this->module::$paginationResource)) {
            $pagination = new ($this->module::$paginationResource)($pagination);
        }

        return InertiaRender::render('Luna/modules/Index', [
            'luna' => [
                'module'  => [
                    'name'        => $this->module::$name,
                    'description' => $this->module::$description,
                    'columns'     => $this->module->columns(),
                    'searchables' => $this->module->searchables(),
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
