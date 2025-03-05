Laravel Blade snippers, check file associations for "*.blade.php": "blade"
make sure to have PHP, Composer, NPM, Laravel, Herd, TablePlus all installed
no XAMPP needed, and make sure no XAMPP processes are running in the background
select a project folder, then type "{project_folder_name}.test" or 'php artisan serve' in the CLI

php artisan (shows all options)
----------------------------------------
if database changes doesn't reflect in the TablePlus, restart the app
terminal commands:
php artisan migrate:fresh (drops all tables and rebuilds the entire db; good for when modifying table)
php artisan make:migration (creates a table; e.g. create_job_listings_table (table will be named, 'job_listings'))
php artisan migrate (after making a migration, do this then refresh TablePlus)
----------------------------------------
when naming a Model, it should be Singular
for example, for a table named, 'job_listings', the model name should be 'JobListing'
or just indicate the table in the Model if there's a name conflict
----------------------------------------
php artisan tinker (Laravel playground)
try these Eloquent ORM queries in the terminal:
App\Models\Job::create(['title' => 'Acme Director', 'salary' => '$1,000,000']); (will cause an error, add fillables in the model)
App\Models\Job::all(); (inspec all entries)
App\Models\Job::find(4); (try to find an entry)

$job = App\Models\Job::find(1);
$job->delete();
----------------------------------------
php artisan help make (adding 'help' before the command gives all possible options for a command)
make models:
php artisan make:model Comment (creates Comment.php in the model)
php artisan make:model Post -m (creates Post.php in the model and corresponding migration file)
----------------------------------------
factories (used for testing, e.g. creating 50 users/jobs automatically, the Model should have 'HasFactory')
in tinker:
(the UserFactory definition table should match with the User migration table which we tweaked at first)

App\Models\User::factory()->create(); // add 'firstName' and 'lastName' in the UserFactory.php

restart the tinker then run the command again
App\Models\User::factory(100)->create(); // 100 users

in the example>
php artisan make:factory JobFactory (creates factory for Job model)
in the tinker:
App\Models\Job::factory()->create(); // make sure to 'use HasFactory' in the Job model
App\Models\Job::factory(298)->create(); // 298 more jobs
App\Models\Job::factory()->unverified()->create(); // can create 'unverified users', 'unverified()' state is available in UserFactory

add 'admin' in the UserFactory definition default to 'false' and add 'admin()' state function
----------------------------------------
table relationships (Job listing belongs to an Employer)
php artisan make:model Employer -m

added 'employer_id' foreign id in the Job migration table
start new fresh migration (php artisan migrate:fresh)
updated JobFactory and Job model to contain employer_id
php artisan make:model Employer -f (creates the EmployerFactory as well)
in tinker: App\Models\Job::factory(10)->create(); // will create job with a reference to an employer
----------------------------------------
updated Job model to handle relationship to the Employer

in tinker, try these:
$job = App\Models\Job::first() // returns the first result
now, access the the employer method as property to get the Employer instance
$job->employer;
$job->employer->name; // access the employer's name

at the point where the employer is queried, a second SQL query was performed
this refers to "Lazy Loading", the delay of a SQL query until the last possible momement

in reverse, an Employer can have multiple job postings:
$employer->jobs; // updated Employer model to handle having many jobs, returns all Jobs with the matching employer id
$employer->jobs->first() or $employer->jobs[0] // access the employer's first job listing
----------------------------------------
'belongsToMany' relationship for Tags (a post can have many tags, but tags do not belong to a single post)
(PIVOT/JOIN table record)
php artisan make:model Tag -mf (creates model, migration file, and a factory)
e.g. job_id(1) can be associated with tags tag_id(1) and tags_id(4)
updated Tags migration table to contain Job and Tag foreign ids as well as their constraints and trigger
also update the down() method since there are two Schemas in the Tag table

php artisan migrate:rollback (undo last uncommitted changes)
php artisan migrate:rollback && php artisan migrate

added 1 row in the TablePlus directly to the 'tag' table: tag -> 'programming' and id -> 1
associated in the 'job_tag' TablePlus table directly, job_listing_id -> 6 and tag_id -> 1
deleted it directly in the TablePlus, but job listing and tag didn't get deleted even with constraints
BECAUSE CONSTRAINTS ARE NOT ENFORCED OUTSIDE OF LARAVEL APP, we did it in TablePlus directly, THAT'S WHY...
You have to manually ENFORCE it on TABLEPLUS by typing in the SQL: PRAGMA foreign_keys=on, then click "Run Current"

