@extends('layouts.app')

@section('content')
<div class="mx-3 sm:mx-auto sm:max-w-sm mb-4 sm:mb-10 sm:mt-10">

    <div class="card rounded bg-white shadow-lg">
        
        <div class="card-header p-6 lg:p-8 border-b lg:border-grey-lighter flex items-center justify-center">
                            
            <span class="font-bold text-lg leading-normal text-blue-dark uppercase">Confirma your email address</span>
            
        </div> <!-- end .card-header -->

        <div class="card-body p-6 lg:p-8">

            @if (session('resent'))
                <div class="bg-green-lightest border-l-4 border-green p-6 text-green-darker rounded leading-normal" role="alert">
                    A verification link was sent to your email address.
                </div>
            @else
                <div class="text-grey-darkest leading-normal">
                    <p class="mb-6">You need to verify your email address before continuing.</p>
                    <p>Go to your email box and click the <em>"Check my email"</em> button.</p>
                </div>
            @endif
            
        </div> {{-- end .card-body --}}

        @unless (session('resent'))
            <div class="card-footer bg-grey-lightest p-8 border-t border-grey-lighter flex items-center justify-center "> 
                
                <a href="{{ route('verification.resend') }}" class="font-bold text-blue-dark no-underline hover:text-blue-darker">Resend verification link</a>
                
            </div>
        @endunless
    </div>
</div>
@endsection