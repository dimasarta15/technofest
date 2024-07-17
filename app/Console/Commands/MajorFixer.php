<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\User;
use Illuminate\Console\Command;

class MajorFixer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'major:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixing Major';

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
        $p = Project::all();
        foreach ($p as $key => $v) {
            $user = User::whereId($v->user_id)->update([
                'major_id' => $v->major_id
            ]);

            $muser = User::find($v->user_id);
            echo "$muser->name DONE";
        }
        return 0;
    }
}
