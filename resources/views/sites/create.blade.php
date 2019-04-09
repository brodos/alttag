@extends('layouts.app')

@section('content')
<div class="content py-10">

    <div class="flex items-center justify-between">
        <h2 class="text-grey-darkest font-normal text-2xl">My Sites</h2>
    </div>

    <div class="card w-full md:w-3/4 lg:w-3/4 mx-auto mt-10 bg-white rounded-lg shadow-lg">
        
        <div class="card-header p-6 md:p-10 border-b border-grey-lighter">
            <span class="text-grey-darkest text-xl font-semibold">Add a new site</span>
        </div>

        <form action="{{ route('user-sites.store') }}" method="post">
            @csrf

            <div class="card-body p-6 md:p-10">

                @if($errors->isNotEmpty())
                
                    <div class="text-red-dark text-sm p-8 mb-10 bg-red-lightest font-semibold border-red rounded-lg">The form has some errors.</div>

                @endif
                
                <div class="flex flex-col md:flex-row md:items-start pb-6 md:pb-8 border-b border-grey-lighter">
                    <div class="w-full md:w-1/4 flex flex-col items-start justify-center">
                        <span class="font-semibold text-grey-darkest">Display name <span class="text-red opacity-50">*</span></span> 
                        <span class="text-sm text-grey-darkest opacity-50 mt-2">A friendly name which you can easily reference in your dashboard.</span>
                    </div> 
                    <div class="w-full md:w-3/4 md:pl-8 mt-4 md:mt-0">
                        <input type="text" name="display_name" value="{{ old('display_name') }}" class="font-semibold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-normal text-blue-darker border border-transparent focus:shadow-inner focus:border-grey-light" autofocus required>

                        @if ($errors->has('display_name'))
                            <div class="error text-red-dark text-sm mt-1">{{ $errors->first('display_name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-start py-6 md:py-8 border-b border-grey-lighter">
                    <div class="w-full md:w-1/4 flex flex-col items-start justify-center">
                        <span class="font-semibold text-grey-darkest">URL <span class="text-red opacity-50">*</span></span> 
                        <span class="text-sm text-grey-darkest opacity-50 mt-2">Starting point for our crawler.</span>
                    </div> 
                    <div class="w-full md:w-3/4 md:pl-8 mt-4 md:mt-0">
                        <input type="url" name="url" value="{{ old('url', 'https://') }}" class="font-semibold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-normal text-blue-darker border border-transparent focus:shadow-inner focus:border-grey-light" required>

                        @if ($errors->has('url'))
                            <div class="error text-red-dark text-sm mt-1">{{ $errors->first('url') }}</div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-start py-6 md:py-8 border-b border-grey-lighter">
                    <div class="w-full md:w-1/4 flex flex-col items-start justify-center">
                        <span class="font-semibold text-grey-darkest">Crawl behavior <span class="text-red opacity-50">*</span></span> 
                        <span class="text-sm text-grey-darkest opacity-50 mt-2">How should the crawler handle this url?</span>
                    </div> 
                    <div class="w-full md:w-3/4 md:pl-8 mt-4 md:mt-0">
                        <div class="inline-block relative w-full">
                            <select class="block appearance-none w-full bg-grey-lighter p-4 pr-8 rounded focus:shadow-inner leading-normal focus:outline-none  text-blue-darker border border-transparent font-semibold focus:border-grey-light" name="crawl" required>
                                <option>- select an option -</option>
                                <option value="1" @if (old('crawl') == 1) selected @endif>Only this URL</option>
                                <option value="2" @if (old('crawl') == 2) selected @endif>Go down the rabbit hole</option>
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        @if ($errors->has('crawl'))
                            <div class="error text-red-dark text-sm mt-1">{{ $errors->first('crawl') }}</div>
                        @endif

                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-start pt-6 md:pt-8">
                    <div class="w-full md:w-1/4 flex flex-col items-start justify-center">
                        <span class="font-semibold text-grey-darkest">What should we do then? <span class="text-red opacity-50">*</span></span> 
                        <span class="text-sm text-grey-darkest opacity-50 mt-2">Start processing the images or just display what we found and you can then select which images to process?</span>
                    </div> 
                    <div class="w-full md:w-3/4 md:pl-8 mt-4 md:mt-0">
                        <div class="inline-block relative w-full">
                            <select class="block appearance-none w-full bg-grey-lighter p-4 pr-8 rounded focus:shadow-inner leading-normal focus:outline-none  text-blue-darker font-semibold border border-transparent focus:border-grey-light" name="process" required>
                                <option>- select an option -</option>
                                <option value="1" @if (old('process') == 2) selected @endif>I'll pick only the ones I want</option>
                                <option value="2" @if (old('process') == 1) selected @endif>Process ALL images</option>
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        
                        @if ($errors->has('process'))
                            <div class="error text-red-dark text-sm mt-1">{{ $errors->first('process') }}</div>
                        @endif
                    </div>
                </div>            

            </div>

            <div class="card-footer bg-grey-lightest p-6 flex items-center justify-between md:px-10 border-t">
                <div>
                    <a href="{{ route('user-sites.index') }}" class="no-underline font-semibold text-sm text-grey-darkest flex items-center hover:text-blue-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 mr-2"><path d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"></path></svg> 
                        <span>Back to sites</span>
                    </a>
                </div> 

                <button type="submit" class="btn btn-orange px-10">Add Site</button>
            </div>

        </form>

    </div>
</div>
@endsection