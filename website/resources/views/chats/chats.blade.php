<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 chats_container">
                    @if ($messages->count() > 0)
                        <div class="chat_messages">
                            @foreach ($messages as $message)
                                <div class="message">
                                    <p class="font-bold">{{ $message->sender->name }}</p>
                                    <p>{{ $message->message }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Nog geen chats ontvanger.</p>
                    @endif
                    
                    <form class="clear_messages" action="{{ route('chats.clear') }}" method="POST">
                        @csrf
                        <button type="submit">Clear Chats</button>
                    </form>


                    <div class="send_chats">
                        <h2 class="text-xl font-bold mt-4">Verstuur Chat</h2>
                        <form action="{{ route('chats.send') }}" method="POST" class="mt-2">
                            @csrf
                            <div>
                                <label for="receiver_email" class="block font-bold mb-1">Ontvanger Email:</label>
                                <input class="email" type="email" id="receiver_email" name="receiver_email" required class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                            </div>
                            <div class="mt-2">
                                <label for="message" class="block font-bold mb-1">Bericht:</label>
                                <textarea class="email" id="message" name="message" required class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full h-24 resize-none"></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Verstuur</button>
                            </div>
                        </form>
                    
                        @if(session('success'))
                            <div class="mt-4 text-green-500">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mt-4 text-red-500">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
