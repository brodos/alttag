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

                    <span class="text-lg uppercase tracking-wide font-semibold text-blue-darker">Images</span>

                </div>

                <div class="card-body">
                    
                    @forelse($site->images as $image)

                        <div class="media-card  px-10 py-6  clickable flex items-center justify-between w-full @if(! $loop->last)  @endif border-b border-grey-light cursor-pointer hover:bg-grey-lightest" @click="goToHref" data-href="{{ route('user-images.show', [$site, $image]) }}">

                            <div class="mr-10">
                                <img class="rounded-lg shadow-inner shadow border w-16 h-16" src="{{ $image->url }}">
                            </div>

                            <div class="flex-1">

                                <div class="flex items-start justify-between">

                                    <h3 class="leading-normal">
                                        <a class="inline-block font-semibold text-blue-darker no-underline hover:underline hover:text-blue-dark" href="{{ route('user-images.show', [$site, $image]) }}">
                                            @if(empty($image->alt))
                                                <span class="text-red-dark">[no alt tag]</span>
                                            @else
                                                $image->alt
                                            @endif
                                        </a>           
                                    </h3>
                                    
                                    @if ($image->status_code)
                                        <span 
                                            class=
                                                "ml-4 text-xs font-semibold text-grey-lightest border rounded-lg py-px px-4 bg-grey-dark leading-normal
                                                @if (starts_with($image->status_code, '4') || starts_with($image->status_code, '5'))
                                                    bg-red-lightest border-red-dark text-red-dark
                                                @elseif (starts_with($image->status_code, '3'))
                                                    bg-orange-lightest border-orange text-orange
                                                @elseif (starts_with($image->status_code, '2'))
                                                    bg-green-lightest border-green-dark text-green-dark
                                                @endif
                                                "
                                        >
                                            {{ $image->status_code }}
                                        </span>
                                    @endif

                                </div>

                                @if (! $image->alt)
                                    <div class="mt-1">
                                        <a href="{{ $image->url }}" rel="noreferrer" class=" opacity-75 text-blue-darker no-underline hover:underline hover:text-blue-dark">{{ $image->url }}</a>
                                    </div>
                                @endif

                                <div class="pt-6 flex flex-col items-start md:flex-row md:items-center">
                                    @if ($image->found_on) 
                                        <span class="text-grey mr-8 text-sm">Found on <a href="{{ $image->found_on->url }}" class="opacity-75 text-blue-darker no-underline hover:underline hover:text-blue-dark" rel="noreferrer">{{ $image->found_on->url }}</a></span>
                                    @endif

                                    @if (! empty($image->meta_data))
                                        <div class="mt-6 md:mt-0">
                                            @if (isset($image->meta_data['mime']) && ! empty($image->meta_data['mime']))
                                                <span class="mr-4 inline-block rounded-lg bg-grey-lighter border border-grey py-1 px-3 text-grey-dark font-semibold text-xs leading-none uppercase">
                                                    {{ $image->meta_data['mime'] }}
                                                </span>
                                            @endif 
                                            @if (isset($image->meta_data['filesize']) && ! empty($image->meta_data['filesize']))
                                                <span class="mr-4 inline-block rounded-lg bg-grey-lighter border border-grey py-1 px-3 text-grey-dark font-semibold text-xs leading-none">
                                                    {{ size_to_human($image->meta_data['filesize']) }}
                                                </span>
                                            @endif 
                                            @if (isset($image->meta_data['width']) && isset($image->meta_data['height']))
                                                <span class="inline-block rounded-lg bg-grey-lighter border border-grey py-1 px-3 text-grey-dark font-semibold text-xs leading-none">
                                                    {{ $image->meta_data['width'] }} x {{ $image->meta_data['height'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif 

                                    <div class="ml-auto">
                                        @if (! $image->processed_at)
                                            <a href="#" target="_blank" @click.stop>Get meta</a>
                                        @endif
                                        @if (empty($image->api_data))
                                            <a href="#" target="_blank" @click.prevent>Get AI meta</a>
                                        @endif
                                    </div>

                                </div>
                                
                            </div>
                            
                        </div>

                    @empty
                        <div class="p-10">
                            <p>No Images found yet.</p>
                            <p>Start crawling now!</p>
                        </div>
                    @endforelse

                </div>

            </div>

        </main>

    </div>

    
</div>
@endsection