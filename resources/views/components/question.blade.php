@props(['question'])

<div
    class="
        rounded dark:bg-gray-800/50 shadow shadow-blue-500/50 p-3 dark:text-gray-400 \
        flex justify-between items-center
    ">

    <span> {{ $question->question }} </span>
    <div>
        <x-form post :action="route('question.like', $question)">
            <button class="text-green-500 flex items-start space-x-1">
                <x-icons.thumbs-up class="w-5 h-5 hover:text-green-300 cursor-pointer" id="thumbs-up" />
                <span>
                    {{ $question->votes_sum_like ?? 0 }}
                </span>
            </button>
        </x-form>


        <x-form post :action="route('question.unlike', $question)">
            <button class="text-red-500 flex items-start space-x-1">
                <x-icons.thumbs-down class="w-5 h-5  hover:text-red-300 cursor-pointer" id="thumbs-down" />
                <span>
                    {{ $question->votes_sum_unlike ?? 0 }}
                </span>
            </button>
        </x-form>
    </div>
</div>
