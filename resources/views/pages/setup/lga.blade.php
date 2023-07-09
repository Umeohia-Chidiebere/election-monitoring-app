@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    All LGA
                                  </section>
<div class="card-body">

        <section class="">
            <div class="table-responsive">
                <table class="table table-striped datatable_">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Name </th>
                            <th> State </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( all_lga() as $index => $c )
                        <tr>
                            <td>{{++$index}}</td>
                            <td>{{$c->name}}</td>
                            <td>{{$c->state}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center"> No Record Available... </td>
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
