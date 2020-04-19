<?php

namespace Aposoftworks\LaravelUtilities\Commands;

//Laravel
use Illuminate\Console\Command;

//Classes
use Aposoftworks\LaravelUtilities\Classes\Helpers\CreateNewRepository;

class NewRepositoryCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {classname : The name of the repository to be created}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new repository to be used inside of your controllers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        if (CreateNewRepository::create($this->arguments(), $this->options(), $this)) {
            $this->info("Repository created successfully");
        }
        else {
            $this->warn("Repository already exists");
        }
    }
}
