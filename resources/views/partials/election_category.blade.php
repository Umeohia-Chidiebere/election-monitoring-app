<select name="election_type_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select Type- </option>
                    @foreach( election_category() as $cat)
                    <option value="{{$cat->id}}"> {{ $cat->name }} </option>
                    @endforeach
</select>
