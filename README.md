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
 
 
