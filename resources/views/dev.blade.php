<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('dev.executeSql') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="name" :value="__('输入SQL')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="sql" :value="old('sql')" required autofocus autocomplete="sql" />
        </div>
        <br/>
        <x-primary-button class="ml-3">
            {{ __('Excute') }}
        </x-primary-button>
        <x-primary-button class="ml-3" formaction="{{ route('dev.export') }}" formmethod="GET">
            {{ __('Export') }}
        </x-primary-button>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

    </form>
</x-guest-layout>
