$(document).ready(function (){

    let form = $('#schedule_form');
    $(form).on('click',function (){
        $('.error-class').text('');
        $('input, select').removeClass('border-red-500');
    })

    form.on('submit',function (e){
        e.preventDefault();

        let data = form.serializeArray();

        let result = [];
        data.forEach(function ($item){
            result[$item.name] = $item.value
        })

        $.ajax({
            url: 'ajax/action.php',
            dataType: 'json',
            type: 'POST',
            data: {
                region_id: result.region_id,
                courier_id: result.courier_id,
                date: result.date,
                action: 'schedule/store'
            },
            success: function(data) {
                if(data.status){
                    $('.info_success').text(data.message);
                } else {
                    if(data.message){
                        $('.error_message').text(data.message);
                    }
                    if(data.error_store&&data.error_store.length > 0){
                        let error_store = data.error_store[0];
                        let error_text = '';
                        let date =  new Date(error_store.date_end * 1000);
                        let date_end = date.getFullYear() + '-'+ (date.getMonth() + 1) + '-' + date.getDate();
                        error_text += 'Курьер ' + error_store.name + ' в пути с '+error_store.date + ' до ' + date_end + ' в регионе "' + error_store.title+'"';
                        $('.error_store').text(error_text);
                    }
                    if(data.errors){
                        Object.keys(data.errors).forEach(function(key) {
                            $('.error_'+key).text(data.errors[key]);
                            $('[name=' + key + ']').addClass('border-red-500')
                        });
                    }
                }
            },
            error: function(err) { console.error(err); }
        });
    })

    let form1 = $('#schedule_form_filter');
    form1.on('submit',function (e){
        e.preventDefault();
        let data = form1.serializeArray();
        let result = [];
        data.forEach(function ($item){
            result[$item.name] = $item.value
        })

        $.ajax({
            url: 'ajax/action.php',
            dataType: 'html',
            type: 'POST',
            data: {
                start: result.start,
                end:  result.end,
                action: 'schedule/filter'
            },
            success: function(data) {
                $('.table-results').html(data);
            },
            error: function(err) { console.error(err); }
        });
    })
})