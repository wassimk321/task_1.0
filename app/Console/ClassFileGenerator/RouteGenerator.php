<?php

namespace App\Console\ClassFileGenerator;
use Illuminate\Support\Facades\File;

trait RouteGenerator
{
    public function makeRoutes()
    {


        $fileContents = File::get(base_path('routes/api.php'));
        $controllerClass = $this->getClassNameFromTableName() . 'Controller';
        $routeName = $this->getPluralVarName();
        $routeStatement = "Route::apiResource('$routeName', $controllerClass::class);";
        if (!preg_match('/^\s*' . preg_quote($routeStatement, '/') . '\s*$/m', $fileContents)) {
            File::append(base_path('routes/api.php'), $routeStatement . PHP_EOL);
        }



//         $fileContents = File::get(base_path('routes/api.php'));
//         $pattern = '/^\s*Route::group\(\[\s*\'prefix\'\s*=>\s*\'' . preg_quote('/' . $this->getPluralVarName(), '/') . '\'/m';
//         if (!preg_match($pattern, $fileContents)) {
//             $routes = '
// Route::group([
//     \'prefix\' => \'/' . $this->getPluralVarName() . '\',
//     \'controller\' => ' . $this->getClassNameFromTableName() . 'Controller::class,
//     // \'middleware\' => \'\'
// ], function () {
//     Route::get(\'/\', \'getAll\');
//     Route::get(\'/{id}\', \'find\');
//     Route::post(\'/\', \'create\');
//     Route::put(\'/{id}\', \'update\');
//     Route::delete(\'/{id}\', \'delete\');
// });
// ';
//             File::append(base_path('routes/api.php'), $routes);
//         }
    }
}
