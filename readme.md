#API REST Setup & Repository pattern



## License

Without License
##Installation
* first install the project with composer with all dependencies ( dev + requires)
* generate --> php artisan key:generate if is not generated
* show or reconfigure the file grumphp.yml 
* execute artisan migrate  if you should use the same databse in this exemple
* for the Auth refere to [Passport - laravel](https://laravel.com/docs/5.4/passport)
* php artisan passport:keys
* execute artisan passport:install


##working with Repositories

To create a new Repository refer to exemple CountryRepository :
this class must extend from Baserepository and must redifine the **model** function to inject the model
wanted.

* create a new controller :
 ``` php artisant make:controller --resource --model=<modelName> ```
* inject you repository in construct (dynamic laravel injection, we don't need too intialize to provider) 
* create route in routes\api.php like this :Route::resource('countries', 'Api\CountryController');
* Also you can create a specifique criteria and use it on extra, for that refer to App\Repositories\Criteria\
and App\Repositories\CountryRepository
* you can push teh new criteria on **initRepository** or in the controller by using thsi method below <br>
**pushCriteria**
**getByCriteria**
...

##Request Criteria :
###filters
exemple:

?filters[columnname]=value --> for simple usage <br>
?filter[relation.columnname]= value --> for filter with relation.
 ###limit & offset
 use it simple juste put limit & offset on url.
 ###orderBy
 exemple:

 ?orderBy[columnname]=value --> for simple usage <br>
 ?orderBy[relation.columnname]= value --> for filter with relation. --> we make the join for you.
 ###controller exemple
 ```php
$inlineCount =  $this->countryRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->countryRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->with(['users'])
            ->lists();<br>
        return Response::json(compact('inlineCount', 'results'));
```
##Security
you can view the Authorize middleware based on the config/security.php configuration

the objectif is to make ACL dynamic with this Rest Api by action, by role and by HttpVerb.

NB : the uri must be sorround with ^ and $ to be used in regular expression after in the middleware.

in the api.php ( file to configure the route api ), don't forget to use the autrhorization middleware as it's named in
Http/kernel.php exactly in the  $routeMiddlewar as bellow

```php
 protected $routeMiddleware = [
        ...
        'autrhorization' => \App\Http\Middleware\Authorize::class
        ...
    ];
```




