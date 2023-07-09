<select name="lga_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select Location- </option>
                    @foreach( all_lga() as $lga )
                    <option value="{{$lga->id}}"> {{ $lga->name . ', '. $lga->state }} </option>
                    @endforeach
</select>
