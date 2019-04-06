### What I'm Learning:
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
