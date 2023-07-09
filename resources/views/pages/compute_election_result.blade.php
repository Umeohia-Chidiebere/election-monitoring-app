@extends("layouts.app")
@section('content')

<section class="app-main__outer">
    <section class="app-main__inner">
        <div class="card">
        @include('partials.alert_msg')
            <section class="card-header page_title"> Compute Election Results </section>

            <div class="card-body">
                <button type="button" class="btn btn_ btn-success click_btn" id="polling-unit-id"> Polling unit ({{current_user()->assigned_polling_units()->count()}})</button>
                <button type="button" class="btn btn_ btn-outline-success click_btn" id="ward-id"> Ward ({{current_user()->assigned_wards()->count()}}) </button>
                <!-- @if( current_user()->is_admin() )
                <button type="button" class="btn btn_ btn-outline-success click_btn" id="lga-id"> LGA </button>
                @endif -->

                <div class="mt-3">

                <section id="polling-unit-id-page" class="hide_">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Polling unit</th>
                                    <th>Election</th>
                                    <th>Political Party</th>
                                    <th>InValid Votes </th>
                                    <th>Total Valid Votes </th> 
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( current_user()->assigned_polling_units() as $index => $pu )
                                <form action="{{ route('store_election_result') }}" method="post">
                                   <input type="hidden" name="polling_unit_id" value="{{$pu->id}}">
                                   <input type="hidden" name="type_" value="polling_unit">
                                       @csrf()
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $pu->fullnames() }}</td>
                                    <td>@include('partials.all_elections', ['type' => 'polling_unit'])</td>
                                    <td>@include('partials.all_political_parties')</td>
                                    <td>
                                        <input type="number" placeholder="0.00" name="invalid_votes" class="form-c">
                                    </td>
                                    <td>
                                       <div class="form-group">
                                         <div class="input-group">  
                                            <input type="number" placeholder="0.00" required name="total" class="form-c">
                                            <div class="input-group-append">
                                              <button class="btn btn-xs btn-outline-success" type="submit"> <span class="font-14"> Submit</span> </button>
                                            </div>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                </form>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center"> No Record available </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @include('partials.election_result', ['elections' => current_user()->get_election_votes('polling_unit'), 'type' => 'Polling Unit', 'slug'=>'polling_unit'])

                </section>


                <section id="ward-id-page" class="hide_ hide">

                <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ward</th>
                                    <th>Election</th>
                                    <th>Political Party</th>
                                    <th>InValid Votes </th>
                                    <th>Total Valid Votes </th> 
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( current_user()->assigned_wards() as $index => $ward )
                                <form action="{{ route('store_election_result') }}" method="post">
                                   <input type="hidden" name="ward_id" value="{{$ward->id}}">
                                   <input type="hidden" name="type_" value="ward">
                                       @csrf()
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $ward->fullnames() }}</td>
                                    <td>@include('partials.all_elections', ['type' => "ward"])</td>
                                    <td>@include('partials.all_political_parties')</td>
                                    <td>
                                        <input type="number" placeholder="0.00" name="invalid_votes" class="form-c">
                                    </td>
                                    <td>
                                       <div class="form-group">
                                         <div class="input-group">  
                                            <input type="number" placeholder="0.00" required name="total" class="form-c">
                                            <div class="input-group-append">
                                              <button class="btn btn-xs btn-outline-success" type="submit"> <span class="font-14"> Submit</span> </button>
                                            </div>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                </form>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center"> No Record available </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @include('partials.election_result', ['elections' => current_user()->get_election_votes('ward'), 'type' => 'Ward', 'slug'=>'ward'])

                </section>

                <?php

                /*******
                 * 
                 * 
                @if( current_user()->is_admin() )
                <section id="lga-id-page" class="hide_ hide">
                    
                <div class="table-responsive">
                        <table class="table table-bordered datatable_">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>LGA</th>
                                    <th>Election</th>
                                    <th>Political Party</th>
                                    <th>Enter Total Votes </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( all_lga() as $index => $lga )
                                <form action="{{ route('store_election_result') }}" method="post">
                                   <input type="hidden" name="lga_id" value="{{$lga->id}}">
                                       @csrf()
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $lga->fullnames() }}</td>
                                    <td>@include('partials.all_elections')</td>
                                    <td>@include('partials.all_political_parties')</td>
                                    <td>
                                       <div class="form-group">
                                         <div class="input-group">  
                                            <input type="number" placeholder="0.00" required name="total" class="form-c">
                                            <div class="input-group-append">
                                              <button class="btn btn-xs btn-outline-success" type="submit"> <span class="font-14"> Submit</span> </button>
                                            </div>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                </form>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center"> No Record available </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @include('partials.election_result', ['type' => 'LGA', 'slug'=>'lga'])
                </section>
                @endif

                 */
                ?>

                </div>

            </div>
        </div>
    </section>
</section>

<script>
    $(function(){
        var hide_all_except = ($id="") => {
            $('.hide_').hide();
            $('.btn_').removeClass('btn-success').addClass('btn-outline-success');
            $("#"+$id+'-page').show();
        }
        $('.click_btn').on('click', (e) => {
            var id_ = e.target.id;
                hide_all_except(id_);
                $('#'+id_).removeClass('btn-outline-success').addClass('btn-success');
        });
    })
</script>

@stop