now, when deleted a tag, the PIVOT/JOIN table record associated with it gets deleted
the same way if a job listing gets deleted, the pivot record associate with it gets deleted
----------------------------------------
now, lets put those to the Job and Tag models

in Job model:
add 'tags' method to access all tags associated with it (belongsToMany)
in Tag mode:
add 'jobs' method to access all jobs associated with it (belongsToMany)

in tinker, try:
$job = App\Models\Job::find(6);
$job->tags; // an error occured due to column name conflict, updated Job model to specify the column in the pivot records
in the same way, in the Tag model, to check all jobs related to a tag, specify the correct column key if there's a name conflict

now try this:
$tag = App\Models\Tag::find(1)
$tag->jobs;

// to add a new data (many:many; attaching a job with the ID of 7 to the tag with the ID of 1 in the PIVOT data )
$tag->jobs()->attach(7) or $tag->jobs()->attach(App\Models\Job::find(7))

then try: $tag->jobs->get() // instead of exiting tinker and requerying it
try: $tag->jobs()->get()->pluck('title'); // get all job titles
----------------------------------------
updated jobs.blade.php HTML tags
N+1 problem (which commonly happens in Lazy Loading SQL queries)
search for Laravel Debugbar and install it in the project
make sure APP_DEBUG=true in the .env file for this to work
make sure this is FALSE in the "PRODUCTION" mode
once installed, reload the webpage and you'll see a debug bar at the bottom of the page

updated '/jobs' route in routes
some devs disable lazy loading in the App\Provides\AppServiceProvider
by typing in the boot(): Model::preventLazyLoading(); // not 'preventsLazyLoading()'
if you try to do $jobs = Jobs::all(), it will catch an exception
saying you're attempting to lazy load the employer on the Job model
----------------------------------------
added pagination in the '/jobs' route
updated jobs.blade.php for pagination links
links() will automatically assume we're using Tailwind

php artisan vendor:publish (to edit the pagination manually)
select laravel-pagination (number 12 at the time of this course)
it will go views/vendor
configure in the AppServiceProvider boot() if you want to change from defaultView of Tailwind Paginator to (e.g. Bootstrap)
default = Paginator::defaultView();
bootstrap = Paginator::useBootstrapFive(); // example

but let's stick with the default, Tailwind pagination
we can then tweak the published file in the views/vendor

if we have a big website that can paginate through thousands of data,
SQL queries can become slow, we can use simplePaginate() with only previous and next buttons
or use cursorPaginate() which is the most performant; cursor-based paginator
----------------------------------------
Database seeders (commonly PARNERTED WITH Factories, but others too)
reset database (php artisan migrate:fresh)

when we do this, all tables get truncated, so we have to query factories again
we can use seeders instead by adding it to the Database\Seeders
type: php artisan db:seed (but make sure to edit the DatabaseSeeder.php to match with the User table)

try: php artisan migrate:fresh --seed (drops the db, migrates the tables, then seeds (populates) it again)

in the DatabaseSeeder.php, add other queries, like Job::factory(10)->create(), etc etc.
if seeding fails, make sure that you start with a fresh database then seed it to avoid duplicate error (php artisan migrate:fresh --seed)

we can isolate Seeders dedicated for seeding Users, Jobs, etc. (php artisan make:seeder) then name it 'JobSeeder' for example
then in the DatabaseSeeder.php where Seeders for users is located, call JobSeeder class
now try: php artisan migrate:fresh --seed (again and it works)
if we only want to run a specific seeder like 'JobSeeder', (php artisan db:seed --class=JobSeeder)
----------------------------------------
Forms and CSRF
be mindful with the order of the routes
Route::get('/jobs/create', function () {}) // should be placed before the 'jobs/{id}' to avoid conflict
Route::get('/jobs/{id}', function () {})

organized the files, all views for 'jobs' inside the 'views\jobs' but
as for CONVENTION, the view for displaying the job page is renamed: 'index.blade.php'
while the view for displaying a single job is renamed: 'show.blade.php'
added view for creating a job: 'create.blade.php'

add just the view path in the routes
e.g. Route::get('jobs/index') or more common is the dot notation, Route::get('jobs.index')
added a form ui from tailwindui in the create.blade.php and repurpose it, edited the "for", "name", and other attribute values

after editing the form adding the method=POST
and action='/jobs' (the convention is it submits a request to itself hence '/jobs')
Route::post('/jobs', function () {})

