<?php namespace jlourenco\blog\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Blog;
use Sentinel;
use DB;
use Searchy;

class BlogController extends Controller
{

    /**
     * Show the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Blog::getPostsRepository()->all();
        $categories = Blog::getCategoriesRepository()->all();

        return view('public.blog.list', compact('posts', 'categories'));
    }

    public function edit($id)
    {
        $post = Blog::getPostsRepository()->findOrFail($id);

        return view('public.blog.edit', compact('post'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [ 'value' => 'required' ]);

        $move = Blog::getPostsRepository()->findOrFail($id);

        $move->update($request->all());

        return redirect('blog');
    }

    public function show($id)
    {
        $post = Blog::getPostsRepository()->findOrFail($id);
        $categories = Blog::getCategoriesRepository()->all();

        // Show the page
        return View('public.blog.post', compact('post', 'categories'));
    }

    public function showByCategory($id)
    {
        $category = Blog::getCategoriesRepository()->findOrFail($id);
        $posts = $category->posts;
        $categories = Blog::getCategoriesRepository()->all();

        // Show the page
        return view('public.blog.list', compact('posts', 'categories'));
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

    /*
     * Admin section
     */
    public function getAdminIndex()
    {
        // Grab all the users
        $posts = Blog::getPostsRepository()->all();

        // Show the page
        return View('admin.blog.list', compact('posts'));
    }

}
