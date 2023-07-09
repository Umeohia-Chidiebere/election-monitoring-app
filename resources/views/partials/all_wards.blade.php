<select name="ward_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select Ward- </option>
                    @foreach( all_wards() as $ward)
                    <option value="{{$ward->id}}"> {{ $ward->fullnames() }} </option>
                    @endforeach
</select>
