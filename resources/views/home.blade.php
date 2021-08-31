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

                   <a type="button" class="btn btn-primary col-md-12" href="selectplants">Select Plants</a>
                   <hr>
                   <a type="button" class="btn btn-success col-md-12" href="myplants">My Plants</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
