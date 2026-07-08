<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Prévisualisation de l'inscription</h2>
        <p class="text-gray-600 mt-2">Veuillez vérifier vos informations avant de confirmer l'inscription.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations du compte</h3>
        
        <div class="space-y-4">
            <div>
                <span class="text-sm font-medium text-gray-500">Nom:</span>
                <p class="text-gray-900 font-medium">{{ $name }}</p>
            </div>
            
            <div>
                <span class="text-sm font-medium text-gray-500">Email:</span>
                <p class="text-gray-900 font-medium">{{ $email }}</p>
            </div>
            
            <div>
                <span class="text-sm font-medium text-gray-500">Mot de passe:</span>
                <p class="text-gray-900 font-medium">••••••••</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="password" value="{{ $password }}">
        <input type="hidden" name="password_confirmation" value="{{ $password_confirmation }}">

        <div class="flex items-center justify-between">
            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 underline text-sm">
                Modifier les informations
            </a>

            <x-primary-button>
                {{ __('Confirmer l\'inscription') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
