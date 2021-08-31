@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Your Personal Horticulturist Monitoring Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        @foreach ($plant as $indiv)
                        <div class="col-md-6"> 
                            <img src="images/{{$indiv->image}}" alt="" width="100%">
                        </div>
                        <div class="col-md-6"> 
                            
                            <h4>Plant # {{$indiv->id}}</h4>
                            <h4>Name : {{$indiv->name}}</h4>
                            
                            @if ($indiv->water_status == "yes")
                            <hr>
                            <h5 style="color: red">Needs Water Today
                                 <form action="markwatered" method="POST">
                                     @csrf
                                     <input name="id" value="{{$indiv->id}}" hidden>
                                     <button class="btn btn-danger" style="float: right"  type="submit">
                                        Mark Watered
                                    </button>
                                 </form>
                            </h5>
                            <hr>
                            @endif
                            
                            <h5>Temperature : {{$indiv->temperature}}</h5>
                        
                            
                               
                            @if ($indiv->daylight == "Yes")
                            <h5>Keep in Sunlight</h5>
                            @else
                            <h5>Keep in Shadow</h5> 
                            @endif
                            
                           
                            
                            
                        </div>
                        @endforeach
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
