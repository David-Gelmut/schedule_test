<div class="table-results mb-10">
    <?php if (!empty($schedulesIndex) && count($schedulesIndex) > 0): ?>
        <div class="relative overflow-x-auto  mt-4 ">
            <table class="mx-auto w-1/2 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-xl">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Регион
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Дата выезда
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ФИО курьера
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Дата прибытия
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($schedulesIndex as $key=>$item): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo $item['id']; ?>
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo $item['title']; ?>
                        </th>
                        <td class="px-6 py-4">
                            <?php echo $item['date']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $item['name']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo date('Y-m-d', addDays($item['date'],$item['duration'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div  class="relative overflow-x-auto  mt-4 ">
            <div class="mx-auto w-1/2 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-xl">
             Нет данных
            </div>
        </div>
    <?php endif; ?>
</div>
