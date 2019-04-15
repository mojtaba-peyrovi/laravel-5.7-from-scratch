### What I'm Learning or Reviewing:
---

__Episode 4:__

When we yield the section, we can pass the second parameter for the default name. When the yeild doesn't get any value from the section in the view, it returns the default value:
```
@yield('title','Laracasts')  
// anytime there is no value for title, it prints Laracasts by default.
```
Instead of having the whole section for title for example, and close the section all the time, we can pass the value as the second parameter. 
```
@section('title','Contact Us')
```
__Episode 5:__ We can pass data into the view by passing a list of values. values can come from a request() coming from the query string:
```
Route: 'foo' => request('title')
Browser: localhost:8000/?title=moji
view: <h1>Hello {{foo}}
 ``` 
 The combination above, returns Hello moji on the view.
 
 Another syntax for passing data into the view is:
 ```
 return view('welcome')->withTasks($tasks)
```
__Episode 7:__ It is better to use:
```
php artisan migrate:fresh
```
instead of 
```
php artisan migrate:refresh
```
Before any artisan command we can use Help to see how to use it, for example:
```
php artisan help make:migration 
```
__Episode 8:__ For addressing all the titles of all items in a collection, we can use map:
```
App\Project::all()->map->title;  // returns all titles
```
__Episode 12:__ When sending patch (for editing) we have to use POST request but in the edit form we add this:
```
{{ method_field('PATCH') }}  
or
<input type="hidden" name="_method" value="PATCH">
```
There is a shortcut for the above method specification:
```
@method('DELETE")
```
and also for csrf token there is a shortcut:
```
instead of:
{{ csrf_field() }}
just say:
@csrf
```
__NOTE:__ When we have find($id) if the id doesn't exist, the app breaks. In order to prevent this:
```
instead of find($id)  ==> say: findOrFail($id)
```
__Episode 14:__ by default, when we do route-model-binding, it works well for when the show method url works with id, but sometimes we want to work with slug. [Here](https://laravel.com/docs/5.8/routing) is what we do.

- when we want to store, we can write in in traditional way as we learned before:
```
Project::create([
    'title' => reqiest('title'),
    'description' => request('description')
]);
```

A better way of doing it is:
```
Project::create(request(['title','description']));
```
- The same thing is true for updating:
```
$peoject->update(request(['title','description']));
```
__Episode 15:__ When we want to have multiple validation rules, we used to use pipe (|) to separate them, but better to use them as an array. like this:
```
'title' => ['required','min:3']
```
__REMINDER:__ for saving the old value after validation failed, we use:
```
<input name="title"..... value="{{ old('title')">
<textarea name="description" ...... > {{ old('description') }} <textarea<
```
__Refactor:__ When the input fields pass the validation, we can directly pass them to create functions. 
It means, instead of this:
```
 request()->validate([
           'title' => ['required','min:3','max:255'],
           'description' => ['required','min:3']
        ]);
        Project::create(request(['title','description']));
```

we can say:
```
 $validated = request()->validate([
           'title' => ['required','min:3','max:255'],
           'description' => ['required','min:3']
        ]);
        Project::create($validated);
```
__Episode 16:__ When we define a relationship inside the model, we create a method but when we want to call the relationship, we can call it as a property. like this:
```
in Project model:  
public funtion tasks()
{
    return $this->hasMany(Task::class);
}
```
and when we want to call tasks of a project we say:
```
App\Project::first()->tasks;
```

But when we have further chains, we have to use tasks as a method:
```
App\Project::first()->tasks()->id
```

__Episode 17:__ We can have the checkbox to be submitting the form automatically without having any submit button. here is the trick:
```
<input type="checkbox" name="completed" onchange="this.form.submit()">
```
In this episode he showed a very nice way of dealing with checkboxes in forms.

__Episode 18:__ A great way of refactoring eloquent models. We want to add tasks to a project. we could do it traditionally. but we defined a method in Project model called addTask() so that we could call it from Project model. Here is the method:
```
public function addTask($description)
{
    return Task::create([
        'project_id' => $this->id,
        'description' => $description 
    ]);
}
```
But also better than this we can say:
```
public function addTask()
{
    $this->task()->create(compact('description'));
}
```
__Episode 21:__ We have a cool feature in Laravel that we can declare any class we want inside a method, and it will be available. for example:
```
user Illuminate/Filesystem/Filesystem
public function show(Filesystem $file)
    {
        dump($file);
    }
```
When we run the code, we will see that the instance of Filesystem class will be available through the controller. 
All this is done behind the scene using two different concepts:

1) __Auto Resolving:__ When we use the Reflection API, and mention the class we need, auto resolving is a task of looking for the class name inside __Service Containers__ to see if there is a class with this name and brings it back to us.

2) __Service Containers:__ Laravel itself is a service container. and we can use it simply by this function app(). 

