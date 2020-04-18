<?php

namespace App\Lib;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class RestProcessor
{
    protected $queryOrClass;
    protected $searchCols = [];
    protected $filterCols = [];
    protected $sortables = [];
    protected $relations = [];
    protected $dbCols = [];

    /** @var Builder */
    protected $query;
    protected $request;

    protected $defaultSort = ['id', 'desc'];
    protected $perPage = 15;

    protected $enableAll = false;

    protected $methodSearch;
    protected $separator = '|';

    protected $params = [
        'search'       => 'search',
        'perPage'      => 'per_page',
        'sortBy'       => 'sort',
        'filter'       => 'fil',
        'withRelation' => 'withRelation',
        'filterCols'   => 'filterCols',
        'all'          => 'all',
        'onlyCols'     => 'onlyCols',
    ];

    public function __construct($queryOrClass)
    {
        $this->queryOrClass = $queryOrClass;
        $this->query = $this->getInitQuery();
        $this->request = request();
    }

    public function getInitQuery()
    {
        if (is_string($this->queryOrClass)) {
            return $this->queryOrClass::query();
        }
        return $this->queryOrClass;
    }

    public function enableGetAll()
    {
        $this->enableAll = true;
    }

    public function setDbCols(array $cols)
    {
        $this->dbCols = $cols;
    }

    public function setAvailableSortables($sortables)
    {
        $this->sortables = is_array($sortables) ? $sortables : func_get_args();
    }

    public function setSearchCols($searchCols)
    {
        $this->searchCols = is_array($searchCols) ? $searchCols : func_get_args();
    }

    public function setAvailableFilterCols($filterCols)
    {
        $this->filterCols = is_array($filterCols) ? $filterCols : func_get_args();
    }

    public function setAvailableRelations($relations)
    {
        $this->relations = is_array($relations) ? $relations : func_get_args();
    }

    public function setDefaultSort($column, $direction = 'desc')
    {
        $this->defaultSort = [$column, $direction];
    }

    public function render()
    {
        $this->ordering();

        if ($this->request->has($this->params['filterCols'])) {
            $this->applyFilters();
        }

        if ($this->request->has($this->params['search'])) {
            $this->applySearch();
        }

        $this->applyRelations();

        $this->applyOnlyColumns();

        if ($this->enableAll && $this->request->has($this->params['all'])) {
            return $this->query->get();
        }


        return $this->query->paginate($this->perPage);
    }

    protected function ordering()
    {
        if (! empty($this->request->get($this->params['sortBy'])) && ! empty($this->sortables)) {
            list($sortCol, $sortDir) = explode($this->separator, $this->request->get($this->params['sortBy']));
            if (in_array($sortCol, $this->sortables)) {
                $this->query->orderBy($sortCol, $sortDir);
            } else {
                $this->printError('No es posible ordernar por el parametro: '.$sortCol.', contacte al administrador.');
            }
        } else {
            $this->query->orderBy($this->defaultSort[0], $this->defaultSort[1]);
        }
    }

    public function printError($message)
    {
        abort(500, $message);
    }

    protected function applyFilters()
    {
        $this->query->where(function ($q) {
            $cols = $this->filterColsDecode($this->request->get($this->params['filterCols']));

            foreach ($cols as $item) {
                if ($item['type'] === 'number' || $item['type'] === 'select' || $item['type'] === 'dynamic-select' || $item['type'] === 'custom_numeric') {
                    if (empty($item['value'])) {
                        $q->where(function ($q2) use ($item) {
                            $q2->where($item['col'], $item['value'])
                                ->orWhereNull($item['col']);
                        });
                    } else {
                        $q->where($item['col'], $item['value']);
                    }
                } elseif ($item['type'] === 'year') {
                    $q->where(\DB::raw('YEAR('.$item['col'].')'), $item['value']);
                } elseif ($item['type'] === 'date' || $item['type'] === 'rangedate') {
                    $rangeDate = explode(' - ', $item['value']);
                    $q->whereBetween($item['col'], [
                        Carbon::createFromFormat('d/m/Y', $rangeDate[0])->format('Y-m-d'),
                        Carbon::createFromFormat('d/m/Y', $rangeDate[1])->format('Y-m-d'),
                    ]);
                } elseif ($item['type'] === 'rangedatetime') {
                    $rangeDate = explode(' - ', $item['value']);
                    $q->whereBetween($item['col'], [
                        Carbon::createFromFormat('d/m/Y', $rangeDate[0])->format('Y-m-d').' 00:00:00',
                        Carbon::createFromFormat('d/m/Y', $rangeDate[1])->format('Y-m-d').' 23:59:59',
                    ]);
                } else {
                    $q->where($item['col'], 'like', '%'.$item['value'].'%');
                }
            }
        });
    }

    protected function filterColsDecode($value)
    {
        $data = [];
        $columns = explode($this->separator, $value);
        foreach ($columns as $column) {
            $col = explode(',', $column);
            if (count($col) == 3) {
                $data[] = [
                    'col'   => $col[0],
                    'value' => $col[1],
                    'type'  => isset($col[2]) ? $col[2] : 'text',
                ];
            }
        }
        return $data;
    }

    public function applySearch()
    {
        if ($this->request->has($this->params['search']) && ! empty($this->searchCols)) {
            $this->query->where(function ($q) {
                $value = "%{$this->request->get($this->params['search'])}%";

                foreach ($this->searchCols as $searchCol) {
                    $methodSearch = $this->methodSearch;
                    if ($methodSearch != null && is_callable($methodSearch)) {
                        $methodSearch($q, $this->params['search']);
                    } else {
                        $q->orWhere($searchCol, 'like', $value);
                    }
                }
            });
        }
    }

    public function applyRelations()
    {
        if ($this->request->has($this->params['withRelation']) && ! empty($this->relations)) {
            $relations = explode($this->separator, $this->request->get($this->params['withRelation']));
            $relationsList = [];
            foreach ($relations as $relation) {
                if (in_array($relation, $this->relations)) {
                    $relationsList[] = $relation;
                } else {
                    $this->printError('Esta relacion no está disponible: '.$relation.', contacte al administrador.');
                }
            }
            if (! empty($relationsList)) {
                $this->query->with($relationsList);
            }
        }
    }

    public function applyOnlyColumns()
    {
        if ($this->request->has($this->params['onlyCols'])) {
            $cols = collect(explode(',', $this->request->get($this->params['onlyCols'])));

            $columns = $cols->intersect($this->dbCols);

            if (count($columns)) {
                $this->query->select($columns->toArray());
            }
        }
    }
}
