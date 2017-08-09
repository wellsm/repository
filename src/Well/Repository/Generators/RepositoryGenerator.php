<?php

namespace Well\Repository\Generators;

class RepositoryGenerator
{

    public static function generate($name)
    {
        $name_repository = studly_case($name);

        $repository = file_get_contents(__DIR__ . '/../Templates/Repository.php');
        $repository = str_replace('_TABLE_', $name_repository, $repository);

        if (!file_exists(app_path('Repositories'))) {
            mkdir(app_path('Repositories'), 0777, true);
        }
        
        $filename = app_path('Repositories/' . $name_repository . 'Repository.php');

        if(! file_exists($filename)){
            file_put_contents($filename, $repository);
        } 
    }

}
