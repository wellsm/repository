<?php

namespace Well\Repository\Generators;

use Carbon\Carbon;

class MigrationGenerator extends Generator
{
    public function generate($name)
    {
        $migration = file_get_contents(__DIR__ . '/../Stubs/Migration.stub');
        
        $name_table = snake_case(str_plural($name));
        
        $migration = str_replace('_NAME_TABLE_PLURAL_', $name_table, $migration);
        $migration = str_replace_first('_TABLE_', studly_case($name_table), $migration);
        
        $datetime = Carbon::now()->toDateTimeString();
        
        $date_migration = str_replace('-', '_', $datetime);
        $date_migration = str_replace(' ', '_', $date_migration);
        $date_migration = str_replace(':', '', $date_migration);
        
        $name_migration = '_create_' . $name_table . '_table';
        $filename = $this->getConfigPath('migrations') . $date_migration . $name_migration . '.php';
                
        $folder_migration = $this->getConfigPath('migrations');
        $files = scandir($folder_migration);

        $found_migration = false;

        foreach($files as $file){
            if($file != '.' && $file != '..'){
                if(stristr($file, $name_migration)){
                    $found_migration = true;
                }
            }
        }

        if(! $found_migration){
            file_put_contents($filename, $migration);
        }  
    }
}
