<?php namespace jlourenco\blog\Models;

use Illuminate\Database\Eloquent\Model;
use jlourenco\support\Traits\Creation;

class BlogPost extends Model
{

    /**
     * To allow user actions identity (Created_by, Updated_by, Deleted_by)
     */
    use Creation;

    /**
     * {@inheritDoc}
     */
    protected $table = 'BlogPost';

    /**
     * The User model name.
     *
     * @var string
     */
    protected static $usersModel = 'jlourenco\base\Models\BaseUser';

    /**
     * The Blog category model name.
     *
     * @var string
     */
    protected static $categoryModel = 'jlourenco\blog\Models\BlogCategory';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'title',
        'contents',
        'category',
        'author',
        'likes',
        'shares',
        'views',
        'keywords'
    ];

    /**
     * Returns the user model.
     *
     * @return string
     */
    public static function getUsersModel()
    {
        return static::$usersModel;
    }

    /**
     * Sets the user model.
     *
     * @param  string  $usersModel
     * @return void
     */
    public static function setUsersModel($usersModel)
    {
        static::$usersModel = $usersModel;
    }

    /**
     * Returns the category model.
     *
     * @return string
     */
    public static function getCategoriesModel()
    {
        return static::$categoryModel;
    }

    /**
     * Sets the categories model.
     *
     * @param  string  $categoryModel
     * @return void
     */
    public static function setCategoriesModel($categoryModel)
    {
        static::$categoryModel = $categoryModel;
    }

    public function getAuthor()
    {
        return $this->belongsTo(static::$usersModel, 'author');
    }

    public function getCategory()
    {
        return $this->belongsTo(static::$categoryModel, 'category');
    }

}