For example inside the routes/web.php we can call Filesystem class (as an example) when the app root is called:
```
use Illuminate/Filesystem/Filesystem

Route::get('/', function()
    {
        dd(app(Filesystem::class));
    });
```
Or other example is, when we bind a class to the app() it means that we are binding the class to the service container. if we say:
```
app()->bind('project', function(){
    return new \App\Project;     //project is the name of a model
});
```
and then we run the closure for the app root again:
```
Route::get('/', function()
    {
        dd(app('project'));
    });
```
and it returns in instance of Project model, which is a class under app directory.

__Binding:__ It is a way to put something into the service container.
 __Singleton:__ Anytime we want to have the exact instance of the class anytime we instantiate, we use singleton instead of bind:
 ```
 app()->singleton('project', function(){
    return new \App\Project;
 });
```
It means the code : `new \App\Project` only runs once. Anytime it runs again, it will just fetch the existing instance.

__Episode 22: Service Providers:__

inside `config/app.php` under `Autoloaded Service Providers` we can see the list of registered service providers in the app.

These service providers are building blocks of the framework.
When we scroll to this path:
```
vendor/laravel/framework/src/illuminate/
```
we can see the list of all components of the laravel app. and if we get into any of these folders, we see each one has a serviceProvider.

Each serviceProvider has two method, register, boot:

1) Register is where can bind anything into the service container:
```
public function register() {
    $this->app->bind('foo' , function() {
        return 'bar'
    });
};
``` 
Then for example in the routes/web.php file we can return the value of bar by calling the key foo.
```
Route::get('/', function() {
    dd(app('foo'));
});    // returns 'bar'
```
For each item in `config/app` as service providers, Laravel loads the associated file.
Inside `config/app` There are two sections dedicated to serviceProviders:
- Laravel Framework Service Providers...
- Application Service Providers...

Register() method, is going to fire for any service provider that is registered under 'Framework Service Providers'.

However, sometimes we want to do something assuming the rest of the framework is loaded up already. Here is when we use boot() method.

__REVIEW:__ for each provider under 'Laravel Framework Service Providers', Laravel is going to loop over and call the register method. Once this process in done, laravel is going to do this one more time, and call the boot method. Therefore, we can add anything to the boot() method and it wil be running when boot method is fired.

When there are too many components to be added to the register() method, it's better to create dedicated serviceProviders for each specific component. 
#####IMPROTANT:
Don't forget to declare the serviceProvider inside `config/app` under `Application Service Provider`. Otherwise Laravel doesn't run the provider.
 
__Episode 23 - Configurations:__
under `config` folder, we have different configurations related to mail, auth, database, etc.

__env() helper:__ It's related to the super global variable __$_ENV.__ Anytime the framework loads, Laravel reads all variables inside `.env`  file and saves them as __$_ENV__ variable.

The env() helper, takes two parameters, ('the key','substitute'). first variable say, go and look inside .env file and if the key existed, return the value of it, and second parameter says if it didn't exist, what value to use.

Don't forget, any installation of the app has its own .env file. for example, it is on a local server, APP_DEBUG will be true, APP_ENV will be local, whereas in production APP_DEBUG will be false, and APP_ENV will be production, also the mailing values will be different, storage could be cloud instead of a local file.

__config() helper:__ When we need to read some variable from any `config` file, we use this helper. 

Example: for the twitter class we made the last time, we want to provide the api-key. Here is what we did in `socialServiceProvider` under `register` method:
```
public function register()
{
    $this->app->singleton(Twitter::class, funciton() {
        return new Twitter('api-key');
    });
}
```
Now because we don't want to hard-code the api-key, we can use config() to read it from `services` config file:
```
public function register()
{
    $this->app->singleton(Twitter::class, funciton() {
        return new Twitter(config('services.twitter.secret'));
    });
}
```
Here is what we add at the end of services config file, for Twitter api-key:
```
'twitter' => [
    'key' => 'public-key',
    'secret' => 'private-key'
]
```
 We used dot notation because the values in services file are in arrays and to access inside layers of key-value pairs we have to use dot notations.
 
 And we can call Twitter class on `web.php` on root and it has to return the Twitter class instance with the secret api-key:
 ```
 
Route::get('/', function (Twitter $twitter) {
    dd($twitter);
    return view('welcome');
});

```
 But now, we don't want the api-keys to be saved inside `services` file as well. Instead of that, we save them inside .env file and reference them at `services` like this:
```
'twitter' => [
    'key' => env('TWITTER_KEY'),
    'secret' => env('TWITTER_SECRET')
] 
```
Then in .env file:
```
TWITTER_KEY = 'public-key'
TWITTER_SECRET = 'private-key'
```
We can also make a dedicated config file for anything we want, and just create an array of settings like any other config file.

__Config Cache Clear:__ It creates a single config file by merging all config files, and it makes loading the config variables faster. Sometimes we change the value in .env file, but it doesn't reflect on the app immediately. Then a cache clear for config file can solve it. like this:
```
php artisan config:cache
```
The rule is, we don't care for development phase to clear the cache. It is only for production phase.

__Episode 24:__
When we run:
```
php artisan make:auth
```
The controllers added can be customized to the project. for example in `RegisterController`, under `create` method all the fields we want have to match the `user` migration file.

