<?php namespace jlourenco\blog\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Blog;
use Sentinel;
use Searchy;
use Validator;
use Input;
use Base;
use Redirect;
use Lang;

class PostController extends Controller
{

    /**
     * Declare the rules for the form validation
     *
     * @var array
     */
    protected $validationRules = array(
        'title'               => 'required|min:3',
        'slug'               => 'required|min:3|unique:BlogPost,slug',
        'category'        => 'required|exists:BlogCategory,id',
        'author'            => 'required|exists:User,id',
        'contents'        => 'required|min:3',
    );

    /**
     * Show list of posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Blog::getPostsRepository()->all();

        return view('admin.posts.list', compact('posts'));
    }

    /**
     * Show details of a post,
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $post = Blog::getPostsRepository()->findOrFail($id);

        // Show the page
        return View('admin.posts.show', compact('post'));
    }

    /**
     * Post update.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id = null)
    {
        $post = Blog::getPostsRepository()->find($id);

        // Get the post information
        if($post == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.posts.not_found');

            // Redirect to the post management page
            return Redirect::route('posts')->with('error', $error);
        }

        $cats = null;
        $users = null;

        $categories = Blog::getCategoriesRepository()->all(['id', 'name']);
        $authors = Sentinel::createModel()->all(['id', 'first_name', 'last_name']);

        foreach ($categories as $cat)
            $cats[$cat->id] = $cat->name;

        foreach ($authors as $author)
            $users[$author->id] = $author->first_name . ' ' . $author->last_name;

        // Show the page
        return View('admin.posts.edit', compact('post', 'cats', 'users'));
    }

    /**
     * Post update form processing page.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function postEdit($id = null)
    {
        // Get the post information
        $post = Blog::getPostsRepository()->find($id);

        if ($post == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.posts.not_found');

            // Redirect to the post management page
            return Redirect::route('admin.posts.show')->with('error', $error);
        }

        unset($this->validationRules['slug']);
        $this->validationRules['slug'] = "required|min:3|unique:BlogPost,slug,{$post->slug},slug";

        $slug = str_slug(Input::get('title'), '_');

        $input = Input::all();
        $input['slug'] = $slug;

        // Create a new validator instance from our validation rules
        $validator = Validator::make($input, $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Update the post
        $post->title = Input::get('title');
        $post->slug = $slug;
        $post->author = Input::get('author');
        $post->category = Input::get('category');
        $post->contents = Input::get('contents');

        // Was the post updated?
        if ($post->save())
        {
            Base::Log('Post (' . $post->id . ') was edited.');

            // Prepare the success message
            $success = Lang::get('blog.posts.changed');

            // Redirect to the user page
            return Redirect::route('posts')->with('success', $success);
        }

        $error = Lang::get('blog.posts.error');

        // Redirect to the post page
        return Redirect::route('post.update', $id)->withInput()->with('error', $error);
    }

    /**
     * Create new post
     *
     * @return View
     */
    public function getCreate()
    {
        $cats = null;
        $users = null;

        $categories = Blog::getCategoriesRepository()->all(['id', 'name']);
        $authors = Sentinel::createModel()->all(['id', 'first_name', 'last_name']);

        foreach ($categories as $cat)
            $cats[$cat->id] = $cat->name;

        foreach ($authors as $author)
            $users[$author->id] = $author->first_name . ' ' . $author->last_name;

        // Show the page
        return View('admin.posts.create', compact('cats', 'users'));
    }

    /**
     * Post create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {
        $slug = str_slug(Input::get('title'), '_');

        $input = Input::all();
        $input['slug'] = $slug;

        // Create a new validator instance from our validation rules
        $validator = Validator::make($input, $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $post = Blog::getPostsRepository()->findBySlug($slug);

        if ($post != null)
            return Redirect::route("posts")->with('error', Lang::get('blog.posts.already_exists'));

        $post = Blog::getPostsRepository()->create([
            'title' => Input::get('title'),
            'slug' => $slug,
            'author' => Input::get('author'),
            'category' => Input::get('category'),
            'keywords' => Input::get('keywords'),
            'contents' => Input::get('contents'),
            'likes' => 0,
            'shares' => 0,
            'views' => 0,
        ]);

        $post->save();

        Base::Log('A new post (' . $post->id . ') was created.');

        // Redirect to the home page with success menu
        return Redirect::route("posts")->with('success', Lang::get('blog.posts.created'));
    }

    /**
     * Delete Confirm
     *
     * @param   int   $id
     * @return  View
     */
    public function getModalDelete($id = null)
    {
        $confirm_route = $error = null;

        $title = 'Delete post';
        $message = 'Are you sure to delete this post?';

        // Get post information
        $post = Blog::getPostsRepository()->findOrFail($id);

        if ($post == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.posts.not_found');
            return View('layouts.modal_confirmation', compact('title', 'message', 'error', 'model', 'confirm_route'));
        }

        $confirm_route = route('delete/post', ['id' => $post->id]);
        return View('layouts.modal_confirmation', compact('title', 'message', 'error', 'model', 'confirm_route'));
    }

    /**
     * Delete the given post.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function getDelete($id = null)
    {
        // Get post information
        $post = Blog::getPostsRepository()->find($id);

        if ($post == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.posts.not_found');

            // Redirect to the post management page
            return Redirect::route('posts')->with('error', $error);
        }

        Base::Log('Post (' . $post->id . ') was deleted.');

        // Delete the post
        $post->delete();

        // Prepare the success message
        $success = Lang::get('blog.posts.deleted');

        // Redirect to the post management page
        return Redirect::route('posts')->with('success', $success);
    }

    /**
     * Show a list of all the deleted posts.
     *
     * @return View
     */
    public function getDeletedCategories()
    {
        // Grab deleted posts
        $posts = Blog::getPostsRepository()->onlyTrashed()->get();

        // Show the page
        return View('admin.posts.deleted', compact('posts'));
    }

    /**
     * Restore a deleted post.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function getRestore($id = null)
    {
        // Get post information
        $post = Blog::getPostsRepository()->withTrashed()->find($id);

        if ($post == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.posts.not_found');

            // Redirect to the post management page
            return Redirect::route('post.deleted')->with('error', $error);
        }

        Base::Log('Post (' . $post->id . ') was restored.');

        // Restore the post
        $post->restore();

        // Prepare the success message
        $success = Lang::get('blog.posts.restored');

        // Redirect to the post management page
        return Redirect::route('posts.deleted')->with('success', $success);
    }

}
