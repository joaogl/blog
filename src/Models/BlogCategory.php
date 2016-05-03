<?php namespace jlourenco\blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use jlourenco\support\Traits\Creation;
use jlourenco\support\Traits\Sluggable;

class BlogCategory extends Model
{

    /**
     * To allow user actions identity (Created_by, Updated_by, Deleted_by)
     */
    use Creation;

    use Sluggable;

    use SoftDeletes;

    /**
     * {@inheritDoc}
     */
    protected $table = 'BlogCategory';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    protected $dates = [ 'created_at', 'deleted_at'];

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
