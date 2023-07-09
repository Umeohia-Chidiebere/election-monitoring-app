@extends("layouts.app")
@section('content')
<p class="page_title hide"> Event Reports </p>

<section class="app-main__outer">
    <section class="app-main__inner">
        <div class="card">
            <div class="card-header">
                @if ( request()->has('create'))
                <a href="{{ route('posts_page')}}" class="btn btn-outline-info"> Back to Reports </a>
                @else
                <a href="?create=1" class="btn btn-outline-success"> Create Report </a>
                @endif
                
            </div>

        <div class="card-body">
            @include('partials.alert_msg')

            @if ( request()->has('create'))
            <div>
                <form action="{{ route('store_post')}}" method="post" enctype="multipart/form-data">
                    @csrf()
                    <div class="form-group">
                        <label for="">Select Polling unit</label>
                        @include("partials.all_polling_units")
                    </div>
                    <div class="form-group">
                        <textarea required name="content" cols="30" rows="5" placeholder="What's happening around you?" class="form-control"></textarea>
                    </div>
                    <input type="file" class="hide input_file_1-1-1" name="docs[]" multiple>
                    <div class="form-group">
                        <button type="button" id="1-1-1" class="attach_file btn btn-outline-secondary"> Attach files </button>
                        <button type="submit" class="btn btn-outline-success"> Report now </button>
                    </div>
                </form>
            </div>
            @else
             <section class="font-weight-bold">
                <h5> Total Reports ({{event_reports_count() }})</h5>
             </section>
            @endif
        </div>
            
        </div>

@if ( ! request()->has('create') )

   <!-- Show Reports -->
   @foreach ( event_reports() as $post )
   <div class="card mt-3 mb-2">
       <Section class="card-header text-muted text-capitalize">
           <i class="fa fa-user-circle"></i>  &nbsp; {{ $post->user->fullnames() }} 
           @if( current_user()->id == $post->user_id )
            &nbsp; <a onclick="return confirm('You are about to delete this report...')" href="?delete=1&id={{$post->code_number}}" class="btn btn-outline-danger"> Delete Report </a>
          @endif
        </Section>

       <div class="card-body text-muted">
            @if( isset( $post->ip_info ))  
               <p class="mt-3"><i class="fa fa-map-marker text-info"></i> {{$post->ip_info->state. ', '. $post->ip_info->country }}</p>
            @endif
            <p class="text-justify"> 
                <span class="fa fa-calendar"></span> {{ $post->updated_at->diffForHumans() }} 
                @if ($post->polling_unit_id ))
                | <span class="fa fa-flag"></span> P.U: {{ $post->polling_unit->fullnames()}} 
                @endif
               
            </p> <hr>

           <section class="row">
               <section class="col-md-7">
                   {{ $post->content }}

                   <hr>
                   <!-- Show files -->
                  <div class="row">
                        @if ( isset($post->docs) )  
                        @foreach ( $post->docs as $doc )
                           <section class="col-md-6">
                            @include('partials.display_files', [ "path" => post_folder(), "file_name" => $doc->file_name, "file_type" => $doc->file_type] )
                        <br>   
                        </section>
                            @endforeach
                        @endif
                  </div>

               <!-- ///End show files -->
               </section>
               

               <!-- show comments -->
               <section class="col-md-5 mt-3">
        
                <h6> {{$post->comments()->count() }} Response(s)</h6>
                <hr>
                <div style="max-height:500px;" class="overflow-auto">
                    @foreach ( $post->comments() as $comment )
                    <p class="text-primary"> 
                        <i class="fa fa-user-circle"></i> &nbsp; {{ $comment->user->fullnames() }} 
                        <br>
                        <i class="fa fa-clock text-muted"> <em> {{ $comment->updated_at->diffForHumans() }} </em> </i>
                        @if( current_user()->id == $comment->user_id )
                        &nbsp; <a onclick="return confirm('You are about to delete this response...')" href="?delete=1&id={{$comment->code_number}}" class="text-muted"> <i class="fa fa-trash"></i> Delete </a>
                      @endif
                    </p>
                    
                    <section class="mb-3"> {{ $comment->content }} </section>
                    
                      <!-- Show files -->
                  <div class="row">
                    @if ( isset($comment->docs) )  
                    @foreach ( $comment->docs as $doc )
                       <section class="col-md-6">
                        @include('partials.display_files', [ "path" => post_folder(), "file_name" => $doc->file_name, "file_type" => $doc->file_type] )
                    <br>   
                    </section>
                        @endforeach
                    @endif
              </div>

           <!-- ///End show files -->
           <hr>
                @endforeach
                </div>
                
               </section>
                <!-- //end show comments -->
           </section>
               

           <section class="card-foote mt-3">
            <hr>
               <form action="{{ route('store_post')}}" method="post" enctype="multipart/form-data">
                   <input type="hidden" name='type' value="comment">
                   <input type="hidden" name='post_id' value="{{$post->id}}">
                   @csrf()
                   <div class="form-group">
                       <input name="content" required placeholder="Leave a Response..." class="form-control full_width">
                   </div>
                   <input type="file" class="hide input_file_{{$post->id}}" name="docs[]" multiple>
                   <div class="form-group">
                       <button type="button" id="{{$post->id}}" class="attach_file btn btn-outline-secondary"> Attach files </button>
                       <button type="submit" class="btn btn-outline-success"> Respond now </button>
                   </div>
               </form>
           </section>
           
          
       </div>
   </div>
   @endforeach

   {{ event_reports()->links() }}
  
   <!-- //End show reports -->
    
@endif

     
    </section>
</section>

<script>
    $( function(){
        $('.attach_file').on('click', (e) => {
            var id_ = e.target.id;
            $('.input_file_'+id_).click();
        });
    });
</script>
@stop
