# laravel api signature

## Install

```shell
composer require hogus/api-signature
```

## Publish Config

```shell
php artisan vendor:publish --provider=Hogus\\ApiSignature\\ApiSignatureServiceProvider
```

## Env
```shell
#sign
API_SIGN_ENABLED=true
API_SIGN_SECRET=secret
#API_SIGN_KEY=sign
#API_SIGN_TIMESTAMP_KEY=timestamp
#API_SIGN_TIMEOUT=60
```

## Http Middleware
Add the API signature middleware to the middleware aliases in your `Kernel.php` file:
```php
protected $middlewareAliases = [
    //...,
    'sign' => \Hogus\ApiSignature\Middleware\ApiSignature::class,
]
```

## Router
Apply the sign middleware to the desired routes or route groups:
```php
Route::middleware('sign:api')->group(function () {
    // your routes
});
```
This ensures that the API signature will be verified for all requests to these routes.

## Custom Exceptions (options)
If you want to handle API signature verification exceptions in a custom way, you can define a renderable closure in your `app/Exceptions/Handler.php` file. For example, to return a JSON response containing the error message:
```php
use Hogus\ApiSignature\ApiSignatureException;
$this->renderable(function (ApiSignatureException $exception, $request) {
    return response()->json(['message' => $exception->getMessage()]);
});
```

## Supports

- MD5
- Hash(sha256)