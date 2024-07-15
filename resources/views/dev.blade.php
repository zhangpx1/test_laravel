<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{--<form method="POST" action="{{ route('dev') }}">--}}
    <form method="POST" action="">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('输入SQL')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

    </form>
</x-guest-layout>
