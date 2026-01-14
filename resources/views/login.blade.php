@extends('layout.layout')

@section('title')
    Login
@endsection

@section('content')
   <x-login />
@endsection

@push('script')
<!-- #region -->
        <script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.querySelector('#toggler');

        toggleButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    });
    </script>
    <!-- #endregion -->
@endpush