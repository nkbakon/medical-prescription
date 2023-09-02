<form wire:submit.prevent="update" method="POST">
    @method('PUT')
    @csrf
    <div class="flex justify-between">
        <div>
            <p class="text-left text-xl text-gray-700 font-bold">Images</p><br>
            @php
                $images = json_decode($prescription->images);
            @endphp
            @foreach($images as $image)
                <img class="h-64 w-64" src="{{ asset('storage') }}/{{ $image }}" /><br>
            @endforeach<br>
        </div> 
        <div>
            @if (auth()->user()->type != 'User')
                @foreach ($rows as $index => $row)
                    <div>
                        <strong class="inline-flex">{{ $index+1 }}.</strong>        
                    </div>
                    <div>
                        <label for="drug">Select Drug</label><br>
                        <select name="drug" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="drug.{{$index}}" disabled>
                            <option value="" selected>Select a product from here</option>
                            @foreach($all_drugs as $drug)
                            <option value="{{$drug->id}}">{{$drug->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('drug.{{$index}}') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                    <br>
                    <div>
                        <label for="quantity">Enter Quantity Quantity</label><br>
                        <input type="text" name="quantity" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="quantity.{{$index}}" placeholder="drug quantity" required>
                    </div>        
                    <br>
                @endforeach
                @error('quantity') <span class="text-red-500 error">{{ $message }}</span><br><br>@enderror
                <br>
            @else
                <div>
                    <label for="status">Quotation Status</label><br>
                    <select name="status" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="status" required>
                        <option value="" disabled selected>Select an quotation stauts from here</option>
                        <option value="Pending">Pending</option>
                        <option value="Accepted">Accept</option>
                        <option value="Rejected">Reject</option>
                    </select> 
                </div>
                @error('status') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                <br>
            @endif    
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update</button> 
        </div>
    </div>
</form>