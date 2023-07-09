@extends("layouts.app")
@section('content')

<style>
    thead tr th div, .vertical{
        writing-mode: vertical-rl;
        text-orientation: sideways-right;
        transform: rotate(180deg);
        text-align:left;
        height:auto;
        width:auto;
        display: block;
        padding-left:5px; 
}
</style>
<section class="app-main__outer">
    <section class="app-main__inner">
        <div class="card">
            <section class="card-header page_title">
               <p> {{ $election->fullnames() }} </p>
            </section>
            
            <div class="card-body text-muted">
            <a href="{{ route('elections_page')}}" class="mb-3 btn btn-outline-info btn-sm"> Back to Elections </a> 
                 <p> State:  {{ $election->state->name }} </p>
                 <p> Year:   {{ $election->year }} </p>
                 <p> Status: {{ $election->status_() }} </p>
                 <p> Total Registered Voters: {{ number_format( $election->total_registered_voters ) }} </p>
                 <p> Total Valid votes: {{  number_format( $election->valid_votes() ) }} </p>
                 <p> Total Invalid votes: {{  number_format( $election->invalid_votes() ) }} </p>
                 <p> Total Votes: {{  $election->total_election_votes() }} </p>
                 <p> Total {{ $election->category->name }}: {{ $election->group_votes()->count() }}</p>
                 
                 <section class="mt-3">
                    <a href="?filter_2=1" class="btn btn-sm btn-outline-info"> View General Report</a>
                    <a href="{{ route('view_election', ['code_number'=>$election->code_number])}}" class="btn btn-sm btn-outline-info"> View Result by Party </a>
                    <a href="?filter_1=1" class="btn btn-sm btn-outline-info"> View Result by {{ $election->category->name }} </a>
                 </section>
                 <hr>
                 
                 @if( request()->has('filter_1'))

                 @php 
                   $type_ = $election->category->name;
                   $slug_ = $election->category->slug;
                   if( request()->has('filter_ward')):
                     $type_ = "Ward";
                     $slug_ = 'ward';
                   endif;
                 @endphp

                 @include('partials.election_result', ['elections' => $election->all_votes->groupBy('election_id'), 'type' => $type_, 'slug'=> $slug_ ])              
              

                 @elseif( request()->has('filter_2'))


                 <h5> General Result </h5> <br>
                 <section class="mb-3 table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> STATE </th>
                                @foreach( all_political_parties() as $party )
                                <th><div class="vertical">{{ $party->short_name }}</div> </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $election->group_votes_by_state() as $state => $data )
                           <tr>
                            <td> {{$state}}</td>
                            @foreach( all_political_parties() as $party )
                             <td> {{ number_format( fetch_total_vote_records($election->id, $election->category->slug.'_id', $state, $party->id) ) }} </td>
                            @endforeach
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                 </section>
                
                

                 
                 @else



                 
                 <section class="mb-3 table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> #</th>
                                <th> Political Party </th>
                                <th> Total Votes </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $election->group_votes_by_party() as $index => $party )
                            @php 
                                $political_party = political_party($party->id);
                                $max_number = max($election->group_votes_by_party()->pluck('total_votes')->toArray() );
                            @endphp
                           <tr class="@if($max_number == $party->total_votes ) text-success @endif">
                            <td>{{++$index}}</td>
                            <td>
                            <img src="{{asset(party_logo_folder().$political_party->logo)}}" class="img-thumbnail img-40">
                                    {{ $political_party->fullnames() }}
                            </td>
                            <td> {{ number_format( $party->total_votes) }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                 </section>

@endif

            </div>

        </div>
    </section>
</section>

@stop
