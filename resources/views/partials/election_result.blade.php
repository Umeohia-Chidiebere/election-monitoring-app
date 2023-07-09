<section class="show_results mt-3">
                    <h5 class="font-weight-bold text-capitalized">{{$type}} Results </h5> <hr>
                   @foreach( $elections as $id => $records )

                   @if( election($id) )
 
                   @if( election($id)->category->slug == $slug || request()->has('filter_by') )
                   <h6 class="font-weight-bold text-success"> {{ election($id)->fullnames() }} </h6>
                
                   <hr>

                @forelse( election($id)->group_votes( request()->filter_by ) as $pu_id => $records)
                 <p class="font-weight-bold"> {{ get_record($slug, $pu_id) ? get_record($slug, $pu_id)->$slug->fullnames() : " - " }} </p> <hr>
                 @php
                     $invalid_votes = floatval( election_total_votes($id, $slug, $pu_id)->sum('invalid_votes') );
                     $valid_votes = floatval( election_total_votes($id, $slug, $pu_id)->sum('total') );
                 @endphp

                 <p> Invalid Votes: {{ number_format( $invalid_votes ) }} 
                  | Valid Votes: {{ number_format( $valid_votes )  }} 
                  | Total Votes: {{ number_format( $valid_votes + $invalid_votes ) }} 
                </p>
                 <section class="mb-3 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Political Party </th>
                                <th>Total Votes </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $index => $result)
                            @php $max_number = max( $records->pluck('total')->toArray() );  @endphp
                            <tr class="@if($max_number == $result->total ) text-success font-weight-bold @endif">
                                <td>{{ ++$index }}</td>
                                <td>
                                <img src="{{asset(party_logo_folder().$result->political_party->logo)}}" class="img-thumbnail img-40">
                                    {{ $result->political_party->fullnames() }}
                                </td>
                                <td>{{ number_format( $result->total ) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 </section>

                 @empty
                 <h5 class="text-center"> No Record available !</h5>
                 @endforelse 
                 
                 @endif
                    <br>

                   @endif
                  
                   @endforeach
                </section>
