@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    All Wards ({{ all_wards()->count() }})
                                  </section>
<div class="card-body">
@include('partials.alert_msg')

@if( current_user()->is_admin()  )
<p class="">
    <button class="show_form_ btn btn-sm btn-outline-success toggle_show_form"> <i class="fa fa-plus"></i> Add new </button>
    <button class="show_form_ hide btn btn-sm btn-outline-info toggle_show_form"> Hide Form </button>
</p>

<form action="{{ route('store_settings')}}" method="post" class="show_form_ hide">
        @csrf()
        <input type="hidden" name="store_wards" value="1">
            <div class="form-group">
                <label for=""> Select LGA </label>
                @include('partials.all_lga') 
            </div>

            <div class="form-group">
                <label for=""> Ward Leader </label>
                @include('partials.all_users')
            </div>

                <div class="form-group">
                     <label for=""> Ward name <br> <small> Separate each ward name with a comma (,) </small> </label>
                    <div class="input-group">  
                      <input type="text" required name="name" class="form-control" placeholder="Enter wards name">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create </span> </button>
                      </div>
                      
                    </div>
                </div>
</form>
@endif

        <section class="mt-3">

        @if( current_user()->is_admin() )
            <form onsubmit="return confirm('You are about to remove this Items...')" action="" method="post">
            @csrf()
            <input type="hidden" name="remove_wards" value='1'>
                <button type="submit" class="btn btn-outline-danger btn-sm"> Remove </button>
                @endif

            <div class="table-responsive mt-3">
                <table class="table table-striped datatable_">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" class="checkedAll"> </th>
                            <th> Ward </th>
                            <th> LGA </th>
                            <th> State</th>
                            <th> Ward Leader </th>
                            <th> Assigned by</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( all_wards() as $index => $ward )
                        <tr>
                            <td>
                                <input type="checkbox" name="id[]" value="{{$ward->id}}" class="checkSingle">
                            </td>
                            <td>{{$ward->name}}</td>
                            <td>{{$ward->lga->name }}</td>
                            <td>{{$ward->lga->state}}</td>
                            <td>{{$ward->user->fullnames() }}</td>
                            <td>{{$ward->assigned_by->fullnames() }} </td>
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

@stop

