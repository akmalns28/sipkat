@if (!Request::is('home*', 'setting*'))
    <div class="d-flex justify-content-between align-items-end flex-wrap">
        <h3>{{ $header }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @stack('breadcumb')
            </ol>
        </nav>
    </div>
@endif
