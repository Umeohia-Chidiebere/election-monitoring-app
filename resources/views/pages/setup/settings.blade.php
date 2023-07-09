@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    {{ $title }} - Settings
                                  </section>
<div class="card-body">

<p class="">
    <button class="show_form_ btn btn-sm btn-outline-success toggle_show_form"> <i class="fa fa-plus"></i> Add new </button>
    <button class="show_form_ hide btn btn-sm btn-outline-info toggle_show_form"> Hide Form </button>
</p>

<form action="{{ route('store_settings')}}" method="post" class="show_form_ hide">
        @csrf()
        <input type="hidden" name="category_id" value="{{ $category->id }}">
            <div class="form-group">
                @include('partials.all_states')
            </div>

            <div class="form-group">
                <input name="location" required class="form-control" placeholder="Enter Location...">
            </div>

               <div class="form-group">
                    Separate each name with a comma (,)
                    <div class="input-group">  
                      <input type="text" required name="name" class="form-control" placeholder="Enter {{ $title }} name...">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create </span> </button>
                      </div>
                    </div>
                </div>
        </form>

        <section class="mt-5">
            <div class="table-responsive">
                <table class="table table-striped datatable_">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Name </th>
                            <th> Location </th>
                            <th> State</th>
                            <th> Created by</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( $category->election_categories as $index => $c )
                        <tr>
                            <td>{{++$index}}</td>
                            <td>{{$c->name}}</td>
                            <td>{{$c->location}}</td>
                            <td>{{$c->state->name}}</td>
                            <td>{{$c->user->username()}}</td>
                            <td>
                                <button class="btn btn-outline-success btn-sm"> Update </button>
                                <button class="btn btn-outline-danger btn-sm"> Delete </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center"> No Record Available... </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

                                    </div>
                                </div>
                        </section> <!-- //col -->

                      </div> <!-- //row -->

                    </section>
</section>

@stop
