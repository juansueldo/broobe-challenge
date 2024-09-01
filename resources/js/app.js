import './bootstrap';

$(document).ready(function() {
    if (localStorage.getItem('theme') === 'dark') {
        $('body').addClass('dark-mode');
        $('#toggle-mode').prop('checked', true);
    }
    
    $('.dropdown').hover(function() {
        $(this).find('.dropdown-content').slideDown(200);
    }, function() {
        $(this).find('.dropdown-content').slideUp(200);
    });
    $('#toggle-mode').on('change', function() {
        $('body').toggleClass('dark-mode');

        if ($(this).is(':checked')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });

    $('#strategy').select2();
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
        if(url === '' || !isValidURL(url)){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese una url valida',
                width: '400px' 
            });
            return;
        }
        const strategy = $('#strategy').val();
        categories = categories.map(cat => `category=${cat}`).join('&');
        $.ajax({
            url: "/get-metrics",
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
            url: "/save-metrics",
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

function getColor(score){
    let color='';
    if(score > 0 && score <= 0.25){
        color = 'red';
    }else if(score > 0.25 && score < 0.5){
        color = 'orange';
    }else if(score >= 0.5 && score <= 0.75){
        color = 'yellow';
    }else{
        color = 'green';
    }
    return color;
}

function getStatics(categories, element){
    const container = $('<div>').addClass('container-circles');
    for (let category in categories) {
        const circle=$('<div>').addClass('circle').attr({
            'data-degree': categories[category].score * 100,
            'data-color': '#fee800'
        }).css({'background': `conic-gradient(${getColor(categories[category].score)} ${categories[category].score * 100}%, #222 0%)`});
        const number = $('<h2>').addClass('number').text(categories[category].score);
        const title = $('<h4>').text(category);
        circle.append(number);
        circle.append(title);
        container.append(circle);
        element.append(container)
        element.append(`<input type="hidden" name="${category}" id="${category}" value="${categories[category].score}">`);
    }
}

document.addEventListener("DOMConetentLoaded", function(event){
    let circle=document.querySelectorAll('.circle');
    circle.forEach(function(progress){
        let degree = 0;
        var targetDegree = parseInt(progress.getAttribute('data-degree'));
        let color = progress.getAttribute('data-color');
        let number = progress.querySelector('.number');

        var interval = setInterval(function(){
            degree += 1;
            if(degree > degree){
                clearInterval(interval);
                return;
            }
            progress.style.background = `conic-gradient(${color} ${degree}%,#222 0%)`;
        },50)
    })
})
function isValidURL(string) {
    const regex = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(:\d+)?(\/\S*)?$/;
    return regex.test(string);
}