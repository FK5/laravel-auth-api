<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email to the admins on a daily basis the number of registered users on the same day';

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
        $today = Carbon::today();
        
        $admins = DB::table('users')->where('usertype', 'admin');

        $nbOfNewUsers = DB::table('users')->where('create_at', '>=' , $today)->count();

        foreach ($admins as $recipient) {

            Mail::to($admins)->send($nbOfNewUsers);
        }
        // Mail::to($request->user())->send(new OrderShipped($order));
        return 0;
    }
}
