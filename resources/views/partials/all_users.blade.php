<select name="user_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select user- </option>
                    @foreach( all_users() as $user )
                    <option value="{{$user->id}}"> {{ $user->name }} ({{ $user->username() }})</option>
                    @endforeach
                </select>