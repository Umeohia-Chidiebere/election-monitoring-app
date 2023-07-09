<select name="state_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select state- </option>
                    @foreach( all_states() as $state )
                    <option value="{{$state->id}}">{{ $state->name }}</option>
                    @endforeach
                </select>
                