CSRF (Cross-Site Request Forgery) = it's like when hackers try to send an email,
for example, requesting you to update your bank account password
they will replicate page FORM with the correct action="" destination
so, when you fill it out, you will actually be able to update your password
but the hacker is able to intercept your password, hence we use "tokens" for more security to avoid CSRF attacks
if the token part of the form is not equal to the token form the current user session, you will get a "419" error message

updated the create.blade.php to implement CSRF
updated Route::post('/jobs') to access attributes from the form

skipping Validation for now, assuming everything is valid, create the Job
added 'employer_id' to the fillables of 'Job' model to get rid of error
updated Route::get('/jobs') to order the result from latest to oldest

// this is an area where programmers very much disagree
it's annoying to make the 'employer_id' mass assigned all the time
it can actually be disabled, updated 'Job' model to disable fillables
Inside the model it is mandatory to assign the field as
either fillable or guarded.
If not, following error will be generated
----------------------------------------
Never Trust Your User...
updated layout.blade.php to add button to create a job
extracted that button and placed in 'button.blade.php'

try submitting the form with empty field, and it error
we can use Browser validations by adding "required" attribute to the inputs
as well as in the backend
updated Route::post('/jobs') to add validations
you can check docs for other validation rules for any input
if the validations fail, Laravel automatically redirects back to the previous form
and it will store error messages which you can populate in the form
updated create.blade.php to display error messages

you can also use @error directives to check input specific error
placed right after the input's div
----------------------------------------
EDIT/UPDATE/DELETE
updated show.blade.php to add edit and delete buttons
renamed "Components" folder to "components" to avoid issue, it's common to name it in lowercase

added a route for editing a job
created edit.blade.php
Eloquent actually don't care how you access columns from the model, can be bracket notation or using "->"
but be consistent, updated edit.blade.php from
$job['title'] to $job->title as well as the rest

for the update and delete routes, there's NO NEED to explicitly add
/delete or /patch at the end for the route
as it is already explicitly indicated in the Route::delete/Route::patch request

you can learn more about Route Model binding - provides a convenient way to
automatically inject the model instances directly into your routes

to avoid updating a job with an ID that doesn't exist (often those accessed manually in the URL)
use Job::findOrFail($id)

updated the form's action and method,
POST is the only method native to the form
but it can be set to PATCH or DELETE

for the DELETE button, created a HIDDEN form with a @method('DELETE') method
and added a form target in the DELETE button to access the HIDDEN form with its id
----------------------------------------
ROUTES RELOADED - 6 ESSENTIAL ROUTING TIPS
1. ROUTE MODEL BINDING
updated Routes that use $id to use route model binding
wildcard should match the parameter name and set the parameter type to the model
for example instead of: Route::get('/jobs/{id}', function ($id) {})
do this: Route::get('/jobs/{job}', function (Job $job) {})

sometimes we use slugs for example Posts don't usually use ids, it uses slugs as identifier
'/posts/{post:slug}' or '/posts/{post:id}'
// findOrFail() is unnecessary since implicit Route Model Binding already ensures that the model instance exists

2. CONTROLLER CLASSES
php artisan make:controller
(hit enter then name it "JobController")
select type: Empty
it will create the file in app\Http\Controllers

in the JobController, created methods for each route
updated web.php to implement controllers
make sure to not forget to include the parameter in the methods if it has one

3. ROUTE VIEW
when you have a route that doesn't nothing but render a static Page
we can instead just do: Route::view('/', 'home');

