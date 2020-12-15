<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddVendorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dlcloud:addVendorData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавить информацию о производителях';

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
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
