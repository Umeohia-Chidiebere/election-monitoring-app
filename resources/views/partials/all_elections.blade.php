<select name="election_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select election- </option>
                    @foreach( all_active_elections() as $election )
                    @if(isset($type))
                    @if( $type == $election->category->slug )
                    <option value="{{$election->id}}"> {{ $election->fullnames() }} </option>
                    @endif

                    @endif
                    @endforeach
</select>
