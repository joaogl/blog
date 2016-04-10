<?php namespace jlourenco\blog\Repositories;

use Cartalyst\Support\Traits\RepositoryTrait;

class BlogCategoryRepository implements BlogCategoryRepositoryInterface
{
    use RepositoryTrait;

    /**
     * The Blog category model name.
     *
     * @var string
     */
    protected $model = 'jlourenco\blog\Models\BlogCategory';

    /**
     * Create a new blog category repository.
     *
     * @param  string  $model
     */
    public function __construct($model = null)
    {
        if (isset($model))
            $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findByName($name)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->where('name', $name)
            ->first();
    }

}
