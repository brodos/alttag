@extends('layouts.app')

@section('content')
<div class="content py-10">
{{-- 
    <div class="text-right">
        
    </div> --}}

    <div class="flex">
        
        @include('sites.partials.sidebar')

        <main class="flex-1">
            
            <div class="bg-white rounded-lg shadow-lg">

                <div class="card-header py-8 px-10 bg-grey-lighter">
                    <span class="text-lg uppercase tracking-wide font-semibold text-blue-darker">Site Stats</span>
                </div>

                <div class="card-body p-10">
                    
                    <p>Start URL: {{ $site->url }}</p>

                    <p>Status: crawling|finished|scheduled</p>

                    <p>Found URLs</p>

                    <p>Images found</p>

                    <p>Re-run crawl</p>

                </div>

            </div>

        </main>

    </div>

    
</div>
@endsection
