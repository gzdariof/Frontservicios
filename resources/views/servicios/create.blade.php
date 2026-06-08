@extends('layouts.app')

@section('title', 'Nuevo Servicio')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('servicios.index') }}">Servicios</a>
    <span class="sep">/</span>
    <span>Nuevo</span>
</div>

<div class="page-header">
    <div>
        <h1>Nuevo Servicio</h1>
        <p>Completa los campos para registrar un nuevo servicio.</p>
    </div>
</div>

<div class="card" style="max-width: 720px;">
    <div class="card-body">
        <form method="POST" action="{{ route('servicios.store') }}">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label for="codigo">Código *</label>
                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        value="{{ old('codigo') }}"
                        maxlength="10"
                        placeholder="Ej: SVC-001"
                        class="{{ $errors->has('codigo') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('codigo')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                    <span class="help-text">Máximo 10 caracteres</span>
                </div>

                <div class="form-group">
                    <label for="precio">Precio *</label>
                    <input
                        type="number"
                        id="precio"
                        name="precio"
                        value="{{ old('precio') }}"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        class="{{ $errors->has('precio') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('precio')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="nombre">Nombre *</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        maxlength="500"
                        placeholder="Descripción del servicio"
                        class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('nombre')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <div class="form-group toggle-group" style="margin-top:.4rem;">
                        <span class="toggle-label-text">Servicio activo</span>
                        <label class="toggle">
                            <input
                                type="checkbox"
                                name="estado"
                                value="1"
                                {{ old('estado', '1') ? 'checked' : '' }}
                            >
                            <span class="toggle-slider"></span>
                        </label>
                        <input type="hidden" name="_estado_sent" value="1">
                    </div>
                </div>

                <div class="form-group">
                    <label>Requiere Autorización</label>
                    <div class="form-group toggle-group" style="margin-top:.4rem;">
                        <span class="toggle-label-text">Requiere autorización previa</span>
                        <label class="toggle">
                            <input
                                type="checkbox"
                                name="requiereAutorizacion"
                                value="1"
                                {{ old('requiereAutorizacion') ? 'checked' : '' }}
                            >
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--border);">
                <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Los checkboxes de toggle necesitan enviar 0 cuando están desmarcados
    document.querySelector('form').addEventListener('submit', function() {
        ['estado', 'requiereAutorizacion'].forEach(name => {
            const cb = this.querySelector(`input[name="${name}"]`);
            if (!cb.checked) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = name;
                hidden.value = '0';
                this.appendChild(hidden);
            }
        });
    });
</script>
@endpush
