<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Consecutivo </th>
                <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                        Numero de orden
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                        Codigo del Producto
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                        Descripción
                    </div>
                </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Origen
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Cantidad
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Peso
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                           Tipo 
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Contenido
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Estado 
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Color 
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Codigo de barras
                        </div>
                    </th>
            </tr>
        </thead>



        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <span>{{ $etiqueta->id_tag }}</span>
                </th>
                <td class="px-6 py-4">
                    <span>{{ $etiqueta->order_num }}</span>
                </td>
                <td class="px-6 py-4">
                    <span>{{ $etiqueta->sku }}</span>
                </td>
                <td class="px-6 py-4">
                    <span>{{ $etiqueta->description }}</span>
                </td>
                </td>
                <td class="px-6 py-4 text-right">
                    <span>{{ $etiqueta->delivery_date }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <span>{{ $etiqueta->type }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <span>{{ $etiqueta->content }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <span>{{ $etiqueta->product_status }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <span>{{ $etiqueta->color }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    {!! DNS1D::getBarcodeHTML($etiqueta->barcode, 'C128') !!}
                    {{ $etiqueta->barcode }}
                </td>
            </tr>

        </tbody>
    </table>
</div>
