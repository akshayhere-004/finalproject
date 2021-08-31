<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      
        a:
        Log::info('here');
        $ids = DB::table('users')->pluck('id');
        foreach($ids as $id){
            $pids = DB::table('my_plants')->where('user_id',$id)->pluck('plant_id');
            foreach($pids as $pid){
                $period = DB::table('plant_data')->where('id',$pid)->pluck('water_duration')[0];
                $times = DB::table('plant_data')->where('id',$pid)->pluck('water_times')[0];
                $idtemp = DB::table('my_plants')->where('plant_id',$pid)->where('user_id',$id)->pluck('id')[0];
                $status = DB::table('plant_status')->where('plant_id',$idtemp)
                    ->where('created_at','>=',now()->addDays(-1*($period)))
                    ->get();
                    $status2 = DB::table('plant_status')->where('plant_id',$idtemp)->where('created_at','>=',now()->addHours(-24))->pluck('id');
                    if(count($status) >= $times || count($status2) > 0){
                     
                    }else{
                        $user = ['user'=>DB::table('users')->where('id',$id)->pluck('email')[0]];
                        Mail::send('emails', ['user' => $user], function ($m) use ($user,$id,$pid) {
                            $m->from('hello@app.com', 'Greenskeeper');
                            $m->to(DB::table('users')->where('id',$id)->pluck('email')[0],DB::table('users')->where('id',$id)->pluck('name')[0])
                            ->subject('Plant Number # '.$pid.', Name : '.DB::table('plant_data')->where('id',$pid)->pluck('name')[0]);
                        });
                    }
            }
            
        
        
        
       
        }
        
        // $schedule->call(function () {
            
        // })->everyMinute();
        sleep(86400);
        goto a;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
