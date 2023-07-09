@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    Election Candidates
                                  </section>
<div class="card-body">
@include('partials.alert_msg')

@if( current_user()->is_admin()  )
<p class="">
    <button class="show_form_ btn btn-sm btn-outline-success toggle_show_form"> <i class="fa fa-plus"></i> Add candidate </button>
    <button class="show_form_ hide btn btn-sm btn-outline-info toggle_show_form"> Hide Form </button>
</p>

<form action="{{ route('store_candidate')}}" method="post" class="show_form_ hide">
        @csrf()
    
            <div class="form-group">
                <label for=""> Select Election </label>
                <select name="election_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select election- </option>
                    @foreach( all_elections() as $election )
                    <option value="{{$election->id}}"> {{ $election->fullnames() }} </option>
                    @endforeach
                </select>

            </div>

            <div class="form-group">
                <label for=""> State </label>
                @include('partials.all_political_parties') 
            </div>

            <div class="form-group">
                <label for=""> Candidate name </label>
                <input type="text" name='name' required class="form-control">
            </div>

            <div class="form-group">
                    <label for=""> Vice/Deputy name </label>
                    <div class="input-group">  
                      <input required type="text" placeholder="Candidate name...." name="deputy_name" class="form-control">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create </span> </button>
                      </div>
                    </div>  
            </div>
</form>
@endif

<section class="mt-3">

        @if( current_user()->is_admin() )
            <form onsubmit="return confirm('Please, confirm this removal...')" action="" method="get">
            @csrf()
                <button type="submit" name="remove_candidate" value="1" class="btn btn-outline-danger btn-sm"> Remove candidate </button>
                @endif

                @foreach ( all_election_candidates() as $election_id => $candidates)
                <h5 class="text-success mt-3 mb-3"> {{ election( $election_id )->fullnames() }}</h5>
            <div class="table-responsive mt-3">
            
                <table class="table table-striped datatable_ table-bordered">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" class="checkedAll"> </th>
                            <th> Party</th>
                            <th> Candidate name </th>
                            <th> Vice/Deputy name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( $candidates as $candidate )
                        <tr>
                            <td><input type="checkbox" name="id[]" value="{{$candidate->id}}" class="checkSingle"></td>
                            <td>
                                <img src="{{asset(party_logo_folder().$candidate->political_party->logo)}}" class="img-thumbnail img-40">
                                    {{ $candidate->political_party->fullnames() }}
                            </td>
                            <td>{{$candidate->name }}</td>
                            <td>{{$candidate->deputy_name }} </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center"> No Record Available... </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <br>
            <hr>
            @endforeach
            </form>
        </section>

                                    </div>
                                </div>
                        </section> <!-- //col -->

                      </div> <!-- //row -->
                    </section>
</section>

@stop
