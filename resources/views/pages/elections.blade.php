@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    Elections ({{ all_elections()->count() }})
                                  </section>
<div class="card-body">
@include('partials.alert_msg')

@if( current_user()->is_super_admin()  )
<p class="">
    <button class="show_form_ btn btn-sm btn-outline-success toggle_show_form"> <i class="fa fa-plus"></i> Add new </button>
    <button class="show_form_ hide btn btn-sm btn-outline-info toggle_show_form"> Hide Form </button>
</p>

<form action="{{ route('store_election')}}" method="post" class="show_form_ hide">
        @csrf()
    
            <div class="form-group">
                <label for=""> Election Type </label>
                @include('partials.election_category')
            </div>

            <div class="form-group">
                <label for=""> State </label>
                @include('partials.all_states') 
            </div>

            <div class="form-group">
                <label for=""> Total Accredited voters </label>
                <input type="number" name="total_registered_voters" class="form-control" required placeholder="0">
            </div>

            <div class="form-group">
                <label for=""> Election Period </label>
                @include('partials.years')
            </div>

            <div class="form-group">
                <label for=""> Election Date </label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for=""> Voting Venue</label>
                @include('partials.voting_location')
            </div>

            <div class="form-group">
                    <label for=""> Additional Info </label>
                    <div class="input-group">  
                      <input type="text" placeholder="election description..." name="description" class="form-control">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create </span> </button>
                      </div>
                    </div>  
            </div>
</form>
@endif

<section class="mt-3">

        @if( current_user()->is_super_admin() )
            <form onsubmit="return confirm('Please, confirm this transaction...')" action="" method="post">
            @csrf()
                <button type="submit" name="remove_elections" value="1" class="btn btn-outline-secondary btn-sm"> Remove election </button>
                <button type="submit" name="start_elections" value="1" class="btn btn-outline-success btn-sm"> Start election </button>
                <button type="submit" name="end_elections" value="1" class="btn btn-outline-danger btn-sm"> End election </button>
                @endif

            <div class="table-responsive mt-3">
                <table class="table table-striped datatable_ table-bordered">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" class="checkedAll"> </th>
                            <th> Title </th>
                            <th> State </th>
                            <th> Status </th>
                            <th> Total Registered voters</th>
                            <th> Total votes </th>
                            <th> Vote venue </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( all_elections() as $election )
                        <tr>
                            <td><input type="checkbox" name="id[]" value="{{$election->id}}" class="checkSingle"></td>
                            <td>{{$election->fullnames() }}</td>
                            <td>{{$election->state->name }} </td>
                            <td>{{$election->status_() }}</td>
                            <td>{{ number_format( $election->total_registered_voters ) }} </td>
                            <td>{{number_format($election->all_votes->sum('total') ) }} </td> 
                            <td>{{$election->category->name }}</td>
                            <td>
                                @if( $election->status != 0)
                                <a href="{{ route('view_election', ['code_number'=>$election->code_number])}}#" class="btn btn-outline-info btn-sm"> View </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center"> No Record Available... </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </form>
        </section>

                                    </div>
                                </div>
                        </section> <!-- //col -->

                      </div> <!-- //row -->
                    </section>
</section>

@stop
