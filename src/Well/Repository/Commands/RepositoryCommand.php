<?php

namespace Well\Repository\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Well\Repository\Generators\RepositoryGenerator;
use Well\Repository\Generators\EntityGenerator;
use Well\Repository\Generators\ControllerGenerator;
use Well\Repository\Generators\MigrationGenerator;

class RepositoryCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model, repository, controller & migration';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
               
        MigrationGenerator::generate($name);
        EntityGenerator::generate($name);
        RepositoryGenerator::generate($name);
        ControllerGenerator::generate($name);
        
        $this->info('Repository ' . $name . ' Created! ');
    }

    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated',
                null
            ],
        ];
    }
}
