@vite('resources/js/app.js')
<!-- Core JS -->

<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('success'))
            showSuccessToast("{{ session('success') }}", "{{ asset('assets/icon/success.svg') }}")
        @endif
        @if (session('failed'))
            showErrorToast("{{ session('failed') }}", "{{ asset('assets/icon/danger.svg') }}")
        @endif
    })
</script>

