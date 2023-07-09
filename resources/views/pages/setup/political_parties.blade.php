@extends("layouts.app")
@section('content')

<section class="app-main__outer">
                    <section class="app-main__inner">

                      <div class="row"> <!-- row -->
                           
                        <section class="col-md-12">       
                               <div class="card">
                                  <section class="card-header page_title"> 
                                    All Political Parties ({{ all_political_parties()->count() }})
                                  </section>
                        <div class="card-body">
                        @include('partials.alert_msg')

@if( current_user()->is_super_admin() )                            
<p class="">
    <button class="show_form_ btn btn-sm toggle_show_form btn-outline-success"> <i class="fa fa-plus"></i> Add new </button>
    <button class="show_form_ hide btn btn-sm toggle_show_form btn-outline-info"> Hide Form </button>
</p>
        <form action="{{ route('store_political_party')}}" method="post" class="hide show_form_" enctype="multipart/form-data">
                                        @csrf()

            <div class="form-group">
                <label for=""> Party fullname </label>
                <input type="text" name="name" required class="form-control" placeholder="Labour Party etc...">
            </div>

            <div class="form-group">
                <label for=""> Party short name</label>
                <input type="text" name="short_name" required class="form-control" placeholder="PDP, LP, APC etc..">
            </div>

            <div class="form-group">
                <label for=""> Party Motto </label>
                <input type="text" name="motto" required class="form-control" placeholder="Party motto...">
            </div>

               <div class="form-group">
                Party Logo
                    <div class="input-group">  
                      <input type="file" required name="img" accept="image/*" class="form-control">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create Party</span> </button>
                      </div>
                    </div>
                </div>
        </form>

@endif

        <section class="mt-3">
            @if( current_user()->is_super_admin() )
            <form onsubmit="return confirm('You are about to remove this Items...')" action="" method="post">
            @csrf()
            <input type="hidden" name="remove_party" value='1'>
                <button type="submit" class="btn btn-outline-danger btn-sm"> Remove </button>
                @endif
            <div class="table-responsive">
                <table class="table table-striped word_no_wrap">
                    <thead>
                        <tr>
                            <th><input class="checkedAll" type="checkbox"> </th>
                            <th></th>
                            <th> Name </th>
                            <th> Short Name </th>
                            <th> Motto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( all_political_parties() as $index=>$political_party)
                        <tr class="word_no_wrap">
                            <td>
                               <input class="checkSingle" type="checkbox" name="id[]" value="{{$political_party->id}}">
                            </td>
                            <td>
                                <img src="{{ asset( party_logo_folder().$political_party->logo)}}" class="img-thumbnl img-40">
                            </td>
                            <td>
                               {{$political_party->name}}
                            </td>
                            <td>
                                {{$political_party->short_name}}
                            </td>
                            <td>
                                {{$political_party->motto}}
                            </td>
                          
                        </tr>
                        
                        @empty
                        <tr>
                            <td colspan="5" class="text-center"> No Record Available...</td>
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
