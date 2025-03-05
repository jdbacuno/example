<x-layout>
  <x-slot:heading>
    Create Job
  </x-slot:heading>

  <form method="POST" action="/jobs">
    @csrf
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base/7 font-semibold text-gray-900">Create a New Job</h2>
        <p class="mt-1 text-sm/6 text-gray-600">We just need a handful of details from you.</p>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
          <x-form-field>
            <x-form-label for="title">Title</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="title" id="title" placeholder="CEO" required />

              {{-- can be self-closing --}}
              <x-form-error name="title" />
            </div>
          </x-form-field>

          <x-form-field>
            <x-form-label for="salary">Salary</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="salary" id="salary" placeholder="$50,000 Per Year" required />

              {{-- can be self-closing --}}
              <x-form-error name="salary" />
            </div>
          </x-form-field>

        </div>

        {{-- <div class="mt-10">
          @if ($errors->any())
            <ul>
            @foreach ($errors->all() as $error)
              <li class="text-red-500 italic">{{ $error }}</li>
            @endforeach
            </ul>
          @endif
        </div> --}}
      </div>

    </div>
  
    <div class="mt-6 flex items-center justify-end gap-x-6">
      <div>
        <a href="/jobs" type="button" class="rounded-md px-3 py-2 text-sm font-semibold text-gray-500 hover:shadow-xs hover:bg-none hover:border hover:border-red-500 hover:text-red-500">Cancel</a>
        <x-form-button>Save</x-form-button>
      </div>
    </div>
  </form>
  
</x-layout>