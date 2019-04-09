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

                <div class="card-header py-8 px-10 bg-grey-lighter">
                    <span class="text-lg uppercase tracking-wide font-semibold text-blue-darker">URLs</span>
                </div>

                <div class="card-body">
                    
                    @forelse($site->urls as $url)

                        <div class="clickable media-card px-10 py-6 flex items-center justify-between w-full @if(! $loop->last)  @endif border-b border-grey-light hover:bg-grey-lightest cursor-pointer" data-href="{{ route('user-urls.show', [$site, $url]) }}" @click="goToHref">

                            <div class="mr-10">
                                <svg class="fill-current text-grey-light w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="m19.48 13.03a4 4 0 0 1 -3.48 5.97h-4a4 4 0 1 1 0-8h1a1 1 0 0 0 0-2h-1a6 6 0 1 0 0 12h4a6 6 0 0 0 5.21-8.98l-.01-.02a1 1 0 1 0 -1.72 1.03zm-14.96-2.06a4 4 0 0 1 3.48-5.97h4a4 4 0 1 1 0 8h-1a1 1 0 0 0 0 2h1a6 6 0 1 0 0-12h-4a6 6 0 0 0 -5.21 8.98l.01.02a1 1 0 1 0 1.72-1.03z"/></svg>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    
                                    <h3 class="leading-normal">
                                        <a class="inline-block font-semibold text-blue-darker no-underline hover:underline hover:text-blue-dark" href="{{ $url->url }}" rel="noreferrer">
                                            {{ $url->page_title ?? $url->url }}
                                        </a>                               
                                    </h3>
                                    
                                    @if ($url->status_code)
                                        <span 
                                            class=
                                                "ml-4 text-xs font-semibold text-grey-lightest border rounded-lg py-px px-4 bg-grey-dark leading-normal
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
                                    @endif

                                </div>

                                @if ($url->page_title)
                                    <div class="mt-1">
                                        <a href="{{ $url->url }}" rel="noreferrer" class=" opacity-75 text-blue-darker no-underline hover:underline hover:text-blue-dark">{{ $url->url }}</a>
                                    </div>
                                @endif

                                <div class="pt-6 flex items-center">
                                    @if ($url->parent) 
                                        <span class="text-grey mr-8 text-sm">Found on <a href="{{ $url->parent->url }}" class="opacity-75 text-blue-darker no-underline hover:underline hover:text-blue-dark" rel="noreferrer">{{ $url->parent->url }}</a></span>
                                    @endif

                                    @if (! $url->crawled_at)
                                        <span class="text-xs font-semibold text-grey-dark border border-grey rounded-lg py-1 px-4 bg-grey-lighter">
                                            not crawled
                                        </span>
                                    @else
                                        @if ($url->children)
                                            <span class="text-grey-dark flex items-center mr-8">
                                                <svg class="fill-current w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m19.48 13.03a4 4 0 0 1 -3.48 5.97h-4a4 4 0 1 1 0-8h1a1 1 0 0 0 0-2h-1a6 6 0 1 0 0 12h4a6 6 0 0 0 5.21-8.98l-.01-.02a1 1 0 1 0 -1.72 1.03zm-14.96-2.06a4 4 0 0 1 3.48-5.97h4a4 4 0 1 1 0 8h-1a1 1 0 0 0 0 2h1a6 6 0 1 0 0-12h-4a6 6 0 0 0 -5.21 8.98l.01.02a1 1 0 1 0 1.72-1.03z"/></svg>
                                                <span class="font-semibold text-grey-dark">{{ $url->children->count() }}</span>
                                            </span>
                                        @endif 
                                        @if ($url->images)
                                            <span class="text-grey-dark flex items-center mr-6 leading-none">
                                                <svg class="fill-current w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="heroicon-ui" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 8.59V6H4v6.59l4.3-4.3a1 1 0 0 1 1.4 0l5.3 5.3 2.3-2.3a1 1 0 0 1 1.4 0l1.3 1.3zm0 2.82l-2-2-2.3 2.3a1 1 0 0 1-1.4 0L9 10.4l-5 5V18h16v-2.59zM15 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
                                                <span class="font-semibold  text-grey-dark">{{ $url->images->count() }}</span>
                                            </span>
                                        @endif
                                    @endif 

                                    <div class="ml-auto">
                                        <a href="{{ route('crawl-url', [$site, $url]) }}" target="_blank" @click.stop>Crawl now</a>
                                    </div>

                                </div>

                            </div>
                            
                            
                        </div>

                    @empty
                        <div class="p-10">
                            <p>No URLs found yet.</p>
                            <p>Start crawling now!</p>
                        </div>
                    @endforelse

                </div>

            </div>

        </main>

    </div>

    
</div>
@endsection