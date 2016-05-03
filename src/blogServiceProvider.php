<?php namespace jlourenco\blog;

use Illuminate\Support\ServiceProvider;
use jlourenco\blog\Repositories\BlogCategoryRepository;
use jlourenco\blog\Repositories\BlogPostRepository;

class blogServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->prepareResources();
        $this->registerBlogCategory();
        $this->registerBlogPost();
        $this->registerBlog();
        $this->registerToAppConfig();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        // Publish our views
        $this->loadViewsFrom(base_path("resources/views"), 'base');
        $this->publishes([
            __DIR__ .  '/views' => base_path("resources/views")
        ]);

        // Publish our lang
        $this->publishes([
            __DIR__ .  '/lang' => base_path("resources/lang")
        ], 'migrations');

        // Publish our migrations
        $this->publishes([
            __DIR__ .  '/migrations' => base_path("database/migrations")
        ], 'migrations');

        // Publish a config file
        $this->publishes([
            __DIR__ . '/config' => base_path('/config')
        ], 'config');

        // Publish our routes
        $this->publishes([
            __DIR__ .  '/routes.php' => base_path("app/Http/blog_routes.php")
        ], 'routes');

        // Include the routes file
        if(file_exists(base_path("app/Http/blog_routes.php")))
            include base_path("app/Http/blog_routes.php");
    }

    /**
     * Registers the blog posts.
     *
     * @return void
     */
    protected function registerBlogPost()
    {
        $this->app->singleton('jlourenco.blog.post', function ($app) {
            $baseConfig = $app['config']->get('jlourenco.base');
            $config = $app['config']->get('jlourenco.blog');

            $model = array_get($config, 'models.BlogPost');
            $users = array_get($baseConfig, 'models.User');
            $categories = array_get($config, 'models.BlogCategory');

            if (class_exists($model) && method_exists($model, 'setUsersModel'))
                forward_static_call_array([$model, 'setUsersModel'], [$users]);

            if (class_exists($model) && method_exists($model, 'setCategoriesModel'))
                forward_static_call_array([$model, 'setCategoriesModel'], [$categories]);

            return new BlogPostRepository($model);
        });
    }

    /**
     * Registers the blog posts.
     *
     * @return void
     */
    protected function registerBlogCategory()
    {
        $this->app->singleton('jlourenco.blog.category', function ($app) {
            $config = $app['config']->get('jlourenco.blog');

            $model = array_get($config, 'models.BlogCategory');
            $posts = array_get($config, 'models.BlogPost');

            if (class_exists($model) && method_exists($model, 'setPostsModel'))
                forward_static_call_array([$model, 'setPostsModel'], [$posts]);

            return new BlogCategoryRepository($model);
        });
    }

    /**
     * Registers log.
     *
     * @return void
     */
    protected function registerBlog()
    {
        $this->app->singleton('blog', function ($app) {
            $blog = new Blog($app['jlourenco.blog.post'], $app['jlourenco.blog.category']);

            return $blog;
        });

        $this->app->alias('blog', 'jlourenco\blog\Blog');
    }

    /**
     * Registers this module to the
     * services providers and aliases.
     *
     * @return void
     */
    protected function registerToAppConfig()
    {
        /*
         * Create aliases for the dependencies.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Blog', 'jlourenco\blog\Facades\Blog');
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'jlourenco.blog.post',
            'jlourenco.blog.category',
            'blog'
        ];
    }

}