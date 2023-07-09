@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    All Polling units ({{all_polling_units()->count()}})
                                  </section>
<div class="card-body">
    
@include('partials.alert_msg')

@if( current_user()->is_admin() )
<p class="">
    <button class="show_form_ btn btn-sm toggle_show_form btn-outline-success"> <i class="fa fa-plus"></i> Add new </button>
    <button class="show_form_ hide btn btn-sm toggle_show_form btn-outline-info"> Hide Form </button>
</p>

<form action="{{ route('store_settings')}}" method="post" class="show_form_ hide">
    <div class="loc_btn">
        <button class="btn btn-sm btn-outline-secondary get_location"> Get Location </button>
    <p> Please, Give permission to your location first... </p>
    </div>
    <section class="hide_pu">
        @csrf()
        <input type="hidden" name="store_polling_units" value="1">
            <div class="form-group">
                <label for=""> Select ward </label>
                @include('partials.all_wards')
            </div>

            <div class="form-group">
                <label for=""> Polling unit Agent </label>
                @include('partials.all_users')
            </div>

            <div class="form-group" hide>
            <input type="hidden" name='latitude' id="coord_latitude">
            <input type="hidden" name='longitude' id="coord_longitude">
            </div>

               <div class="form-group" >
                     <label for=""> Polling unit name <br> <small> Separate each P.U name with a comma (,) </small> </label>
                    <div class="input-group">  
                      <input type="text" required name="name" class="form-control" placeholder="Enter P.U name">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create </span> </button>
                      </div>
                      
                    </div>
                </div>
            </section>
        </form>
    @endif

        <section class="">

        @if( current_user()->is_admin() )
            <form onsubmit="return confirm('You are about to remove this Items...')" action="" method="post">
            @csrf()
            <input type="hidden" name="remove_polling_units" value='1'>
                <button type="submit" class="btn btn-outline-danger btn-sm"> Remove </button>
                @endif

            <div class="table-responsive mt-3">
                <table class="table table-striped datatable_">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkedAll"></th>
                            <th> Polling unit </th>
                            <th> ward </th>
                            <th> LGA </th>
                            <th>State</th>
                            <th> Lead Agent</th>
                            <th> Assigned By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( all_polling_units() as $index => $pu )
                        <tr>
                            <td> <input type="checkbox" class="checkSingle" name="id[]" value="{{$pu->id}}"> </td>
                            <td>{{$pu->name}}</td>
                            <td>{{$pu->ward->name }}</td>
                            <td>{{$pu->ward->lga->name }}</td>
                            <td>{{$pu->ward->lga->state}} </td>
                            <td>{{$pu->user->fullnames() }} </td>
                            <td>{{$pu->assigned_by->fullnames() }} </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center"> No Record Available... </td>
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

<script>
     $( function (){
        var form_ = $('.hide_pu');
        var loc_btn = $('.loc_btn');
        var x = $("#coord_latitude"),
            y = $("#coord_longitude");
        form_.hide();

    function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        alert("Geolocation is not supported by this device.");
      }
    }
    
    function showPosition(position) {
            x.val(position.coords.latitude);
            y.val(position.coords.longitude);
            check_location_permission_status();
         }

        
    function check_location_permission_status()
    {
        navigator.permissions.query({name:'geolocation'}).then(function(result) {
         // Will return ['granted', 'prompt', 'denied']
        // return alert( result.state )
         if( result.state == "denied") return alert( "Location access is denied, please go to your settings and manually Grant location access !") ;
         if( result.state == "granted"){
            form_.show();
            loc_btn.hide();
         }
        });
    }

    check_location_permission_status();
     
        $('.get_location').on('click', getLocation );
     });
</script>

@stop

