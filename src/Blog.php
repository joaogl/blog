<?php namespace jlourenco\blog;

use jlourenco\blog\Repositories\BlogPostRepositoryInterface;
use jlourenco\blog\Repositories\BlogCategoryRepositoryInterface;

class Blog
{

    /**
     * The Post repository.
     *
     * @var \jlourenco\blog\Repositories\BlogPostRepositoryInterface
     */
    protected $posts;

    /**
     * The Category repository.
     *
     * @var \jlourenco\blog\Repositories\BlogCategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Create a new Blog instance.
     *
     * @param  \jlourenco\blog\Repositories\BlogPostRepositoryInterface  $posts
     * @param  \jlourenco\blog\Repositories\BlogCategoryRepositoryInterface  $categories
     */
    public function __construct(BlogPostRepositoryInterface $posts, BlogCategoryRepositoryInterface $categories)
    {
        $this->categories = $categories;
        $this->posts = $posts;
    }

    /**
     * Returns the posts repository.
     *c
     * @return \jlourenco\blog\Repositories\BlogPostRepositoryInterface
     */
    public function getPostsRepository()
    {
        return $this->posts;
    }

    /**
     * Sets the posts repository.
     *
     * @param  \jlourenco\blog\Repositories\BlogPostRepositoryInterface $posts
     * @return void
     */
    public function setPostsRepository(BlogPostRepositoryInterface $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Returns the categories repository.
     *c
     * @return \jlourenco\blog\Repositories\BlogCategoryRepositoryInterface
     */
    public function getCategoriesRepository()
    {
        return $this->categories;
    }

    /**
     * Sets the categories repository.
     *
     * @param  \jlourenco\blog\Repositories\BlogCategoryRepositoryInterface $categories
     * @return void
     */
    public function setCategoriesRepository(BlogCategoryRepositoryInterface $categories)
    {
        $this->categories = $categories;
    }

}
