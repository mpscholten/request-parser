# request parser

[![Latest Stable Version](https://poser.pugx.org/mpscholten/request-parser/version)](https://packagist.org/packages/mpscholten/request-parser) [![License](https://poser.pugx.org/mpscholten/request-parser/license)](https://packagist.org/packages/mpscholten/request-parser) [![Circle CI](https://circleci.com/gh/mpscholten/request-parser.svg?style=shield)](https://circleci.com/gh/mpscholten/request-parser)

Small PHP Library for type-safe input handling.

### Table of Contents:

* [The Problem](https://github.com/mpscholten/request-parser/#the-problem)
* [Examples](https://github.com/mpscholten/request-parser/#examples)
* [Getting Started](https://github.com/mpscholten/request-parser/#getting-started)
* [Integrations](https://github.com/mpscholten/request-parser/#integrations)
 * [Symfony HttpFoundation](https://github.com/mpscholten/request-parser/#symfony-httpfoundation)
 * [Psr7](https://github.com/mpscholten/request-parser/#psr7)
* [Optional Parameters](https://github.com/mpscholten/request-parser/#additional-parameters)
 * [Integers, Enums, DateTimes and Json Payloads](https://github.com/mpscholten/request-parser/#integers-enums-datetimes-and-json-payloads)
 * [Supported Data Types](https://github.com/mpscholten/request-parser/#supported-data-types)
* [GET Requests](https://github.com/mpscholten/request-parser/#get-requests)
* [POST Requests](https://github.com/mpscholten/request-parser/#post-requests)
* [Autocompletion](https://github.com/mpscholten/request-parser/#autocompletion)
* [Static Analysis](https://github.com/mpscholten/request-parser/#static-analysis)
* [Error Handling](https://github.com/mpscholten/request-parser/#error-handling)
 * [Using Custom Exception Classes](https://github.com/mpscholten/request-parser/#using-custom-exception-classes)
 * [Using Custom Exception Messages](https://github.com/mpscholten/request-parser/#using-custom-exception-messages)
* [Is It Production Ready?](https://github.com/mpscholten/request-parser/#is-it-production-ready)
* [Tests](https://github.com/mpscholten/request-parser/#tests)
* [Contributing](https://github.com/mpscholten/request-parser/#contributing)

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

### Examples

If you'd like to go straight to the code now, you can just play around with the examples.

0. `cd /tmp`
1. `git clone git@github.com:mpscholten/request-parser.git`
2. `cd request-parser`
3. `composer install`
4. `cd examples`
5. `php -S localhost:8080`
6. Open it: http://localhost:8080/symfony.php?action=hello

There are also several other php files inside the examples directory. To get your hands dirty, I suggest just modifying the examples a bit.

### Getting Started

Install via composer

```
composer require mpscholten/request-parser
```


**Integrations:**

 - If you're using `symfony/http-foundation`, [click here](#symfony-httpfoundation).
 - If you're using a Psr7 `ServerRequestInterface` implementation, [click here](#psr7).
 - If you're using some other `Request` abstraction (or maybe just plain old `$_GET` and friends), [check out this example](https://github.com/mpscholten/request-parser/blob/master/examples/not-symfony.php).

#### Symfony HttpFoundation

The following example assumes you're using the symfony `Request`:

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

#### Psr7

The following example assumes you're using the Psr7 `ServerRequestInterface`:

```php
class MyController
{
    use \MPScholten\RequestParser\Psr7\ControllerHelperTrait;
    
    public function __construct(ServerRequestInterface $request)
    {
        $this->initRequestParser($request);
    }
}
```

Then you can use the library like this:
```php
class MyController
{
    use \MPScholten\RequestParser\Psr7\ControllerHelperTrait;
    
    public function __construct(ServerRequestInterface $request)
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
        $someParameter = $this->queryParameter('someParameter')->string()->defaultsTo('no value given');
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

###### Supported Data Types

| Type  | Code example | Input example |
| ------------- | ------------- | ------------- |
| **String** | `$this->queryParameter('name')->string()->required();` | `'John Doe'`  |
| **Comma-Separated String** | `$this->queryParameter('names')->commaSeparated()->string()->required();` | `'John Doe,John Oliver'` |
| **Integer** | `$this->queryParameter('id')->int()->required();` | `'5'` |
| **Comma-Separated Integer**  | `$this->queryParameter('groupIds')->commaSeparated()->int()->required();` | `'5,6,7,8'` |
| **Float** | `$this->queryParameter('ratio')->float()->required();` | `'0.98'` |
| **Comma-Separated Float**  | `$this->queryParameter('precipitation')->commaSeparated()->float()->required();` | `'0.98,1.24,5.21'`  |
| **DateTime** | `$this->queryParameter('timestamp')->dateTime()->required();` | `'2016-07-20'` |
| **Comma-Separated DateTime** | `$this->queryParameter('eventTimes')->commaSeparated()->dateTime()->required();` | `'2016-07-20 13:10:50,2016-07-21 12:01:07'`  |
| **Boolean** | `$this->queryParameter('success')->boolean()->required();` | `'true'` | 
| **Comma-Separated Boolean** | `$this->queryParameter('answers')->commaSeparated()->boolean()->required();` | `'1,0,0,1'` |
| **Yes/No Boolean**  | `$this->queryParameter('success')->yesNoBoolean()->required();` | `'yes'`  |
| **Comma-Separated Yes/No Boolean** | `$this->queryParameter('answers')->commaSeparated()->yesNoBoolean()->required();` | `'y,n,n,y,n'`  |
| **JSON** | `$this->queryParameter('payload')->json()->required();` | `'{"event":"click","timestamp":"2016-07-20 13:10:50"}'` |
| **Comma-Separated JSON** | `$this->queryParameter('events')->commaSeparated()->json()->required();` | `'{"event":"click","timestamp":"2016-07-20 13:10:50"},{"event":"add_to_basket","timestamp":"2016-07-20 13:11:01"}'`  |


##### GET Requests:
`$this->queryParameter($name)` tells the controller that we want a query parameter ([everything after the "?" is called the query string](https://en.wikipedia.org/wiki/Query_string)). This is usually what we want when dealing with GET requests

##### POST Requests:
When we're dealing with a POST request, we need to use `$this->bodyParameter($name)` to access form fields or the ajax payload.

### Autocompletion

The library allows you to take extensive use of autocompletion features of your IDE. E.g. after typing `$this->queryParameter('someParameter)->`
your IDE will offer you all the possible input types, e.g. `string()` or `int()`. After picking a type, e.g. `string()`, your IDE will offer
`required()` or `defaultsTo(defaultValue)` to specify the behavior when the parameter is not set.

![](https://github.com/mpscholten/request-parser/blob/master/images/autocomplete-anim.gif?raw=true)

![](https://github.com/mpscholten/request-parser/blob/master/images/autocompletion-type.png?raw=true)
![](https://github.com/mpscholten/request-parser/blob/master/images/autocompletion-required.png?raw=true)

### Static Analysis

The library supports static analysis by your IDE. E.g. when having a parameter like `$createdAt = $this->queryParameter('createdAt')->dateTime()->required();`,
your IDE will know that `$createdAt` is a `DateTime` object. This allows you to detect type errors while editing and also decreases the maintenance cost of
an action because the types improve legibility.

The library also decreases the risk of unexpected null values because parameters always have an explicit default value or are required.

### Error Handling

When a parameter is required but not found or when validation fails, the library will throw an exception. The default exceptions are `\MPScholten\RequestParser\NotFoundException` and `\MPScholten\RequestParser\InvalidValueException`.
The suggested way to handle the errors thrown by the library is to catch them inside your front controller:

```php
try {
    $controller->$action();
} catch (NotFoundException $e) {
    echo $e->getMessage();
} catch (InvalidValueException $e) {
    echo $e->getMessage();
}
```

#### Using Custom Exception Classes

```php
class MyController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
    
    public function __construct(Request $request)
    {
        $exceptionFactory = new ExceptionFactory(CustomNotFoundException::class, CustomInvalidValueException::class));

        $config = new \MPScholten\RequestParser\Config();
        $config->setExceptionFactory($exceptionFactory);

        $this->initRequestParser($request, $config);
    }
}
```

#### Using Custom Exception Messages

```php

class FriendlyExceptionMessageFactory extends \MPScholten\RequestParser\ExceptionMessageFactory
{
    protected function createNotFoundMessage($parameterName)
    {
        return "Looks like $parameterName is missing :)";
    }

    protected function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Whoops :) $parameterName seems to be invalid. We're looking for $expected but you provided '$parameterValue'";
    }
}

class MyController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
    
    public function __construct(Request $request)
    {
        $config = new \MPScholten\RequestParser\Config();
        $config->setExceptionMessageFactory(new FriendlyExceptionMessageFactory());

        $this->initRequestParser($request, $config);
    }
}
```

Check it out [this example about custom exceptions](https://github.com/mpscholten/request-parser/blob/master/examples/custom-exception.php).


### Is It Production Ready?

Absolutely. This library was initially developed at [quintly](https://www.quintly.com) and is extensively used in production since april 2015. Using it at scale in production means there's a a big focus on backwards compatibility and not breaking stuff.

### Tests

```
vendor/bin/phpunit
```

### Contributing

Feel free to send pull requests!
