<form method="POST"
      action="{{ isset($task) ? route('task.update', $task) : route('task.store') }}"
      class="space-y-6">

    @isset($task)
        @method('PUT')
    @endisset

    @csrf

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium">Title</label>
        <input type="text" name="title" id="title"
               class="w-full mt-1 p-2 border rounded-md @error('title') border-red-500 @enderror"
               value="{{ $task->title ?? old('title') }}">
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-medium">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="w-full mt-1 p-2 border rounded-md @error('description') border-red-500 @enderror">{{ $task->description ?? old('description') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Long Description --}}
    <div>
        <label for="long_description" class="block text-sm font-medium">Long Description</label>
        <textarea name="long_description" id="long_description" rows="6"
                  class="w-full mt-1 p-2 border rounded-md @error('long_description') border-red-500 @enderror">{{ $task->long_description ?? old('long_description') }}</textarea>
        @error('long_description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Buttons --}}
    <div class="flex gap-3">
        <button type="submit" class="btn">
            {{ isset($task) ? 'Update Task' : 'Create Task' }}
        </button>
        <a href="{{ route('task.index') }}" class="btn bg-gray-200 text-black">Cancel</a>
    </div>
</form>
