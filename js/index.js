$(document).ready(function () {
    // Flip Clock

    var timeout = getTargetTime();
    var timerConfig = {
        clockFace: 'DailyCounter',
        countdown: true,
        language:'ru-ru',
    }

    $('#clock-top').FlipClock(timeout, timerConfig);
    $('#clock-bottom').FlipClock(timeout, timerConfig);

    function getTargetTime() {
        var now = new Date();
        var targetDate = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate() + 1
        );
        var diffTime = targetDate.getTime() - now.getTime();
    
        return diffTime / 1000;
    }
//



    // Burger

    $('.menu__icon').on('click', function() {
        $(this).closest('.menu').toggleClass('menu_state_open');
    });
    // 
    $('.menu__links-item').on('click', function() {
        $(this).closest('.menu').toggleClass('menu_state_open');
        $('[name="name"]')[0].focus();
    });


    // Forms

    $('.want-learn').on('submit', function(event) {
        event.preventDefault();

        var form = this;
        var data = {
            name: form.name.value,
            // email: form.email.value,
            phone: form.phone.value
        };

        $.ajax({
            type: "POST",
            url: '/sender.php',
            data: data,
            statusCode: {
                200: function() {
                    form.reset();
                    location.href = 'thankyoupage.html';
                },
                400: function(jqXHR) {
                    var response = jqXHR.responseJSON;
                    var field = form[response.field];

                    if ($(field).next('label').length) {
                        return;
                    }

                    $(field)
                        .addClass('error')
                        .after('<label class="err-message">' + response.message + '</label>');
                },
                500: function () {
                    alert("Ошибка сервера. Попробуйте позже или свяжитесь с нами по указанным телефонам.")
                }
            },
            dataType: 'json'
        });
    });

    $('input[type="text"]').on('focus', function () {
        $(this)
            .removeClass('error')
            .next('label')
            .remove();
    });
});


// Google Map

function initMap() {
    var targetCoords = {lat: 50.450507, lng: 30.4546557};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: targetCoords
    });

    new google.maps.Marker({
      position: targetCoords,
      map: map
    });
}

// Google Analitics

window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-117121001-1');