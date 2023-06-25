<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit Question') }} :: {{ $question->id }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form post :action="route('question.update', $question)" put>
            <x-textarea label="Question" name="question" :value="$question->question"/>

            <x-btn.save>Save</x-btn.save>
            <x-btn.reset>Reset</x-btn.reset>
        </x-form>
    </x-container>
</x-app-layout>
