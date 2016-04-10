<?php namespace jlourenco\blog\Facades;

use Illuminate\Support\Facades\Facade;

class Blog extends Facade
{

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'blog';
    }

}
