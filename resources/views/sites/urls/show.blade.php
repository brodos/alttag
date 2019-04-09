@extends('layouts.app')

@section('content')
<div class="content py-10">
{{-- 
    <div class="text-right">
        
    </div> --}}

    <div class="flex">
        
        @include('sites.partials.sidebar')

        <main class="flex-1">
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">

                <div class="card-header py-8 px-10 bg-grey-lighter flex items-center w-full ">
                    
                    <div class="back mr-8 hidden md:block">
                        <a href="{{ route('user-urls.index', $site) }}" class="text-grey-darkest hover:text-blue no-underline">
                            <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 -2 24 24"><path d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/></svg>
                        </a>
                    </div>

                    <div>

                        <span class="block text-xl font-semibold text-blue-darker">{{ $url->page_title ?? $url->url }}</span>
                        <a href="{{ $url->url }}" rel="noreferrer" class="block mt-1 opacity-75 text-blue-darker no-underline hover:underline hover:text-blue-dark">{{ $url->url }}</a>

                    </div>

                    <div class="ml-auto">
                        
                        @if ($url->status_code)
                            <span 
                                class=
                                    "ml-4 uppercase tracking-tight text-sm font-semibold text-grey-lightest border rounded-lg py-1 px-4 bg-grey-dark leading-normal
                                    @if (starts_with($url->status_code, '4') || starts_with($url->status_code, '5'))
                                        bg-red-lightest border-red-dark text-red-dark
                                    @elseif (starts_with($url->status_code, '3'))
                                        bg-orange-lightest bg-orange text-orange
                                    @elseif (starts_with($url->status_code, '2'))
                                        bg-green-lightest border-green-dark text-green-dark
                                    @endif
                                    "
                            >
                                {{ $url->status_code }}
                            </span>
                        @elseif (! $url->crawled_at)
                            <span class="uppercase tracking-tight ml-4 text-sm font-semibold text-grey-lightest border rounded-lg py-1 px-4 bg-grey-dark">
                                not crawled yet
                            </span>
                        @endif

                    </div>

                </div>

                <div class="card-body p-10">
                    
                    @if ($url->parent)
                        <span class="text-grey-dark">This URL was found on:</span> {{ $url->parent->url }}
                    @endif

                    <p>meta data</p>
                    <p>images found</p>
                    <p>links found</p>
                    <p>re-crawl button</p>

                </div>

            </div>

        </main>

    </div>
   
</div>
@endsection