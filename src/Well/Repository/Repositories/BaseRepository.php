<?php

namespace Well\Repository\Repositories;

use Illuminate\Container\Container as Application;

abstract class BaseRepository
{
    protected $app;

    protected $model;

    protected $searchable;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->make();
    }
    
    protected function make()
    {
        $model = $this->app->make($this->model);

        return $this->model = $model;
    }

    protected function query()
    {        
        return $this->model->newQuery();
    }
    
    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->query()->get($columns);
    }
    
    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        return $this->query()->first($columns);
    }
    
    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = 'paginate')
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
                
        return $this->query()->paginate($limit, $columns);
    }
    
    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate($limit = null, $columns = ['*'])
    {
        return $this->paginate($limit, $columns, "simplePaginate");
    }
    
    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->query()->findOrFail($id, $columns);
    }
    
    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        $model = $this->model->where($field, '=', $value)->get($columns);
        
        return $model;
    }
    
    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function where(array $where)
    {        
        $query = $this->conditions($where);
                
        return $query;
    }
    
    public function search(array $attributes)
    {
        $searchable = $this->searchable;

        foreach($attributes as $key => $value){
        	if(in_array($key, $searchable)){
		        if(is_null($value)){
			        unset($attributes[$key]);
		        }
	        }
        }

        $where = array();

	    foreach($attributes as $key => $value){
		    $condition = '=';

	    	if(stristr($value, ',')){
			    $condition = last(explode(',', $value));
		    }

		    array_push($where, array($key, $condition, $value));
	    }

        return $this->where($where)->get();
    }
    
    /**
     * Save a new entity in repository
     *     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->model->getModel()->newInstance();
        $model->fill($attributes);
        $model->save();
        
        return $model;
    }
    
    /**
     * Update a entity in repository by id
     *     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = $this->find($id);
        
        $model->fill($attributes);
        $model->save();
        
        return $model;
    }
    
    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
    	return $this->model->destroy($id);
    }
    
    /**
     * Delete multiple entities by given criteria.
     *
     * @param array $where
     *
     * @return int
     */
    public function deleteWhere(array $where)
    {
        $query = $this->conditions($where);
        
        $deleted = $query->delete();
        
        return $deleted;
    }
    
    /**
     * Delete entities by given multiple id's.
     *
     * @param array $id
     *
     * @return int
     */
    public function destroy($id)
    {
        if(!is_array($id)){
            $deleted = $this->delete($id);
        }else{
            $deleted = $this->model->destroy($id);
        }
        
        return $deleted;
    }
    
    /**
     * Check if entity has relation
     *
     * @param string $relation
     *
     * @return $this
     */
    public function has($relation)
    {
        $this->model = $this->model->has($relation);
        return $this;
    }
    
    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
    
    /**
     * Add subselect queries to count the relations.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }
    
    /**
     * Load relation with closure
     *
     * @param string $relation
     * @param closure $closure
     *
     * @return $this
     */
    public function whereHas($relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);
        return $this;
    }
    
    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);
        return $this;
    }
    
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }
    
    protected function conditions(array $where)
    {
        $query = $this->query();
        
        foreach ($where as $field => $value){
            if(is_array($value)){
                list($field, $condition, $val) = $value;
                $query->where($field, $condition, $val);
            }else{
                $query->where($field, '=', $value);
            }
        }
        
        return $query;
    }
    
    protected function reset()
    {
        $this->make();
    }
}
