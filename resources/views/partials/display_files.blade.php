@if( $file_type == "image")
<img src="{{ asset( $path.$file_name ) }}" class=" img-thumbnail" style="width:100%; height:300px;"/>

@elseif ( $file_type == "video")
<video poster="{{logo()}}" controls name="media" class=" img-thumbnail" style="width:100%; height:300px;"> 
    <source src="{{ asset( $path.$file_name ) }}" type="video/mp4">
    Your broswer doesn't support this video... 
</video>

@elseif ( $file_type == "audio")
<video poster="{{logo()}}" controls name="media" class=" img-thumbnail" style="width:100%; height:300px;"> 
    <source src="{{ asset( $path.$file_name ) }}" type="audio/mp3">
    Your broswer doesn't support this audio... 
</video>

@else

<a href="{{ asset( $path.$file_name ) }}" target="blank"> 
    <div class="card">
        <div class="card-header "> 
              <p class="text-center"> <i class="fa fa-eye"> </i>  View Document </p>
        </div>
    </div>
</a>


@endif