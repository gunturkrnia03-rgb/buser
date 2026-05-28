<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $quiz->title }}
            </h2>
            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $quiz->questions->count() }} Questions
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
                @csrf
                
                @foreach($quiz->questions as $index => $question)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <span class="text-indigo-600 font-bold mr-2">{{ $index + 1 }}.</span>
                                {{ $question->content }}
                            </h3>

                            <div class="space-y-3">
                                @foreach($question->answers as $answer)
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors border-gray-200">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $answer->id }}" 
                                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                               required>
                                        <span class="ml-3 text-sm text-gray-700">{{ $answer->content }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-end mt-6">
                    <a href="{{ route('quizzes.index') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Submit Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
