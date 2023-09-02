@extends('layouts.app')
@section('bodycontent')
<h1 class="text-center font-bold text-gray-600">Welcome {{ auth()->user()->fname }} {{ auth()->user()->lname }} ({{ auth()->user()->username }})</h1>
@if (auth()->user()->type != 'User')
<div class="py-12">
  <div class="sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
      <div class="flex space-x-40">
        <a href="{{ route('quotations.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-sky-600">{{ App\Models\Quotation::all()->count() }}</div>
              <p class="text-gray-700">
                Quotations
              </p>
            </div>
          </div>
        </a>
        <a href="{{ route('prescriptions.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-sky-600">{{ App\Models\Prescription::all()->count() }}</div>
              <p class="text-gray-700">
                Prescriptions
              </p>
            </div>
          </div>
        </a>
      </div><br>
    </div>
  </div>
</div><br>
@else
<div class="py-12">
  <div class="sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
      <div class="flex space-x-40">
        <a href="{{ route('quotations.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-sky-600">
                    @php
                        $prescription = App\Models\Prescription::where('add_by',  auth()->user()->id)->first(); 
                    @endphp
                    {{ App\Models\Quotation::where('status', 'Pending')->where('prescription_id', $prescription->id)->count() }}
              </div>
              <p class="text-gray-700">
                Pending Quotations
              </p>
            </div>
          </div>
        </a>
        <a href="{{ route('prescriptions.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-sky-600">{{ App\Models\Prescription::where('add_by', auth()->user()->id)->count() }}</div>
              <p class="text-gray-700">
                Prescriptions
              </p>
            </div>
          </div>
        </a>
      </div><br>
    </div>
  </div>
</div><br>
@endif
@endsection
