<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>
    </x-slot>

    <x-container>
        <div class="dark:text-gray-400 uppercase font-bold mb-1">My Questions</div>
        <div class="dark:text-gray-400 space-y-4">
            <x-card>
                <x-form get :action="route('dashboard')" class="flex space-x-2">
                    <x-text-input type="text" name="search" value="{{ request()->search }}" class="w-full"
                        style="margin-left: 0px" />
                    <x-btn.primary>Search</x-btn.primary>
                </x-form>
            </x-card>

            @forelse ($questions as $item)
                <x-question :question="$item" />
            @empty
                <div class="flex flex-col">
                    <div class="flex justify-center mb-4">
                        <x-draw.searching width="250" />
                    </div>

                    <div class="flex justify-center font-bold uppercase">
                        <p>Question Not Found</p>
                    </div>
                </div>
            @endforelse

            {{ $questions->withQueryString()->links() }}
        </div>
    </x-container>
</x-app-layout>
