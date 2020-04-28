<?php

namespace Aposoftworks\LaravelUtilities\Commands;

//Laravel
use Illuminate\Console\Command;

//Classes
use Aposoftworks\LaravelUtilities\Classes\Helpers\CreateNewSmartController;

class NewSmartControllerCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:smartcontroller {classname : The name of the smart controller to be created} {--R|relation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new smart controller to be used inside of your routes';

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
        if (CreateNewSmartController::create($this->arguments(), $this->options(), $this)) {
            $this->info("Smart controller created successfully");
        }
        else {
            $this->warn("Smart controller already exists");
        }
    }
}