4. ROUTE LIST (shows all your routes)
php artisan route:list
php artisan route:list --except-vendor (doesn't include debugger)

5. GROUP ROUTES
we have a problem with repeating the "JobController::class" in the routes
we can group all routes that assume the "JobController"
updated the web.php to implement that

6. ROUTE RESOURCES
php artisan make:controller JobController --resource (for the first time, if you need all of the routes)
Laravel can automatically generate standard CRUD operations (index, show, create, post, edit, update, delete)
if you follow the convention, you can actually just use its resource to access those routes
it means, you wont have to specify your routes in the "web.php",

test it, try to comment out "jobs" route group in the "web.php",
note: you still have to implement the methods in the JobController

generates all the standard routes with Route Model Binding: Route::resource('jobs', JobController::class),
such as get('/jobs'), post('/jobs'), '/jobs/{job}', '/jobs/{job}/edit', etc

try listing the routes to verify: php artisan route:list --except-vendor
we don't actually need to generate all the routes for a controller
we can specify which route we'd like to generate,
updated Route::resource to accept a third arg specifying route methods
----------------------------------------
LARAVEL STARTER KIT
Starter kits are intended to be used at the start of the project
we can't do it in here in this project as it assumes that we have some files which we already modified or deleted
it's going to overwrite those
It helps in creating common features of a site (signup, login, forget password, send email, etc)
here I created new project but Breeze wasn't in the options, so I chose None (laravel new breeze-example)
then after creating the project, I installed it via the composer (check docs for Breeze setup)
composer require laravel/breeze --dev
php artisan breeze:install (choose Blade with Alpine, yes for darkmode support, Pest for testing)
play around with it, check the files, you'll see how it implemented its login/signup and their middleware
----------------------------------------
Make a Login and Registration System From Scratch: Part 1
copy some parts of the forms from create.blade.php
and pasted them on:
form-label.blade.php
form-error.blade.php
form-input.blade.php
form-field.blade.php
form-button.blade.php
in the components
then included them in the forms of layouts that need them such as the create.blade.php

Blade directives like @if, @foreach, @php, etc.,
should not end with a semicolon (;).
For example:
@if($condition);
<div>Content</div>
@endif

<!-- copied all the layout from create.blade.php -->
and added Auth 'register' route in the web.php
php artisan make:controller RegisteredUserController

in the RegisteredUserController:
add the 'create' action
added 'auth' folder and created register.blade.php in it, in the views folder
<!-- pasted all the layout from create.blade.php to register.blade.php, MODIFY IT FOR REGISTRATION -->

Traditionally, password is the one being asked to re-type when registering
but it is actually MORE IMPORTANT to have the user repeat the EMAIL than the password
but let's stick to the tradition

to multiple select and make the cursor go the end of an HTML tag:
select multiple with Alt, then hold CTRL and press END key

copied layout from register.blade.php and create login.blade.php
then paste it there and modify for login

changed the register.blade.php form's action='/register' as well as login.blade.php with '/login'
added a post route for '/register' with 'store' action
implemented 'store' attion in the RegisteredUserController

added a get and post routes for /login with SessionController (create SessionController)
SessionController is just a common controller name for login

edited layout.blade.php to add login/signup links in the navbar
display these links when you're only a "@guest"
----------------------------------------
Make a Login and Registration System From Scratch: Part 2
// ReqisteredUserController STORE, Auth::login -> redirect to job page
implement 'store' action for post '/register' in the ReqisteredUserController
if you're going to add Password rules, and use it all over the site,
you can put in the Services and reference it as Password::defaults()
but here, I just applied the rules directly, e.g. Password::min(6)->letters()
if you add 'confirmed' rule in the password field, it's going to look for another field with
"password_confirmation" name and check if it matches to that, so make sure
to follow the convention for naming the confirm password field with "password_confirmation"
same with email field, if has "confirmed", gonna look for "email_confirmation"

in User::create(), you can instead pass in the request()->validate directly in it rather
than repeating the fields in the User::create
or store the validated fields in a variable then pass it in the User::create

try registering (errored as we forgot to edit the fillables in the User model)
edited the fillable in the User model to change the 'name' into 'first_name' and 'last_name' or just allow all fields
to be mass assigned by setting the $guarded to an empty array
also, had to edit the User table to set a default value to the 'admin' field to 'false'
hashing password is already implemented by the casts() method in the User model

instead redirecting somewhere
you can redirect back to the form with a success message
return redirect('/register')->with('success', 'Successfully registered! You may now log in.');

then add a @session for success in the register form

// SessionController DESTROY
updated layout.blade.php to only display 'logout' link when user is '@auth' (authenticated)
creating just a get request to '/logout' route is frowned upon, it should be in a form action
then when the form is submitted with post action to "/logout", it should trigger SessionController's destroy()

// SessionController STORE (login the user)
implemented login
when attempting to login failed, it should do something rather than continuing on the code
throw a validation exception, it will populate the error message field

to flash the "old values" in the input field,
turn the "value" attribute to: :value="old('name_of_the_field_here')"

in both login/register controllers
redirects the user to the homepage if
"LOGGED-IN" user tries to re-login/re-register by typing the address directly
if (Auth::check()) return redirect('/');
IT SHOULD BE IN THE "CREATE" method

----------------------------------------
6 Steps to Authorizatio Mastery

at the moment, our Employers table do not have any relationship