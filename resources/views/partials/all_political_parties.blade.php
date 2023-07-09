<select name="political_party_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select Party- </option>
                    @foreach( all_political_parties() as $party )
                    <option value="{{$party->id}}"> {{ $party->short_name . ' - '.$party->name }} </option>
                    @endforeach
</select>
