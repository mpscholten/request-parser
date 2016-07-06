# request parser

[![Latest Stable Version](https://poser.pugx.org/mpscholten/request-parser/version)](https://packagist.org/packages/mpscholten/request-parser) [![License](https://poser.pugx.org/mpscholten/request-parser/license)](https://packagist.org/packages/mpscholten/request-parser) [![Circle CI](https://circleci.com/gh/mpscholten/request-parser.svg?style=shield)](https://circleci.com/gh/mpscholten/request-parser)

Small PHP Library for type-safe input handling.

### The Problem

Let's say you have an action which lists some entities. This includes paging, ascending or descending ordering and optional filtering by the time the entity was created.
This action will have some kind of input parsing, which can look like this:

```php
public function index()
{
    $page = $this->request->query->get('page');
    if ($page === null || !is_integer($page)) {
        throw new Exception("Parameter page not found");
    }
    
    $order = $this->request->query->get('order');
    if ($order === null || !in_array($order, ['asc', 'desc'])) {
        throw new Exception("Parameter order not found");
    }
    
    // Optional parameter
    $createdAt = $this->query->query->get('createdAt');
    if (is_string($createdAt)) {
        $createdAt = new DateTime($createdAt);
    } else {
        $createdAt = null;
    }
}
```

Obviously this code is not very nice to read because it is not very descriptive. It's also pretty verbose for what it's doing.
And when you don't pay close attention you will probably miss a null check or a type check.

Now compare the above code to this version:

```php
public function index()
{
    $page = $this->queryParameter('page')->int()->required();
    $order = $this->queryParameter('order')->oneOf(['asc', 'desc'])->required();
    $createdAt = $this->queryParameter('createdAt')->dateTime()->defaultsTo(null);
}
```

That's what this library offers. It allows you to express "_this action requires a page parameter of type int_" or "_this action has an optional parameter createdAt of type DateTime, and will be set to a default value if absent_".

### Getting Started

Install via composer

```
composer require mpscholten/request-parser
```

If you're using the `symfony/http-foundation` `Request`, you just need to import a trait into your controller. If you're using some other `Request` abstraction (or maybe just plain old `$_GET` and friends), [check out this example](https://github.com/mpscholten/request-parser/blob/master/examples/not-symfony.php).

The following example asumes you're using the symfony `Request`:

```php
class MyController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
    
    public function __construct(Request $request)
    {
        $this->initRequestParser($request);
    }
}
```

Then you can use the library like this:
```php
class MyController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
    
    public function __construct(Request $request)
    {
        $this->initRequestParser($request);
    }
    
    public function myAction()
    {
        $someParameter = $this->queryParameter('someParameter')->string()->required();
    }
}
```

When doing `GET /MyController/myAction?someParameter=example`, the `$someParameter` variable will contain the string `"example"`.

You might wonder what happens when we leave out the `?someParameter` part, like `GET /MyController/myAction`. In this case the
`$this->queryParameter('someParameter')->string()->required()` will throw a `NotFoundException`. This exception can
be handled by your application to show an error message.

Take a look at [the examples](https://github.com/mpscholten/request-parser/tree/master/examples).

#### Optional Parameters

To make the `someParameter` optional, we can just replace `required()` with `defaultsTo($someDefaultValue)`:
```php
class MyController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
    
    public function __construct(Request $request)
    {
        $this->initRequestParser($request);
    }
    
    public function myAction()
    {
        $someParameter = $this->queryParameter('someParameter)->string()->defaultsTo('no value given');
    }
}
```

When doing `GET /MyController/myAction`, the `$someParameter` variable will now contain the string `"no value given"`. No
exception will be thrown because we specified a default value.


In general you first specify the parameter name, followed by the type and then specify whether the parameter is required or is optional with a default value.

For more examples, check out the `examples/` directory of this repository. It contains several runnable examples.

##### Integers, Enums, DateTimes and Json Payloads

Often we need more than just strings. *RequestParser* also provides methods for other data types:

```php
class DashboardController
{
    public function show()
    {
        $dashboardId = $this->queryParameter('id')->int()->required();
        
        // GET /dashboard?name=Hello   =>   $dashboardName == "Hello"
        $dashboardName = $this->queryParameter('name')->string()->required();
        
        // Get /dashboard?name=   => $dashboardName == "default value"
        $dashboardName = $this->queryParameter('name')->string()->defaultsToIfEmpty("default value");
        
        // GET /dashboard?status=private  =>   $dashboardStatus == "private"
        // GET /dashboard?status=public   =>   $dashboardStatus == "public"
        // GET /dashboard?status=invalid  =>   A NotFoundException will be thrown
        $dashboardStatus = $this->queryParameter('status')->oneOf(['private', 'public'])->required();
        
        // GET /dashboard?createdAt=01.01.2016     =>   $dateTime == new DateTime("01.01.2016")
        // GET /dashboard?createdAt=invalid_date   =>   A NotFoundException will be thrown
        $dateTime = $this->queryParameter('createdAt')->dateTime()->required();
        
        // GET /dashboard?config={"a":true}     =>   $json == ['a' => true]
        $json = $this->queryParameter('config')->json()->required();
        
        // GET /dashboard?includeWidgets=true    =>   $includeWidgets == true
        // GET /dashboard?includeWidgets=false   =>   $includeWidgets == false
        // GET /dashboard?includeWidgets=0       =>   $includeWidgets == false
        // GET /dashboard?includeWidgets=abcde   =>   A NotFoundException will be thrown
        $includeWidgets = $this->queryParameter('includeWidgets')->boolean()->required();
        
        // GET /dashboard?includeWidgets=yes   =>   $includeWidgets == true
        // GET /dashboard?includeWidgets=no    =>   $includeWidgets == false
        $includeWidgets = $this->queryParameter('includeWidgets')->yesNoBoolean()->required();
        
        // GET /image?scale=2.5   =>   $scale == 2.5
        $scale = $this->queryParameter('scale')->float()->required();
    }
}
```

All of these types also provide a `defaultsTo` variant.

##### GET Requests:
`$this->queryParameter($name)` tells the controller that we want a query parameter ([everything after the "?" is called the query string](https://en.wikipedia.org/wiki/Query_string)). This is usually what we want when dealing with GET requests

##### POST Requests:
When we're dealing with a POST request, we need to use `$this->bodyParameter($name)` to access form fields or the ajax payload.

### Autocompletion

The library allows you to take extensive use of autocompletion features of your IDE. E.g. after typing `$this->queryParameter('someParameter)->`
your IDE will offer you all the possible input types, e.g. `string()` or `int()`. After picking a type, e.g. `string()`, your IDE will offer
`required()` or `defaultsTo(defaultValue)` to specify the behavior when the parameter is not set.

![](https://github.com/mpscholten/request-parser/blob/master/images/autocompletion-type.png?raw=true)
![](https://github.com/mpscholten/request-parser/blob/master/images/autocompletion-required.png?raw=true)

### Static Analysis

The library supports static analysis by your IDE. E.g. when having a parameter like `$createdAt = $this->queryParameter('createdAt')->dateTime()->required();`,
your IDE will know that `$createdAt` is a `DateTime` object. This allows you to detect type errors while editing and also decreases the maintenance cost of
an action because the types improve legibility.

The library also decreases the risk of unexpected null values because parameters always have an explicit default value or are required.

### Error Handling

When a parameter is required but not found, the library will throw an exception. The default exception is `\MPScholten\RequestParser\NotFoundException`.
You can override the exception:

```php
class MyController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
    
    public function __construct(Request $request)
    {
        $this->initRequestParser($request, function($parameter) {
            throw new CustomException($message);
        });
    }
}
```

The suggested way to handle the errors thrown by the library is to catch them inside your front controller:

```php
try {
    $controller->$action();
} catch (NotFoundException $e) {
    echo $e->getMessage();
}
```

### Tests

```
vendor/bin/phpunit
```

### Contributing

Feel free to send pull requests!
