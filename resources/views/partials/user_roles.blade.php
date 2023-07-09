<select name="role_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select Role- </option>
                    @foreach( all_roles() as $role )
                    @if(current_user()->is_super_admin() || $role->slug == 'user')
                    <option value="{{$role->id}}"> {{ $role->name }}</option>
                    @endif

                    @endforeach
                </select>