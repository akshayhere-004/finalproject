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

                    <table class="table-bordered table-hover table-striped table col">
                        <thead style="background-color:grey;color:greenyellow">
                            <tr >
                                <th>Plant #</th>
                                <th>Plant Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plants as $plant)
                                <tr>
                                    <td>{{$plant->id}}</td>
                                    <td>{{$plant->name}}</td>
                                    <td>
                                        <form action="selectplant" method="post">
                                            @csrf
                                            <input name="id" value="{{$plant->id}}" hidden>
                                            <button type="submit" class="btn btn-secondary">Select</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
