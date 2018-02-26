# Feb 13, 2018 - login registration, authentication, dashboard post read and delete     

## dummy user login credentials     

* email: `nur@gmail.com` password: `secret`
* email: `mahibur@gmail.com` password: `secret`
* email: `farhad@gmail.com` password: `secret`
* email: `majedul@gmail.com` password: `secret`
* email: `tahmina@gmail.com` password: `secret`


### email validation using regular expression 

~~~php
function is_email($email) {
  $pattern = '/.+@.+\..+/';
  return preg_match($pattern, $email);
}
~~~

### checking whether user authenticate or none 

~~~php
function is_authenticate() {
  return isset($_SESSION['user']);
}
~~~

### In register check whether email already taken or not

~~~php
function is_email_taken($email) {
  $user = User::where('email', $email)->first();
  return empty($user) ? false : true;
}
~~~

### server side form validation with storing old form data 

php part 
~~~php
$errors = [];
$old_values = [
  'name' => '',
  'email' => '',
  'password' => '',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $old_values = [
    'name' => $name,
    'email' => $email,
    'password' => $password,
  ];

  if (strlen($name) < 4) {
    $errors['name'] = "name value can't be less than 4 character";
  }
  if (strlen($password) < 4) {
    $errors['password'] = "password value can't be less than 4 character";
  }
  if (!is_email($email)) {
    $errors['email'] = "please pass a valid email address";
  } else if (is_email_taken($email)) {
    $errors['email'] = "email address already taken";
  }

  if (empty($errors)) {
    $user = new User();
    $user->name = $name;
    $user->email = $email;
    $user->password = password_hash( $password, PASSWORD_BCRYPT);
    $user->save();
    $_SESSION['user'] = $user;
    header('Location: /');
  }
}

~~~

html part    

~~~html

<form method="post">
  <div class="form-group">
      <label for="name">Name</label>
      <input value="<?php echo $old_values['name'] ?>" type="text" name="name" id="name" class="form-control">
  </div>
  <?php if (isset($errors['name'])): ?>
    <p class="text-danger"><?php echo $errors['name'] ?></p>
  <?php endif ?>
  
  <div class="form-group">
      <label for="email">Email</label>
      <input value="<?php echo $old_values['email'] ?>" type="text" name="email" id="email" class="form-control">
  </div>
  <?php if (isset($errors['email'])): ?>
    <p class="text-danger"><?php echo $errors['email'] ?></p>
  <?php endif ?>
  <div class="form-group">
      <label for="password">Password</label>
      <input value="<?php echo $old_values['password'] ?>" type="password" name="password" id="password" class="form-control">
  </div>
  <?php if (isset($errors['password'])): ?>
    <p class="text-danger"><?php echo $errors['password'] ?></p>
  <?php endif ?>
  <div class="form-group">
    <p>
      Already have account <a href="/login">Login here</a>
    </p>
    <button class="btn btn-outline-primary" type="submit">Register</button>
  </div>
  
</form>
~~~

## Fetching first results from a collections 

~~~php
$user = User::find($_SESSION['user']->id);
~~~

## deleting a entry and redirect back with message 

~~~php
$id = $_GET['id'];
$post = Post::find($id);
$post->delete();
header('location: /dashboard/post?delete=true');
~~~

## javascript confirm box in deleting 

~~~php
<a onclick="return confirm('Are you sure you want to delete this entry')" href="/dashboard/post/delete?id=<?php echo $post->id ?>" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Delete</a>
~~~




========================================



# Feb 11, 2018

## How to getting all data from eloquent model  

~~~php
Model::all();
~~~

##  How to getting single row from eloquent model 

~~~php
Model::find(id);
~~~

## relationship    

~~~php
// relation between User and Post Model
// inside User model
public function posts()
{
  return $this->hasMany(Post::class);
}
// inside Post model
public function user () {
  return $this->belongsTo(User::class);
}
~~~

## getting current directory path in php 

~~~php
__DIR__
~~~

## About table order when we create and drop table  

table order is important      
some table will depend on other table so when we create table dependent table will be created first   
When we drop table order will be reverse        

## Making foreign key relationship with illuminate/database schema     

~~~php
$t->integer('post_id')->unsigned();
$t->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
~~~

## range function   

range function will give a array in between range    

~~~php
range(1, 5) // [1, 2, 3, 4, 5];
~~~

## random number in php
rand function give us random number in between 2 numbers    

~~~php
rand(10, 15) // it will give a number in between 10 and 15
~~~

## Parsing url path in php  
~~~php
 $path = parse_url( trim( $_SERVER['REQUEST_URI'], '/' ), PHP_URL_PATH);
~~~

## how to using faker     

to generate fake data we are using faker       

Install faker      
~~~php
composer require fzaninotto/faker       
~~~

use Faker 

~~~php
use Faker\Factory;
$faker = Factory::create();
~~~

## Carbon date library   

Carbon date library has lot of helper function to work with data       

Installing  Carbon      

~~~php
composer require nesbot/carbon
~~~

Using carbon     

~~~php
use Carbon\Carbon
Carbon::now()->format("Y-m-d H:i:s")
~~~

using carbon method with created_at field   

~~~php
$post->created_at->diffForHumans()
~~~

