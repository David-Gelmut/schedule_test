<?php
$couriers = \models\Courier::getAllCouriers();
$regions = \models\Region::getAllRegions();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="/assets/css/flowbite@3.1.2/flowbite.min.css" rel="stylesheet" />
</head>
<body>
<div class="">
    <div class="mt-4">
        <form  method="post" id="schedule_form" class="max-w-sm mx-auto p-4 shadow-xl">
            <div class="mb-5">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите курьера</label>
                <select name="courier_id" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php if (!empty($couriers) && count($couriers) > 0): ?>
                        <option value="0">Выберите имя курьера из списка</option>
                        <?php foreach ($couriers as $key=>$item): ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>Нет данных</div>
                    <?php endif; ?>
                </select>
                <div class="error-class error_courier_id text-red-500"></div>
            </div>
            <div class="mb-5">
                <label for="default-datepicker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Дата выезда</label>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input name="date" datepicker id="default-datepicker" datepicker-format="yyyy-mm-dd" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Выберите дату">
                </div>
                <div class="error-class error_date text-red-500"></div>
            </div>
            <div class="mb-5">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите регион</label>
                <select name="region_id" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php if (!empty($regions) && count($regions) > 0): ?>
                        <option value="0" selected>Выберите регион из списка</option>
                        <?php foreach ($regions as $key=>$item): ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>Нет данных</div>
                    <?php endif; ?>
                </select>
                <div class="error-class error_region_id text-red-500"></div>
            </div>
            <div class="error-class error_message text-red-500  mb-2"></div>
            <div class="error-class error_store text-red-500  mb-2"></div>
            <div class="error-class info_success text-green-500  mb-2"></div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добавить запись</button>
        </form>

    </div>
    <div class="mt-4">
        <form method="post" id="schedule_form_filter" class="w-1/2 mx-auto p-4 shadow-xl">
            <div class="flex items-center mt-4 mx-auto" >
                <div>
                    <div id="date-range-picker" date-rangepicker datepicker-format="yyyy-mm-dd"  class="flex items-center mt-4 mx-auto w-1/2">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="datepicker-range-start" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="Select date start">
                        </div>
                        <span class="mx-4 text-gray-500">to</span>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="datepicker-range-end" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="Select date end">
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Показать</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/assets/lib/jquery/3.5.1/jquery.min.js"></script>
<script src="/assets/js/flowbite@3.1.2/flowbite.min.js"></script>
<script>
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
                     console.log(data);
                     $('.info_success').text(data.message);
                 } else {
                     console.log(data);
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
                         console.log(data);
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
</script>
</body>
</html>