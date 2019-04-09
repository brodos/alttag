<aside class="w-64 mr-16 flex-no-shrink">
    <h2 class="text-grey-darkest font-semibold text-2xl flex flex-col leading-normal">
        <span>{{ $site->display_name }}</span>
        <span class="text-base font-normal text-grey-dark">{{ $site->domain }}</span>
    </h2>

    <ul class="side-menu mt-10 list-reset">
        <li>
            <a href="{{ route('user-sites.show', $site) }}" class="side-menu-item{{ request()->url() == route('user-sites.show', $site)  ? ' is-active' : '' }}">
                <span><svg class="side-menu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 22a2 2 0 0 1-2-2v-1a1 1 0 0 0-1-1 1 1 0 0 0-1 1v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-3H5a3 3 0 1 1 0-6h1V8c0-1.11.9-2 2-2h3V5a3 3 0 1 1 6 0v1h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1a1 1 0 0 0-1 1 1 1 0 0 0 1 1h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3zm3-2v-3h-1a3 3 0 1 1 0-6h1V8h-3a2 2 0 0 1-2-2V5a1 1 0 0 0-1-1 1 1 0 0 0-1 1v1a2 2 0 0 1-2 2H8v3a2 2 0 0 1-2 2H5a1 1 0 0 0-1 1 1 1 0 0 0 1 1h1a2 2 0 0 1 2 2v3h3v-1a3 3 0 1 1 6 0v1h3z"/></svg></span>
                <span>Site Stats</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user-images.index', $site) }}" class="side-menu-item{{ request()->is('sites/*/images*')  ? ' is-active' : '' }}">
                <span><svg class="side-menu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 8.59V6H4v6.59l4.3-4.3a1 1 0 0 1 1.4 0l5.3 5.3 2.3-2.3a1 1 0 0 1 1.4 0l1.3 1.3zm0 2.82l-2-2-2.3 2.3a1 1 0 0 1-1.4 0L9 10.4l-5 5V18h16v-2.59zM15 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg></span>
                <span class="flex-1">Found Images</span>
                <span class="mr-3 text-xs font-semibold p-1 rounded-full bg-grey-dark text-white">{{ $site->images->count() }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user-urls.index', $site) }}" class="side-menu-item{{ request()->is('sites/*/urls*')  ? ' is-active' : '' }}">
                <span><svg class="side-menu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="m19.48 13.03a4 4 0 0 1 -3.48 5.97h-4a4 4 0 1 1 0-8h1a1 1 0 0 0 0-2h-1a6 6 0 1 0 0 12h4a6 6 0 0 0 5.21-8.98l-.01-.02a1 1 0 1 0 -1.72 1.03zm-14.96-2.06a4 4 0 0 1 3.48-5.97h4a4 4 0 1 1 0 8h-1a1 1 0 0 0 0 2h1a6 6 0 1 0 0-12h-4a6 6 0 0 0 -5.21 8.98l.01.02a1 1 0 1 0 1.72-1.03z"/></svg></span>
                <span class="flex-1">Found URLs</span>
                <span class="mr-3 text-xs font-semibold p-1 rounded-full bg-grey-dark text-white">{{ $site->urls->count() }}</span>
            </a>
        </li>
        <li class="pb-4 mb-4 border-b"></li>
        <li>
            <a href="{{ route('user-sites.edit', $site) }}" class="side-menu-item{{ request()->is('sites/*/edit*')  ? ' is-active' : '' }}">
                <span><svg class="side-menu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg></span>
                <span>Edit Site</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user-sites.delete', $site) }}" @click.prevent="deleteUrl" data-sites="{{ route('user-sites.index') }}" class="side-menu-item hover:text-red-dark hover:bg-red-lightest hover:border hover:border-red-light">
                <span><svg class="side-menu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg></span>
                <span>Delete Site</span>
            </a>
        </li>
    </ul>

    <div class="mt-10">
        <a href="{{ route('user-sites.index') }}" class="no-underline font-semibold text-sm text-grey-darkest flex items-center justify hover:text-blue-dark">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 mr-2"><path d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"></path></svg> 
            <span>Back to sites</span>
        </a>
    </div>
</aside>