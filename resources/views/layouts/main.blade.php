<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    @include('layouts.partials.header')
    @include('layouts.partials.sections')
    @include('layouts.partials.loader')

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#history-table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            });

            $('#submit-btn').on('click', function() {
                const url = $('#url').val();
                let categories = $('input[name="categories"]:checked').map(function() {
                    return this.value;
                }).get();
                const strategy = $('#strategy').val();
                categories = categories.map(cat => `category=${cat}`).join('&');
                $.ajax({
                    url: "{{ route('metrics') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({ url, categories, strategy }),
                    beforeSend: function() {
                        $('.container-loader').removeClass('d-none');
                    },
                    complete: function() {
                        $('.container-loader').addClass('d-none');
                    },
                    success: function(data) {
                        $('#metrics-results-form').removeClass('d-none');
                        const metricsResults = $('#metrics-results');
                        metricsResults.html('');
                        Swal.fire({
                            icon: "success",
                            title: "Datos obtenidos exitosamente",
                            showConfirmButton: true,
                            timer: 1500,
                            width: '400px' 
                        });
                        if (data.lighthouseResult) {
                            const categories = data.lighthouseResult.categories;
                            getStatics(categories, metricsResults);
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al obtener los datos. Intenta nuevamente.',
                            width: '400px' 
                        });
                    }
                });
            });

            $('#save-metrics-btn').on('click', function() {
                const url = $('#url').val();
                const accessibility = $('#accessibility').length ? $('#accessibility').val() : null;
                const pwa = $('#pwa').length ? $('#pwa').val() : null;
                const performance = $('#performance').length ? $('#performance').val() : null;
                const seo = $('#seo').length ? $('#seo').val() : null;
                const best_practices = $('#best-practices').length ? $('#best-practices').val() : null;
                const strategy = $('#strategy').val();

                $.ajax({
                    url: "{{ route('save') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({ url, accessibility, pwa, performance, seo, best_practices, strategy }),
                    beforeSend: function() {
                        $('.container-loader').removeClass('d-none');
                    },
                    complete: function() {
                        $('.container-loader').addClass('d-none');
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.success == true) {
                            Swal.fire({
                            icon: "success",
                            title: "Datos obtenidos exitosamente",
                            showConfirmButton: false,
                            timer: 1500,
                            width: '400px' 
                            });
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data,
                            width: '400px'  
                        });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al guardar los datos. Intenta nuevamente.',
                            width: '400px'  
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
