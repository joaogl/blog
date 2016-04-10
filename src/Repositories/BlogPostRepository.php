<?php namespace jlourenco\blog\Repositories;

use Cartalyst\Support\Traits\RepositoryTrait;

class BlogPostRepository implements BlogPostRepositoryInterface
{
    use RepositoryTrait;

    /**
     * The Blog post model name.
     *
     * @var string
     */
    protected $model = 'jlourenco\blog\Models\BlogPost';

    /**
     * Create a new blog post repository.
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
    public function findByTitle($title)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->where('title', $title)
            ->first();
    }

}
