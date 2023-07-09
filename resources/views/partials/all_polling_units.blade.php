<select name="polling_unit_id" class="form-control" style="width:100%;">
                    <option value=""> -Select P.U- </option>
                    @foreach( all_polling_units() as $pu)
                    <option value="{{$pu->id}}"> {{ $pu->name }} </option>
                    @endforeach
</select>
