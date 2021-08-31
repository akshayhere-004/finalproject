<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function selectplants()
    {
        $ids = DB::table('my_plants')->where('user_id',Auth()->user()->id)->pluck('plant_id');
        $plants = DB::table('plant_data')->whereNotIn('id',$ids)->get(); 
        return view('select_plants')->with('plants',$plants);
    }

    public function selectplant(Request $request)
    {
        $id = $request->input('id');
        DB::table('my_plants')->updateOrInsert([
            'user_id'=>Auth()->user()->id,
            'plant_id'=>$id
        ],[
            'created_at'=>now(),
            'water_status'=>'yes'
        ]);
        return redirect()->back();
    }

    public function myplants()
    {
        $ids = DB::table('my_plants')->where('user_id',Auth()->user()->id)->pluck('plant_id');
        $plants = DB::table('plant_data')->whereIn('id',$ids)->get(); 
        return view('my_plants')->with('plants',$plants);
    }

    public function unselectplant(Request $request)
    {
        $id = $request->input('id');
        DB::table('my_plants')->where('user_id',Auth()->user()->id)->where('plant_id',$id)->delete();
        return redirect()->back();
    }

    public function myplant(Request $request)
    {
        $period = DB::table('plant_data')->where('id',$request->input('id'))->pluck('water_duration')[0];
        $times = DB::table('plant_data')->where('id',$request->input('id'))->pluck('water_times')[0];
        $idtemp = DB::table('my_plants')->where('plant_id',$request->input('id'))->where('user_id',Auth()->user()->id)->pluck('id')[0];
        $status = DB::table('plant_status')->where('plant_id',$idtemp)
        ->where('created_at','>=',now()->addDays(-1*($period)))
       ->get();
       $status2 = DB::table('plant_status')->where('plant_id',$idtemp)->where('created_at','>=',now()->addHours(-24))->pluck('id');
       if(count($status) >= $times || count($status2) > 0){
        DB::table('my_plants')->where('id',$idtemp)->update([
            'water_status'=>'no'
        ]);
       }else{
        DB::table('my_plants')->where('id',$idtemp)->update([
            'water_status'=>'yes'
        ]);
       }
        
        $id = $request->input('id');
        $data = DB::table('plant_data')->join('my_plants','plant_data.id','=','my_plants.plant_id')
        ->where('plant_data.id',$id)->where('my_plants.user_id',Auth()->user()->id)
        ->select('plant_data.id','plant_data.name','plant_data.temperature','plant_data.image','plant_data.daylight','my_plants.water_status',)
        ->get();
        

        return view('plant_status')->with('plant',$data);
    }

    public function markwatered(Request $request)
    {
        $id = DB::table('my_plants')->where('plant_id',$request->input('id'))->where('user_id',Auth()->user()->id)->pluck('id')[0];
         DB::table('plant_status')->insert([
             'watered_by'=>Auth()->user()->id,
             'plant_id'=>$id,
             'created_at'=>now()
         ]);
        
         return redirect()->back();
      
    } 
    public function sendmail(){
        $user = ['user'=>'haiderjutt95@gmail.com'];
        Mail::send('emails', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');
            $m->to('haiderjutt95@gmail.com','haider')->subject('Your Reminder!');
        });
    }
}