__Episode 25- Middelware:__
The application starts with Middlewares. It means for each request to the website, first thing that runs, will be middlewares. Middlewares are like onion layers. In order to see all the onion layers, we have to go to this path:
```
app/Http/Middleware/kernel.php
``` 
under `protected $middelware = [];` we see the list of all middlewares(onion layers) inside the list.

Each layer has the ability to provide different checks. For example, here is the authentication middleware:
```
app/Http/Middleware/Authentication.php
```
It extends this file:
```
vendor/laravel/framework/src/illuminate/Auth/Middleware/Authenticate
```
When we open this file, we see a method called `handle()`. Every middleware has this method. Here is where we receive a request, review it, modify it, redirect somewhere else, or if anything works as expected, it will be passed on to the next layer of the onion. for authenticate case looks like this:
```
public function handle($request, Closure $next, ...$guards)
{
    $this->authenticate($request, $guards);
    
    return $next($request);
}
```
At the bottom of the `authenticate` file, we have `authenticate` method that simply says, authenticate each request, and if it didn't pass, return exception error.

In `Middleware/Kernel` file, we can see the address for authenticate file, and the alias associated with it is called `auth`. 

When we see the construct function inside `app/Http/Controllers/HomeController` we see it says:
```
public function __construct() {
    $this->middleware('auth');
};
``` 
This `auth` matches to the alias we defined at kernel.

We can use auth middleware in two different ways:

1) as the construct of controllers
2) at the end of the route functions inside routes/web.php file

example for the second options is:
```
Route::get('/','HomeController@index)->middleware('auth');
```
If for any route we don't want the user already signed in, to access it, we can use:
```
Route::get('/','HomeController@index)->middleware('guest')
```
__Note:__ Sometimes we want to make a new middleware. we can do it this way:
```
php artisan make:middleware <middleware_name>
``` 
This will be running anytime any request will be made to the website. As an example, we can make a middleware called __logQueries__ to record all queries to the website. 

After making the middleware, it doesn't work, until we register it inside `kernel`.

There are two types of middleware:
1) Global middleware: we can see the list of them on the top of the `kernel` file. And they run for every single request.
2) Route middleware: we can see them at the bottom of the `kernel`. They will run only when we request them using aliases.

__Episode 26:__ auth() helper function:

It returns information about the authenticated user:

- auth()->id()  ==> returns autheticated user's id
- auth()->user() ==> returns the instance of the auth user
- auth()->check() ==> returns a boolean and tell whether the user is authenticated
- auth()->guest() ==> returns boolean for the case the user is a guest

In order to specify foreign key in migration file, we do this way:
```
$table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
```
OnDelete('cascade') means when the user is deleted, delete all their related projects, or posts.

We can add(append) a field to the create method:
```
Project::create($validated + ['owner_id' => auth()->id());
```
__Episode 27:__  When we want to say, if the user is not the one who created it, won't be able to see the post:
```
public function show() 
{
    if($project->owner_id !== auth()->id())
        abort(403)
}
```
There is a helper function for it:
```
public function show()
{
    abort_if($project->owner_id !== auth()->id(), 403);
}
```
There is another way to do it by using __Policy__ classes.
We make them like this:
```
php artisan make:policy modelNamePolicy --model=modelName
i.e.
php artisan make:policy ProjectPolicy --model=Project
```
The class will be made under `app/Policies` folder.

Now we are getting the full boilerplate for all methods related to each crud actions for Project model.

Now inside methods we can define our policies separately. for example under view method:
```
public function view(User $user, Project $project)
    {
        return $project->owner_id == $user->id;
    }
```
But setting up the policy is not enough. We need to register them inside `AuthServiceProvider.php`
```
protected $policies = [
        'App\Project' => 'App\Policies\ProjectPolicy',
    ];
```
Now we just need to do this line inside show() method at the controller:
```
$this->authorize('view', $project);
```
For cases where the logic for all crud actions is the same we can get rid of all methods and keep one `update`.
Also we will have to update what we said in authorize() from `view` to `update`.

For cases where we want to define policies for `guest users`, we need to add ? behind the User injected into update policy:
```
public function update(?User $user, Project $project)
    {
        return $project->owner_id == $user->id;
    }
```
Another alternative for this is using __Gate facade.__ like this:
```
if(\Gate::denies('update',$projects)) 
{
    abort(403);
}
```
Or 
```
abort_if(\Gate::denies('update', $project), 403);
or
abort_unless(\Gate::allows('update', $project), 403);
```
Also we can do it using middleware in routes/web.php
```
Route::resource('projects', 'ProjectsController')->middleware('can:update, project');
```
This: `'can:update, project'` is the string form of `'can('update', $project)`.

There is another option which is inside blade template:
```
@can('update', $project)
    <a href='/edit'>Edit</a>
@endcan
```    
Sometimes we want to grant the admin to a specific user. In this case we can get into `AuthServiceProvider` and inside `boot` method:
```

```
