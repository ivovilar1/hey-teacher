@props([
    'question'
])

<div class="roudend dark:bg-gray-800/50 shadow-blue-500/50 p-3 dark:text-gray-400 flex justify-between items-center">
    <span>{{ $question->question }}</span>
    <div>
        <x-form :action="route('question.like', $question)">
            <button class="flex items-start space-x-1 text-green-500" type="submit">
                <x-icons.thumbs-up class="w-5 h-5 text-green-300 hover:text-green-300 cursor-pointer" />
                <span>{{ $question->likes }}</span>
            </button>
        </x-form>
        <x-form :action="route('question.like', $question)">
            <button class="flex items-start space-x-1 text-red-500" type="submit">
                <x-icons.thumbs-down class="w-5 h-5 text-red-500 hover:text-red-300 cursor-pointer" />
                <span>{{ $question->unlikes }}</span>
            </button>
        </x-form>
    </div>
</div>
