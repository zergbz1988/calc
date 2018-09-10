## Installing

##### In Laravel project:

```
composer require zergbz1988/laravel-calc --dev

php artisan vendor:publish --provider="Zergbz1988\Calc\CalcServiceProvider"
```

## Configuring

##### In app/config/calc.php you can change 
```
'calcClass' => '{YOUR_CLASS}'
```

`YOUR_CLASS` must implement `Zergbz1988\Calc\Interfaces\Calc`