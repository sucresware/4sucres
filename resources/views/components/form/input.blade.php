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
        <input
            type="{{ $type ?? 'text' }}"
            id="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror {{ $class ?? '' }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? null) }}"
            {{ $readonly ?? false ? 'readonly' : '' }}
            {{ $disabled ?? false ? 'disabled' : '' }}
            {{ $required ?? false ? 'required' : '' }} />

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