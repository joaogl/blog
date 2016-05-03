<?php namespace jlourenco\blog\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Blog;
use Sentinel;
use DB;
use Searchy;
use Validator;
use Input;
use Comments;
use Base;
use Lang;
use Redirect;

class BlogController extends Controller
{

    /**
     * Declare the rules for the form validation
     *
     * @var array
     */
    protected $validationRules = array(
        'comment'               => 'required|min:3',
    );

    /**
     * Show the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Blog::getPostsRepository()->OrderBy('created_at')->get();
        $categories = Blog::getCategoriesRepository()->OrderBy('created_at')->get();
        $subTitle = null;

        return view('public.blog.list', compact('posts', 'categories', 'subTitle'));
    }

    public function show($id)
    {
        $post = Blog::getPostsRepository()->findOrFail($id);
        $categories = Blog::getCategoriesRepository()->OrderBy('created_at')->get();

        // Show the page
        return View('public.blog.post', compact('post', 'categories'));
    }

    public function showByCategory($id)
    {
        $category = Blog::getCategoriesRepository()->findOrFail($id);
        $posts = $category->posts;
        $categories = Blog::getCategoriesRepository()->OrderBy('created_at')->get();
        $subTitle = $category->name;

        // Show the page
        return view('public.blog.list', compact('posts', 'categories', 'subTitle'));
    }

    public function search($in)
    {
        // Setting up vars
        $search = $in;
        $terms = explode(' ', $search);
        array_push($terms, $search);

        // Checking the users
        /*
        $users = $this->applySearch(Sentinel::createModel(), $terms, ['first_name', 'last_name'])->join('BlogPost', 'User.id', '=', 'BlogPost.author')
            ->select(DB::raw('CONCAT(User.first_name, " ", User.last_name) AS a'), DB::raw('\'User\' AS type'))->distinct()->get()->toArray();

        $users = $this->evaluate($users, $terms, ['first_name', 'last_name']);*/

        $users = Sentinel::createModel()->search($in)
            /*->distinct()*/->select(DB::raw('CONCAT(User.first_name, " ", User.last_name) AS a'), DB::raw('\'User\' AS type'))->get()->toArray();

        dd($users);

        // Checking the posts
        $posts = $this->applySearch(Blog::getPostsRepository(), $terms, ['title', 'contents', 'keywords'])->select('title as a', DB::raw('\'Post\' AS type'))->distinct()->get()->toArray();

        // Checking the Categories
        $categories = $this->applySearch(Blog::getCategoriesRepository(), $terms, ['name', 'description'])->select('name as a', DB::raw('\'Category\' AS type'))->distinct()->get()->toArray();

        // Returning the results
        return response()->json( [ 'data' => array_merge($users, $categories, $posts) ] );
    }

    public function applySearch($repo, $terms, $fields)
    {
        foreach($terms as $term)
            foreach($fields as $field)
                $repo = $repo->orWhere($field, 'LIKE', '%' . $term . '%');

        foreach($repo as $data)
        {
            dd($repo);
        }
        dd($repo);

        return $repo;
    }

    public function evaluate($repo, $terms, $fields)
    {

        return $repo;
    }

    /**
     * Post comment form processing.
     *
     * @return Redirect
     */
    public function postComment($id)
    {
        // Get the post information
        $post = Blog::getPostsRepository()->find($id);

        if ($post == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.posts.not_found');

            // Redirect to the post management page
            return Redirect('blog')->with('error', $error);
        }

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Create the comment
        $c = Comments::getCommentsRepository()->createModel();

        $c->parent = null;
        $c->comment = Input::get('comment');

        // Was the post updated?
        if ($post->comments()->save($c))
        {
            Base::Log('Comment added to (' . $post->id . ').');

            // Prepare the success message
            $success = Lang::get('blog.comment.created');

            // Redirect to the user page
            return Redirect('blog/' . $post->id)->with('success', $success);
        }

        $error = Lang::get('blog.comment.error');

        // Redirect to the post page
        return Redirect('blog/' . $post->id)->withInput()->with('error', $error);
    }
    
}
