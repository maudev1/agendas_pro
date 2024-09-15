<div class="row">
    <div class="col-sm-12 col-md-4 col-bg-4">
        <input id="id" name="id" type="hidden">

        @foreach($fields as $field)

        <div class="form-group">

            <label>{{ $field['label'] }} </label>

            <input id="{{ $field['field'] }}" class="form-control <?php echo isset($field['class']) ? implode(" ", $field['class']) : null ?>" name="{{ $field['field'] }}">

        </div>

        @endforeach

    </div>
</div>

<hr>

<div class="row">
    
    <div class="col-sm-12 col-md-4 col-bg-4"><h4 class="display-6">Permissões</h4></div>
    
</div>

<hr>

<div class="row">

    @foreach($permissions as $permission)

    <div class="col-sm-12 col-md-4 col-bg-4">

        <div class="form-check form-switch">
            <input class="form-check-input" id="{{ $permission->name }}" value="{{ $permission->name }}" name="{{ $permission->name }}" type="checkbox">

            <label for="{{ $permission->name }}" class="form-check-label">
                {{ $permission->attributes->label }}
            </label>

        </div>

    </div>

    @endforeach
</div>