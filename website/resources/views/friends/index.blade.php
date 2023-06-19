<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vrienden') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 friends_container">
                    @if ($friends->count() > 0)
                        <ul class="friends_list">
                            @foreach ($friends as $friend)
                                <li class="friend_item">{{ $friend->name }}
                                    <form action="{{ route('friends.remove', $friend) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Verwijderen</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Nog geen vrienden toegevoegd.</p>
                    @endif

                    <div class="add_friends">
                        <h2>Vriend Toevoegen</h2>
                        <form action="{{ route('friends.store') }}" method="POST" id="addFriendForm">
                            @csrf
                            <label class="email" for="email">Email:</label>
                            <input class="email" type="email" id="email" name="email" required>
                            <button type="submit">Toevoegen</button>
                        </form>

                        @if(session('success'))
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="error-message">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
