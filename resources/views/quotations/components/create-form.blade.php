<form wire:submit.prevent="store" method="POST">
    @csrf
    @foreach ($rows as $index => $row)
        <div>
            <strong class="inline-flex">{{ $index+1 }}.</strong>
            <button type="button" wire:click="removeRow({{$index}})" class="inline-flex px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-solid fa-xmark"></i></button>
        </div><br>
        <div>
            <label for="drugs">Select Drug</label><br>
            <select name="drugs" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="drugs.{{$index}}" required>
                <option value="" disabled selected>Select a drug from here</option>
                @foreach($all_drugs as $drug)
                <option value="{{$drug->id}}">{{$drug->name}}</option>
                @endforeach
            </select>
        </div>
        @error("drugs.{$index}") <span class="text-red-500 error">{{ $message }}</span><br> @enderror
        <br>
        <div>
            <label for="quantities">Enter Drug Quantity</label><br>
            <input type="text" name="quantities" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="quantities.{{$index}}" placeholder="drug quantity" required>
        </div>        
        <br>
    @endforeach
    @error("quantities") <span class="text-red-500 error">{{ $message }}</span><br><br>@enderror
    <div>
        <button type="button" wire:click="addRow" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">
            Add Another Drug
        </button>
    </div>
    <br>
    <table class="w-full text-base text-left text-gray-700 dark:text-gray-400">
        <thead class="text-sm text-gray-800 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="">
                <th class="py-3 px-4">
                    Drug
                </th>
                <th class="py-3 px-4 text-right">
                    Quantity
                </th>
                <th class="py-3 px-4 text-right">
                    Amount
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $showsum = 0;
            @endphp            
            @foreach($drugs as $index => $drug)
            @if($drug != null)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">                                    
                <td class="py-3 px-4">
                    {{ App\Models\Drug::find($drug)->name }}
                </td>
                <td class="py-3 px-4 text-right">
                    {{ $quantities[$index] }}                                  
                </td>
                <td class="py-3 px-4 text-right">
                    {{ App\Models\Drug::find($drug)->price * $quantities[$index] }}
                    @php 
                        $showsum = $showsum + (App\Models\Drug::find($drug)->price * $quantities[$index]);
                    @endphp                                 
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table><br>
    <h1 class="text-sm text-end text-gray-600">Total = {{ $showsum }}</h1><br>    
    <div>
        <button wire:target="store" wire:loading.attr="disabled" type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">Save</button>
    </div>
</form>