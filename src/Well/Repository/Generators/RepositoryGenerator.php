<?php

namespace Well\Repository\Generators;

class RepositoryGenerator extends Generator
{
    public function generate($name)
    {
        $name_repository = studly_case($name);

        $repository = file_get_contents(__DIR__ . '/../Templates/Repository.php');
        $repository = str_replace('_TABLE_', $name_repository, $repository);

        if (!file_exists($this->getConfigPath('repositories'))) {
            mkdir($this->getConfigPath('repositories'), 0777, true);
        }
        
        $filename = $this->getConfigPath('repositories') . $name_repository . 'Repository.php';

        if(! file_exists($filename)){
            file_put_contents($filename, $repository);
        } 
    }

}
