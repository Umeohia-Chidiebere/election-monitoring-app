@extends("layouts.app")
@section('content')

<p class="page_title hide"> Dashboard - Stats Overview  </p>
<div class="app-main__outer">
                <div class="app-main__inner">

                    <div class="row">
                        
                        <div class="col-md-12 col-xl-12">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Elections </div>
                                            <div class="widget-subheading"> Total Elections</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"> {{ all_elections()->count() }} </div>
                                        </div>
                                    </div>
                                    
                                    @if( all_elections()->count() )
                        
                                    <section>
                                        <h6 class="text-center"> Election Countdown </h6>
                                        <hr>
                                        @foreach ( all_elections() as $election )
                                        {{$election->fullnames() }} - 
                                           <script> count_down("{{$election->start_date}}", "count_down_{{$election->code_number}}") </script>
                                            <div id="count_down_{{$election->code_number}}"></div>
                                            <hr>
                                        @endforeach
                                    </section>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Wards </div>
                                            <div class="widget-subheading"> Total Wards</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"> {{ all_wards()->count() }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Political Parties </div>
                                            <div class="widget-subheading"> Total Political Parties</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"> {{ all_political_parties()->count() }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}



                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total LGA </div>
                                            <div class="widget-subheading"> Total LGA</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"> {{ all_lga()->count() }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-3 widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading"> Total users </div>
                                                <div class="widget-subheading"> Total users </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success"> {{ all_users()->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-3 widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading"> Total Polling units </div>
                                                <div class="widget-subheading"> Total P.U</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success"> {{ all_polling_units()->count() }} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                           
                            
                        </div> <!-- //row -->



                        <div class="row"> <!-- row -->
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header"> Latest Elections </div>
                                     <section class="card-body">

                                     <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> Title </th>
                            <th> Date </th>
                            <th> State </th>
                            <th> Status </th>
                            <th> Total votes </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( all_elections()->take(10) as $election )
                        <tr>
                            <td>{{$election->fullnames() }}</td>
                            <td>{{ $election->start_date }} </td>
                            <td>{{$election->state->name }} </td>
                            <td>{{$election->status_() }}</td>
                            <td>{{ $election->total_election_votes() }} </td> 
                            <td>
                                @if( $election->status != 0)
                                <a href="{{ route('view_election', ['code_number'=>$election->code_number])}}#" class="btn btn-outline-success btn-sm"> View </a>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center"> No Record Available... </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
                                     </section>
                                </div>
                            </div>
                        </div>


                        
                        </div>
                    </div>

@stop
