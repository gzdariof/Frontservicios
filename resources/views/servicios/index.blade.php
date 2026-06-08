@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
<div class="page-header">
    <div>
        <h1>Servicios</h1>
        <p>{{ count($servicios) }} {{ count($servicios) === 1 ? 'registro' : 'registros' }} en total</p>
    </div>
    <a href="{{ route('servicios.create') }}" class="btn btn-primary">
        + Nuevo Servicio
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Lista de Servicios</h2>
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" id="search" placeholder="Buscar..." autocomplete="off">
        </div>
    </div>

    @if(count($servicios) > 0)
        <div class="table-wrapper">
            <table id="tabla-servicios">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Autorización</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                    <tr data-search="{{ strtolower($servicio['codigo'] . ' ' . $servicio['nombre']) }}">
                        <td>
                            <span style="font-family: var(--mono); color: var(--accent2); font-size:.85rem;">
                                {{ $servicio['codigo'] }}
                            </span>
                        </td>
                        <td style="max-width:340px;">{{ $servicio['nombre'] }}</td>
                        <td class="precio">
                            $ {{ number_format($servicio['precio'], 2, '.', ',') }}
                        </td>
                        <td>
                            @if($servicio['estado'])
                                <span class="badge badge-active"><span class="dot"></span>Activo</span>
                            @else
                                <span class="badge badge-inactive"><span class="dot"></span>Inactivo</span>
                            @endif
                        </td>
                        <td>
                            @if($servicio['requiereAutorizacion'])
                                <span class="badge badge-yes">✓ Sí</span>
                            @else
                                <span class="badge badge-no">— No</span>
                            @endif
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('servicios.show', $servicio['id']) }}"
                                   class="btn btn-secondary btn-sm" title="Ver detalle">Ver</a>
                                <a href="{{ route('servicios.edit', $servicio['id']) }}"
                                   class="btn btn-secondary btn-sm" title="Editar">Editar</a>
                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="confirmarEliminar({{ $servicio['id'] }}, '{{ addslashes($servicio['nombre']) }}')"
                                    title="Eliminar">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="icon">📋</div>
            <h3>Sin servicios registrados</h3>
            <p>Crea el primer servicio para comenzar.</p>
            <br>
            <a href="{{ route('servicios.create') }}" class="btn btn-primary">+ Nuevo Servicio</a>
        </div>
    @endif
</div>

{{-- Modal de confirmación de eliminación --}}
<div class="modal-overlay" id="modal-eliminar">
    <div class="modal">
        <h3>¿Eliminar servicio?</h3>
        <p id="modal-nombre">Esta acción no se puede deshacer.</p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <form id="form-eliminar" method="POST" style="display:inline;">
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
    function confirmarEliminar(id, nombre) {
        document.getElementById('form-eliminar').action = `/servicios/${id}`;
        document.getElementById('modal-nombre').textContent = `¿Seguro que deseas eliminar "${nombre}"?`;
        document.getElementById('modal-eliminar').classList.add('open');
    }
    function cerrarModal() {
        document.getElementById('modal-eliminar').classList.remove('open');
    }
    document.getElementById('modal-eliminar').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });

    // Búsqueda en tabla
    document.getElementById('search').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tabla-servicios tbody tr').forEach(row => {
            row.style.display = row.dataset.search.includes(q) ? '' : 'none';
        });
    });
</script>
@endpush
