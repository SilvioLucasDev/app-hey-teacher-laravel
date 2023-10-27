<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit Question') }} :: {{ $question->id }}
        </x-header>
    </x-slot>

    <x-container>
        <x-card>
            <x-form put :action="route('question.update', $question)">
                <x-textarea label="Question" name="question" :value="$question->question" />

                <x-btn.primary>Save</x-btn.primary>
                <x-btn.reset>Cancel</x-btn.reset>
            </x-form>
        </x-card>

        <hr class="border-gray-700 border-dashed mb-12">
    </x-container>
</x-app-layout>
