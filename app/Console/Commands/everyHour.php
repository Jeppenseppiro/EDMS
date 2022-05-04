<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class everyHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:passwordupdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new random password for file access';

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
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $var_size = strlen($chars);

        DB::table('document_file_revisions')->update(['file_password' => MD5(RAND())]);
    }
}
