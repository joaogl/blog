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

class CategoryController extends Controller
{

    /**
     * Declare the rules for the form validation
     *
     * @var array
     */
    protected $validationRules = array(
        'name'               => 'required|min:3',
        'slug'               => 'required|min:3|unique:BlogCategory,slug',
        'description'        => 'required|min:3',
    );

    /**
     * Show list of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Blog::getCategoriesRepository()->all();

        return view('admin.category.list', compact('cats'));
    }

    /**
     * Show details of a category,
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $cat = Blog::getCategoriesRepository()->findOrFail($id);

        // Show the page
        return View('admin.category.show', compact('cat'));
    }

    /**
     * Category update.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id = null)
    {
        $cat = Blog::getCategoriesRepository()->find($id);

        // Get the category information
        if($cat == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.category.not_found');

            // Redirect to the category management page
            return Redirect::route('categories')->with('error', $error);
        }

        // Show the page
        return View('admin.category.edit', compact('cat'));
    }

    /**
     * Category update form processing page.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function postEdit($id = null)
    {
        // Get the category information
        $cat = Blog::getCategoriesRepository()->find($id);

        if ($cat == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.category.not_found');

            // Redirect to the category management page
            return Redirect::route('admin.category.show')->with('error', $error);
        }

        $slug = str_slug(Input::get('name'), '_');

        unset($this->validationRules['slug']);
        $this->validationRules['slug'] = "required|min:3|unique:BlogCategory,slug,{$cat->slug},slug";

        $input = Input::all();
        $input['slug'] = $slug;

        // Create a new validator instance from our validation rules
        $validator = Validator::make($input, $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Update the category
        $cat->name = Input::get('name');
        $cat->slug = $slug;
        $cat->description = Input::get('description');

        // Was the category updated?
        if ($cat->save())
        {
            Base::Log('Category (' . $cat->name . ') was edited.');

            // Prepare the success message
            $success = Lang::get('blog.category.changed');

            // Redirect to the user page
            return Redirect::route('category.update', $id)->with('success', $success);
        }

        $error = Lang::get('blog.category.error');

        // Redirect to the category page
        return Redirect::route('category.update', $id)->withInput()->with('error', $error);
    }

    /**
     * Create new category
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        return View('admin.category.create');
    }

    /**
     * Category create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {
        $slug = str_slug(Input::get('name'), '_');

        $input = Input::all();
        $input['slug'] = $slug;

        // Create a new validator instance from our validation rules
        $validator = Validator::make($input, $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
                // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $cat = Blog::getCategoriesRepository()->findBySlug($slug);

        if ($cat != null)
            return Redirect::route("categories")->with('error', Lang::get('blog.category.already_exists'));

        $cat = Blog::getCategoriesRepository()->create([
            'name' => Input::get('name'),
            'slug' => $slug,
            'description' => Input::get('name'),
        ]);

        $cat->save();

        Base::Log('A new category (' . $cat->name . ') was created.');

        // Redirect to the home page with success menu
        return Redirect::route("categories")->with('success', Lang::get('blog.category.created'));
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

        $title = 'Delete category';
        $message = 'Are you sure to delete this category?';

        // Get category information
        $cat = Blog::getCategoriesRepository()->findOrFail($id);

        if ($cat == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.category.not_found');
            return View('layouts.modal_confirmation', compact('title', 'message', 'error', 'model', 'confirm_route'));
        }

        $confirm_route = route('delete/category', ['id' => $cat->id]);
        return View('layouts.modal_confirmation', compact('title', 'message', 'error', 'model', 'confirm_route'));
    }

    /**
     * Delete the given category.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function getDelete($id = null)
    {
        // Get category information
        $cat = Blog::getCategoriesRepository()->find($id);

        if ($cat == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.category.not_found');

            // Redirect to the category management page
            return Redirect::route('categories')->with('error', $error);
        }

        Base::Log('Category (' . $cat->name . ') was deleted.');

        // Delete the category
        $cat->delete();

        // Prepare the success message
        $success = Lang::get('blog.category.deleted');

        // Redirect to the category management page
        return Redirect::route('categories')->with('success', $success);
    }

    /**
     * Show a list of all the deleted categories.
     *
     * @return View
     */
    public function getDeletedCategories()
    {
        // Grab deleted categories
        $cats = Blog::getCategoriesRepository()->onlyTrashed()->get();

        // Show the page
        return View('admin.category.deleted', compact('cats'));
    }

    /**
     * Restore a deleted category.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function getRestore($id = null)
    {
        // Get category information
        $cat = Blog::getCategoriesRepository()->withTrashed()->find($id);

        if ($cat == null)
        {
            // Prepare the error message
            $error = Lang::get('blog.category.not_found');

            // Redirect to the category management page
            return Redirect::route('category.deleted')->with('error', $error);
        }

        Base::Log('Category (' . $cat->name . ') was restored.');

        // Restore the category
        $cat->restore();

        // Prepare the success message
        $success = Lang::get('blog.category.restored');

        // Redirect to the category management page
        return Redirect::route('categories.deleted')->with('success', $success);
    }

}
