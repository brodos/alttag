@extends('layouts.app')

@section('content')
<div class="content py-10">

    <div class="flex items-center justify-between">
        <h2 class="text-grey-darkest font-normal text-2xl">My Sites</h2>

        <div>
            <a href="{{ route('user-sites.create') }}" class="btn btn-orange">Add new site</a>
        </div>
    </div>

    <div class="mt-10 bg-white rounded-lg shadow-lg">

        <div class="p-10">

            @if ($sites->isEmpty())
                <p class="text-lg text-center py-16">Feels lonely in here. Go ahead and <strong>add a new site</strong> I can crawl.</p>
            @else
                <table class="table table-auto w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th>Name</th>
                            <th>URL</th>
                            <th>Crawling</th>
                            <th>Processing</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sites as $site)
                            <tr class="clickable" data-href="{{ route('user-sites.show', $site) }}" @click.prevent="goToHref">
                                <td>
                                    <div class="flex flex-col">
                                        <span>{{ $site->display_name }}</span>
                                        <span class="text-sm text-grey">{{ $site->domain }}</span>
                                    </div>
                                </td>
                                <td class="text-sm">{{ $site->url }}</td>
                                <td class="text-sm">
                                    <div class="flex flex-col">
                                        @if ($site->crawl == 1)
                                            <span><span class="text-grey-dark">Type:</span> single URL</span>
                                        @elseif($site->crawl == 2)
                                            <span><span class="text-grey-dark">Type:</span> full crawl</span>
                                        @else
                                            <span><span class="text-grey-dark">Type:</span> not selected</span>
                                        @endif
                                        <span><span class="text-grey-dark">Found:</span> {{ $site->urls->count() }} {{ str_plural('url', $site->urls->count()) }}</span>
                                    </div>
                                </td>
                                <td class="text-sm">
                                    <div class="flex flex-col">
                                        @if ($site->process == 1)
                                            <span><span class="text-grey-dark">Type:</span> all images</span>
                                        @elseif($site->process == 2)
                                            <span><span class="text-grey-dark">Type:</span> selected images</span>
                                        @else
                                            <span><span class="text-grey-dark">Type:</span> not selected</span>
                                        @endif
                                        <span><span class="text-grey-dark">Found:</span> {{ $site->images->count() }} {{ str_plural('image', $site->images->count()) }}</span>
                                        <span><span class="text-grey-dark">Processed:</span> 0 {{ str_plural('image', 0) }}</span>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('user-sites.show', $site) }}" class="text-sm text-grey-dark hover:text-blue-dark no-underline">
                                        <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        
        </div>

    </div>
</div>
@endsection
