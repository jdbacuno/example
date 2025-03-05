<x-layout>
  <x-slot:heading>
    Edit Job: {{ $job->title }}
  </x-slot:heading>

  <form method="POST" action="/jobs/{{ $job->id }}">
    @csrf
    @method('PATCH')

    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
          <div class="sm:col-span-7">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Title</label>
            <div class="mt-2">
              <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                <input 
                  type="text" 
                  name="title" 
                  id="title" 
                  class="block min-w-0 grow py-1.5 pr-1 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" 
                  placeholder="Software Engineer" 
                  value="{{ $job->title }}" 
                  required>
              </div> 

              @error('title')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="sm:col-span-7">
            <label for="salary" class="block text-sm/6 font-medium text-gray-900">Salary</label>
            <div class="mt-2">
              <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                <input 
                  type="text" 
                  name="salary" 
                  id="salary" 
                  class="block min-w-0 grow py-1.5 pr-1 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" 
                  placeholder="$50,000 Per Year" 
                  value="{{ $job->salary }}"
                  required>
              </div>
            </div>

            @error('salary')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
          </div>

        </div>
      </div>

    </div>
  
    <div class="mt-6 flex items-center justify-between gap-x-6">
      <div class="flex items-center">
        <button form="delete-form" class="rounded-md px-3 bg-red-500 text-white py-2 text-sm font-semibold text-gray-500 hover:shadow-xs hover:bg-transparent cursor-pointer hover:border hover:border-red-500 hover:text-red-500">Delete</button>
      </div>

      <div>
        <a href="/jobs/{{ $job->id }}" type="button" class="rounded-md px-3 py-2 text-sm font-semibold text-gray-500 hover:shadow-xs hover:bg-none hover:border hover:border-red-500 hover:text-red-500">Cancel</a>
        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
      </div>
    </div>
  </form>

  <form method="POST" action="/jobs/{{ $job->id }}" class="hidden" id="delete-form">
    @csrf
    @method('DELETE')
  </form>
  
</x-layout>