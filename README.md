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

