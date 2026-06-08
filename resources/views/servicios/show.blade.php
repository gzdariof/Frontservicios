@extends('layouts.app')

@section('title', 'Detalle – ' . $servicio['codigo'])

@section('content')
<div class="breadcrumb">
    <a href="{{ route('servicios.index') }}">Servicios</a>
    <span class="sep">/</span>
    <span>{{ $servicio['codigo'] }}</span>
</div>

<div class="page-header">
    <div>
        <h1>{{ $servicio['nombre'] }}</h1>
        <p>Detalle del servicio registrado</p>
    </div>
    <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
        <a href="{{ route('servicios.edit', $servicio['id']) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">← Volver</a>
    </div>
</div>

<div class="detail-grid" style="margin-bottom:1.5rem;">
    <div class="detail-item">
        <div class="detail-label">Código</div>
        <div class="detail-value code">{{ $servicio['codigo'] }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Precio</div>
        <div class="detail-value price">$ {{ number_format($servicio['precio'], 2, '.', ',') }}</div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Estado</div>
        <div class="detail-value" style="margin-top:.2rem;">
            @if($servicio['estado'])
                <span class="badge badge-active"><span class="dot"></span>Activo</span>
            @else
                <span class="badge badge-inactive"><span class="dot"></span>Inactivo</span>
            @endif
        </div>
    </div>
    <div class="detail-item">
        <div class="detail-label">Requiere Autorización</div>
        <div class="detail-value" style="margin-top:.2rem;">
            @if($servicio['requiereAutorizacion'])
                <span class="badge badge-yes">✓ Sí</span>
            @else
                <span class="badge badge-no">— No</span>
            @endif
        </div>
    </div>
    @if(!empty($servicio['created_at']))
    <div class="detail-item">
        <div class="detail-label">Creado</div>
        <div class="detail-value" style="font-size:.9rem;">
            {{ \Carbon\Carbon::parse($servicio['created_at'])->format('d/m/Y H:i') }}
        </div>
    </div>
    @endif
    @if(!empty($servicio['updated_at']))
    <div class="detail-item">
        <div class="detail-label">Actualizado</div>
        <div class="detail-value" style="font-size:.9rem;">
            {{ \Carbon\Carbon::parse($servicio['updated_at'])->format('d/m/Y H:i') }}
        </div>
    </div>
    @endif
</div>

<div class="card" style="max-width:720px;">
    <div class="card-header"><h2>Nombre completo</h2></div>
    <div class="card-body">
        <p style="font-size:1rem; line-height:1.7;">{{ $servicio['nombre'] }}</p>
    </div>
</div>

<div style="margin-top:2rem;">
    <button
        class="btn btn-danger"
        onclick="document.getElementById('modal-eliminar').classList.add('open')">
        Eliminar servicio
    </button>
</div>

{{-- Modal de confirmación --}}
<div class="modal-overlay" id="modal-eliminar">
    <div class="modal">
        <h3>¿Eliminar servicio?</h3>
        <p>Esta acción eliminará permanentemente "{{ $servicio['nombre'] }}".</p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="document.getElementById('modal-eliminar').classList.remove('open')">Cancelar</button>
            <form method="POST" action="{{ route('servicios.destroy', $servicio['id']) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('modal-eliminar').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
@endpush
