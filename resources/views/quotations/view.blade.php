@extends('layouts.app')
@section('bodycontent')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a href="{{ route('quotations.index') }}" title="back" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150" ><i class="fa-solid fa-arrow-left-long"></i></a><br><br>
                <br>
                <h1 class="text-center text-xl text-gray-700">Quotation Details</h1>
                <p class="text-left text-xl text-gray-700 font-bold">ID: #{{ $quotation->id }}</p><br>                
                <div class="py-5 bg-gray-100 px-5 rounded-lg">
                    <p class="text-gray-700">
                        Drugs: @php
                                $drug_ids = json_decode($quotation->drug_ids);
                                $quantities = json_decode($quotation->quantities);
                            @endphp
                            @for ($i = 0; $i < count($drug_ids); $i++)
                                {{ App\Models\Drug::find($drug_ids[$i])->name }} : {{ $quantities[$i] }}<br>
                            @endfor
                    </p>
                    <p class="text-gray-700">User: {{ $quotation->prescription->addby->username }}</p>                            
                    <p class="text-gray-700">Total: {{ $quotation->total }}</p>
                    <p class="text-gray-700">Status: {{ $quotation->status }}</p>
                </div><br>
                <p class="text-left text-xl text-gray-700 font-bold">Images</p><br>
                @php
                    $images = json_decode($quotation->prescription->images);
                @endphp
                @foreach($images as $image)
                    <img src="{{ asset('storage') }}/{{ $image }}" /><br>
                @endforeach                                                                      
            </div>
        </div>
    </div>
</div>
@endsection