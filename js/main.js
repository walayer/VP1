$('#order-form').on('submit', function (evt) {
    evt.preventDefault();

    var serialize = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: 'order.php',
        data: serialize,
        success: function(data){
            // console.log(data);
            if(data == 'Registration'){
                alert('Вы успешно зарегистрировались и сделали заказ!')
            } else if (data == 'Authorization') {
                alert('Вы успешно авторизовались и сделали заказ!')
            } else if (data == 'NO email') {
                alert('Не введен email!')
            }
        }
    });
});