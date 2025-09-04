<x-layout.header />
<main>


@if (auth()->user()->agency->agencyTypes === 'BFP')
    <x-partials.navbar />
    <x-partials.bfp-sidebar />
    <h6>BFP</h6>
@endif

    <div class="p-4 sm:ml-64 mt-16">
        {{ $slot }}
    </div>
</main>
<x-layout.footer />
