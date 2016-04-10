<?php namespace jlourenco\blog\Models;

use Illuminate\Database\Eloquent\Model;
use jlourenco\support\Traits\Creation;

class BlogCategory extends Model
{

    /**
     * To allow user actions identity (Created_by, Updated_by, Deleted_by)
     */
    use Creation;

    /**
     * {@inheritDoc}
     */
    protected $table = 'BlogCategory';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The Blog post model name.
     *
     * @var string
     */
    protected static $postsModel = 'jlourenco\blog\Models\BlogPost';

    /**
     * Returns the post model.
     *
     * @return string
     */
    public static function getPostsModel()
    {
        return static::$postsModel;
    }

    /**
     * Sets the post model.
     *
     * @param  string  $postsModel
     * @return void
     */
    public static function setPostsModel($postsModel)
    {
        static::$postsModel = $postsModel;
    }

    public function posts()
    {
        return $this->hasMany(static::$postsModel, 'category');
    }

}
