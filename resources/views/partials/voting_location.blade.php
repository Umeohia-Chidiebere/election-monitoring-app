<select name="category_id" required class="form-control" style="width:100%;">
                    <option value=""> -Select- </option>
                    @foreach( all_categories() as $cat)
                    <option value="{{$cat->id}}"> {{ $cat->name }} </option>
                    @endforeach
</select>
