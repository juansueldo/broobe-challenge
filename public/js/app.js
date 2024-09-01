$(document).ready(function() {
    if (localStorage.getItem('theme') === 'dark') {
        $('body').addClass('dark-mode');
        $('#toggle-mode').prop('checked', true);
    }

    $('#toggle-mode').on('change', function() {
        $('body').toggleClass('dark-mode');

        if ($(this).is(':checked')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
    $('#strategy').select2();
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
/*
function getStatics(categories, element) {
    const container = $('<div>').addClass('container-circles');
    const chartContainer = $('<div>').addClass('chart-container').css('position', 'relative').appendTo(container);
    const chartCanvas = $('<canvas>').attr('id', 'myChart').appendTo(chartContainer);

    const labels = [];
    const data = [];

    for (let category in categories) {
        labels.push(category);
        data.push(categories[category].score);

        element.append(`<input type="hidden" name="${category}" id="${category}" value="${categories[category].score}">`);
    }

    element.append(container);

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Metrics Score'
                }
            }
        },
    });
}
*/