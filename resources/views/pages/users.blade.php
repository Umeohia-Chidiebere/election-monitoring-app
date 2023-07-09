@extends("layouts.app")
@section('content')
<p class="page_title hide"> All Admins </p>

<section class="app-main__outer">
                    <section class="app-main__inner">
                                 
                               <div class="card">
                                  <section class="card-header"> All users ({{ all_users()->count() }}) </section>
                                    <div class="card-body">

@if( current_user()->is_admin() )                                  
<p class="">
    <button class="show_form_ btn toggle_show_form btn-sm btn-outline-success"><i class="fa fa-plus"></i> Add new </button>
    <button class="show_form_ hide toggle_show_form btn btn-sm btn-outline-info"> Hide Form </button>
</p>

<form action="{{ route('register_user')}}" method="post" class="hide show_form_" enctype="multipart/form-data">
                                        @csrf()

            <div class="form-group">
                <label for=""> Name</label>
                <input type="text" name="name" required class="form-control" placeholder="Name...">
            </div>

            <div class="form-group">
                <label for=""> Phone Number</label>
                <input type="number" name="phone_number" required class="form-control" placeholder="080...">
            </div>

            <!-- <div class="form-group">
                <label for=""> Password </label>
                <input type="password" name="password" required class="form-control" placeholder="********">
            </div> -->

            <div class="form-group">
                @include('partials.user_roles')
            </div>

            <div class="form-group">
                @include('partials.all_lga')
            </div>

            <div class="form-group">
                    Email
                    <div class="input-group">  
                      <input type="email" required name="email" class="form-control" placeholder="Email...">
                      <div class="input-group-append">
                        <button class="btn btn-xs btn-success" type="submit"> <span class="font-14"> Create user </span> </button>
                      </div>
                    </div>
            </div>
   
        </form>
                                      <hr>
@endif

                                      <section class="table-responsive">
                                           <table class="table-hover table-striped table-bordered datatable_">
                                              <thead>
                                                  <tr>
                                                      <th> # </th>
                                                      <th> Name</th>
                                                      <th> Email</th>
                                                      <th> Phone</th>
                                                      <th> Location </th>
                                                      <th> Role </th>
                                                      <th></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                               @foreach( all_users() as $index => $user )
                                               <form onsubmit="return confirm('Please, confirm this transaction...')" action="{{ route('update_users')}}" method="post">
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                @csrf()
                                                  <tr>
                                                      <td> {{ ++$index }} </td>
                                                      <td> {{ $user->fullnames() }} 
                                                        <br>
                                                        <input type="text" name="name"  class="hide user-{{$user->id}}" value="{{$user->name}}">
                                                      </td>
                                                      <td> {{ $user->email }} 
                                                      <br>
                                                        <input type="email" name="email"  class="hide user-{{$user->id}}" value="{{$user->email}}">
                                                      </td>
                                                      <td> {{ $user->phone_number }} 
                                                      <br>
                                                        <input type="number" name="phone_number"  class="hide user-{{$user->id}}" value="{{$user->phone_number}}">
                                                      </td>
                                                      <td> {{ $user->lga->fullnames() ?? '-' }} 
                                                      <br>
                                                        <div class="hide user-{{$user->id}}">@include('partials.all_lga')</div>
                                                      </td>
                                                      <td> {{ $user->role->name }} 
                                                      <br>
                                                       <div class="hide user-{{$user->id}}"> @include('partials.user_roles')</div>
                                                      </td>
                                                      <td> 
                                                    @if( current_user()->is_admin() )
                                                       <button type="button" class="btn btn-outline-info btn-sm edit_user show_user_{{$user->id}}" id="{{$user->id}}"> Edit </button>
                                                       <button type="button" class="btn btn-outline-info btn-sm hide hide_user_edit hide_user_{{$user->id}}" id="{{$user->id}}"> Hide edit </button>
                                                       <button type="submit" name="update_user" class="btn btn-outline-success btn-sm hide hide_user_{{$user->id}}"> Update </button>
                                                       <button type="submit" name="remove_user" class="btn btn-outline-danger btn-sm show_user_{{$user->id}}"> Remove </button>
                                                       @endif
                                                       
                                                      </td>
                                                  </tr>
                                             </form>
                                                @endforeach
                                              </tbody>
                                           </table>
                                      </section>
                                    </div>
                                </div>

                    </section>
</section>

<script>
    $(function(){
        $('.edit_user').on('click', (e) => {
            var id_ = e.target.id;
                $('.user-'+id_).show();
                $('.hide_user_'+id_).show();
                $('.show_user_'+id_).hide()
        });

        $('.hide_user_edit').on('click', (e) => {
            var id_ = e.target.id;
                $('.user-'+id_).hide();
                $('.hide_user_'+id_).hide();
                $('.show_user_'+id_).show()
        });
    });
</script>

@stop

