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
