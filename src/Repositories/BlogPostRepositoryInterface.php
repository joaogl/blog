<?php namespace jlourenco\blog\Repositories;

interface BlogPostRepositoryInterface
{

    /**
     * Finds a post by the given primary key.
     *
     * @param  int  $id
     * @return \jlourenco\blog\Models\BlogPost
     */
    public function findById($id);

    /**
     * Finds a post by the given name.
     *
     * @param  string  $title
     * @return \jlourenco\blog\Models\BlogPost
     */
    public function findByTitle($title);

}
