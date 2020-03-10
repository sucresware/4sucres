<div class="form-group">
    <div>
        <div class="form-check">
            <input
                id="{{ $name }}-{{ $value ?? 1 }}"
                type="checkbox"
                {{ old($name, $default ?? null) == $value ? 'checked' : '' }}
                name="{{ $name }}"
                value="{{ $value }}"
                class="form-check-input @error($name) is-invalid @enderror" />

            <label
                for="{{ $name }}-{{ $value ?? 1 }}"
                class="form-check-label">
                {{ $label }}
            </label>

        </div>

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>