<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My Questions') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-card>
            <x-form post :action="route('question.store')">
                <x-textarea label="Question" name="question" />

                <x-btn.primary>Save</x-btn.primary>
                <x-btn.reset>Cancel</x-btn.reset>
            </x-form>
        </x-card>

        <hr class="border-gray-700 border-dashed mb-12">

        <div class="dark:text-gray-400 uppercase font-bold mb-1">Drafts</div>
        <div class="dark:text-gray-400 space-y-4">
            <x-table.table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('draft', true) as $question)
                        <x-table.tr>
                            <x-table.td>{{ $question->question }}</x-table.td>
                            <x-table.td>
                                <x-form delete :action="route('question.destroy', $question)">
                                    <button type="submit" class="hover:underline text-blue-500">
                                        Delete
                                    </button>
                                </x-form>
                                <x-form put :action="route('question.publish', $question)">
                                    <button type="submit" class="hover:underline text-blue-500">
                                        Publish
                                    </button>
                                </x-form>
                                <a href="{{ route('question.edit', $question) }}" class="hover:underline text-blue-500">
                                    Edit
                                </a>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table.table>
        </div>

        <hr class="border-gray-700 border-dashed mb-12">

        <div class="dark:text-gray-400 uppercase font-bold mb-1">My Questions</div>
        <div class="dark:text-gray-400 space-y-4">
            <x-table.table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('draft', false) as $question)
                        <x-table.tr>
                            <x-table.td>{{ $question->question }}</x-table.td>
                            <x-table.td>
                                <x-form delete :action="route('question.destroy', $question)">
                                    <button type="submit" class="hover:underline text-blue-500">
                                        Delete
                                    </button>
                                </x-form>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table.table>
        </div>
    </x-container>
</x-app-layout>
