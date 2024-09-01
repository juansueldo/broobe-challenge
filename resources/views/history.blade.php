

@section('active-history', 'active')
@extends('layouts.main')
@section('title', 'Broobe Challenge')

@section('content')
<div class="card">
    <table id="history-table" class="display responsive nowrap mb-3" style="width:100%;">
        <thead>
            <tr>
                <th>{{__('metrics.url')}}</th>
                <th>{{__('metrics.accessibility')}}</th>
                <th>{{__('metrics.bestpractices')}}</th>
                <th>{{__('metrics.performance')}}</th>
                <th>{{__('metrics.pwa')}}</th>
                <th>{{__('metrics.seo')}}</th>
                <th>{{__('metrics.strategy')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($metrics as $metric)
            <tr>
                <td>{{ $metric->url }}</td>
                <td>{{ $metric->accessibility_metric }}</td>
                <td>{{ $metric->best_practices_metric }}</td>
                <td>{{ $metric->performance_metric }}</td>
                <td>{{ $metric->pwa_metric }}</td>
                <td>{{ $metric->seo_metric }}</td>
                <td>{{ $metric->strategy->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#myTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros coincidentes",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
@endpush
