<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Order' }}</title>
    {{-- HEAD --}}
@vite(['resources/css/app.css', 'resources/js/app.js']) 

    @livewireStyles

    {{-- Alpine: CDN sekali saja + guard agar sinkron dengan Livewire & tidak re-init --}}
    <script>
      window.deferLoadingAlpine = (alpineInit) => {
        document.addEventListener('livewire:load', alpineInit);
      }
    </script>
      </head>

  <body class="bg-slate-200 dark:bg-slate-700">
    @livewire('partials.navbar')

    <main>
      {{ $slot }}
    </main>

    @livewire('partials.footer')

    {{-- Livewire scripts: PASANG SEKALI SAJA DI LAYOUT --}}
    @livewireScripts

    {{-- SweetAlert: pasang sekali & tahan saat navigate --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" data-navigate-once></script>
    <x-livewire-alert::scripts />

    {{-- Tempat script tambahan dari view (mis. listener open-wa) --}}
    @stack('scripts')
  </body>
</html>
