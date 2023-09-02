<div>
    <div class="overflow-x-auto">
        <div class="flex w-full p-3 space-x-2">
            <!-- Seach Box -->
            <div class="w-3/6">
                <input type="text" wire:model.live.debounce.300ms="search" class="w-full px-3 py-3 pl-10 text-sm
                text-gray-700 placeholder-gray-400 bg-gray-100 border-none rounded shadow-inner outline-none
                focus:outline-none focus:shadow-outline focus-ring-0 foucus:bg-indigo-50" placeholder="Search Quotations...">
            </div>
            <!-- Order By -->
            <div class="w-1/6">
                <select wire:model="orderBy" id="orderBy" class="w-full px-3 py-3 pl-10 text-sm
                text-gray-700 placeholder-gray-400 bg-gray-100 border-none rounded outline-none
                focus:outline-none focus:shadow-outline focus-ring-0 foucus:bg-indigo-50">
                    <option value="id">ID</option>
                    <option value="name">Name</option>
                    <option value="created_at">Created At</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                </div>
            </div>
            <!-- Order Asc -->
            <div class="w-1/6">
                <select wire:model="orderAsc" id="orderAsc" class="w-full px-3 py-3 pl-10 text-sm
                text-gray-700 placeholder-gray-400 bg-gray-100 border-none rounded outline-none
                focus:outline-none focus:shadow-outline focus-ring-0 foucus:bg-indigo-50">
                    <option value="1">Ascending</option>
                    <option value="0">Descending</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">                            
                </div>
            </div>
            <!-- Per Page -->
            <div class="w-1/6">
                <select wire:model="perPage" id="perPage" class="w-full px-3 py-3 pl-10 text-sm
                text-gray-700 placeholder-gray-400 bg-gray-100 border-none rounded outline-none
                focus:outline-none focus:shadow-outline focus-ring-0 foucus:bg-indigo-50">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="35">35</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">                            
                </div>
            </div>
        </div> 
        <table class="w-full text-base text-left text-gray-700 dark:text-gray-400">
            <thead class="text-sm text-gray-800 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="">
                    <th class="py-3 px-4">
                        ID
                    </th>
                    <th class="py-3 px-4">
                        Drugs
                    </th>
                    <th class="py-3 px-4">
                        User
                    </th>
                    <th class="py-3 px-4">
                        Total
                    </th>
                    <th class="py-3 px-4">
                        Status
                    </th>
                    <th class="py-3 px-4">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotations as $quotation)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">                                    
                    <td class="py-3 px-4">
                        {{ $quotation->id }}
                    </td>
                    <td class="py-3 px-4">
                        @php
                            $drug_ids = json_decode($quotation->drug_ids);
                            $quantities = json_decode($quotation->quantities);
                        @endphp
                        @for ($i = 0; $i < count($drug_ids); $i++)
                            {{ App\Models\Drug::find($drug_ids[$i])->name }} : {{ $quantities[$i] }}<br>
                        @endfor
                    </td>
                    <td class="py-3 px-4">
                        {{ $quotation->prescription->addby->username }}
                    </td>
                    <td class="py-3 px-4">
                        {{ $quotation->total }}
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium leading-4 bg-{{ $quotation->status_color }}-100 text-{{ $quotation->status_color }}-900 capitalize">
                            {{ $quotation->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <a href="{{ route('quotations.edit', $quotation) }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150" >Edit</a>
                        <a href="{{ route('quotations.view', $quotation) }}" title="view" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-2 bg-gray-50">
            <div class="flex justify-end">
                {{ $quotations->links() }}            
            </div>
        </div>
    </div>
</div>
