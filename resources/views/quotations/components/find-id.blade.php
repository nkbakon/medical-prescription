<div class="overflow-x-auto">
    <form wire:submit.prevent="find" method="POST">
        @csrf
        <div  class="flex w-full p-3 space-x-2">
            <div>
                <input type="text" name="prescription_id" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Enter Prescription ID" wire:model="prescription_id" required>
                @error('prescription_id') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
            </div>
            <div>
                <button wire:target="find" wire:loading.attr="disabled" type="submit" title="find distribution" class="items-center px-3 py-3 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">Find</button>
            </div>
        </div>
    </form>
    @if ($prescription !== null)
        <br>
        <h1 class="text-center text-base text-gray-600 dark:text-gray-400">Prescription ID: <b>{{ $prescription->id }}</b></h1>
        <h1 class="text-center text-gray-500 font-bold opacity-75">Add Quotation</h1><br>
        <div class="flex justify-between">
            <div>
                <p class="text-left text-xl text-gray-700 font-bold">Images</p><br>
                @php
                    $images = json_decode($prescription->images);
                @endphp
                @foreach($images as $image)
                    <img class="h-64 w-64" src="{{ asset('storage') }}/{{ $image }}" /><br>
                @endforeach
            </div>
            <div>
                <livewire:quotations.forms.create-form :prescription=$prescription />
            </div>
        </div>
    @else
    <h1 class="text-center text-lg text-red-500">Enter Valid Prescription ID</h1>
    @endif       
<br>

</div>