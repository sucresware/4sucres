<div class="form-group row">
    @if ($label ?? '')
        <label
            for="{{ $name }}"
            class="col-12">
            {{ $label }}
            @if ($required ?? false)
                <span class="text-error">*</span>
            @endif
        </label>
    @endif

    <div class="col-md-12">
        <select
            type="{{ $type ?? 'text' }}"
            id="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror {{ $class ?? '' }}"
            name="{{ $name }}"
            {{ $multiple ?? false ? 'multiple' : '' }}
            {{ $disabled ?? false ? 'disabled' : '' }}
            {{ $required ?? false ? 'required' : '' }} />
            @foreach ($options as $key => $option)
                <option
                    @if ($multiple ?? false)
                        {{ in_array($key, old($name, $value ?? null)->toArray()) ? 'selected' : '' }}
                    @else
                        {{ old($name, $value ?? null) == $key ? 'selected' : '' }}
                    @endif
                    value="{{ $key }}">
                    {{ $option }}
                </option>
            @endforeach
        </select>

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        @if ($help_text ?? null)
            <span class="help-block">{{ $help_text }}</span>
        @endif
    </div>
</div>