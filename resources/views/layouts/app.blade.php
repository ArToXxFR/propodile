<!DOCTYPE html>
<html lang="fr">
@include('layouts.head')
<body>
    @include('layouts.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.footer')
</body>
</html>