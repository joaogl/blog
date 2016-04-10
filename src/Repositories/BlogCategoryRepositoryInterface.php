<?php namespace jlourenco\blog\Repositories;

interface BlogCategoryRepositoryInterface
{

    /**
     * Finds a blog category by the given primary key.
     *
     * @param  int  $id
     * @return \jlourenco\blog\Models\BlogCategory
     */
    public function findById($id);

    /**
     * Finds a blog category by the given name.
     *
     * @param  string  $name
     * @return \jlourenco\blog\Models\BlogCategory
     */
    public function findByName($name);

}
