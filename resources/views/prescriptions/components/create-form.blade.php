<form wire:submit.prevent="store" method="POST">
    @csrf
    <div class="flex overflow-x-auto">
        @if($images)
            @foreach($images as $image)
                @if ($image)
                    <img class="h-28 w-28" src="{{ $image->temporaryUrl() }}">
                @endif
            @endforeach
        @endif
    </div>
    <div>
        <label for="images">Upload Prescription Images</label><br>
        <input type="file" name="images" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="images" multiple required>
    </div>
    @error('images') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
        <label for="delivery_address">Enter Delivery Address</label><br>
        <input type="text" name="delivery_address" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="enter delivery address" wire:model="delivery_address" required>
    </div>
    @error('delivery_address') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
    <label for="delivery_time">Select Delivery Time</label><br>
        <select name="delivery_time" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="delivery_time" required>
            <option value="" disabled selected>Select time from here</option>
            <option value="00:00">00:00</option>
            <option value="02:00">02:00</option>
            <option value="04:00">04:00</option>
            <option value="06:00">06:00</option>
            <option value="08:00">08:00</option>
            <option value="10:00">10:00</option>
            <option value="12:00">12:00</option>
            <option value="14:00">14:00</option>
            <option value="16:00">16:00</option>
            <option value="18:00">18:00</option>
            <option value="20:00">20:00</option>
            <option value="22:00">22:00</option>
            <option value="24:00">24:00</option>
        </select>
    </div>
    @error('delivery_time') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
        <label for="note">Enter Note</label><br>
        <input type="text" name="note" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="enter note" wire:model="note">
    </div>
    @error('note') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <button wire:target="store" wire:loading.attr="disabled" type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">Save</button>                        
</form>