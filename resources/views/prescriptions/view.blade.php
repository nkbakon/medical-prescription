@extends('layouts.app')
@section('bodycontent')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a href="{{ route('prescriptions.index') }}" title="back" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150" ><i class="fa-solid fa-arrow-left-long"></i></a><br><br>
                <br>
                <h1 class="text-center text-xl text-gray-700">Prescription Details</h1>
                <p class="text-left text-xl text-gray-700 font-bold">ID: #{{ $prescription->id }}</p><br>                
                <div class="py-5 bg-gray-100 px-5 rounded-lg">
                    <p class="text-gray-700">Delivery Address: {{ $prescription->delivery_address }}</p>
                    <p class="text-gray-700">Delivery Time: {{ $prescription->delivery_time }}</p>                            
                    <p class="text-gray-700">Note: {{ $prescription->note }}</p>
                </div><br>
                <p class="text-left text-xl text-gray-700 font-bold">Images</p><br>
                @php
                    $images = json_decode($prescription->images);
                @endphp
                @foreach($images as $image)
                    <img src="{{ asset('storage') }}/{{ $image }}" /><br>
                @endforeach                                                                      
            </div>
        </div>
    </div>
</div>
@endsection