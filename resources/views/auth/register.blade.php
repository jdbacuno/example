<x-layout>
  <x-slot:heading>
    Register
  </x-slot:heading>

  <form method="POST" action="/register">
    @csrf
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
  
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
          @if (session('success'))
            <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 sm:col-span-7" role="alert">
              <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
              </svg>
              <span class="sr-only">Info</span>
              <div class="ms-3 text-sm font-medium">
                You have successfully registered! You may now <a href="/login" class="font-semibold underline hover:no-underline">log in</a>.
              </div>
              <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
              </button>
            </div>
          @endif

          <x-form-field>
            <x-form-label for="first_name">First Name</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="first_name" id="first_name" :value="old('first_name')" required />

              {{-- can required be self-closing --}}
              <x-form-error name="first_name" />
            </div>
          </x-form-field>

          <x-form-field>
            <x-form-label for="last_name">Last Name</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="last_name" id="last_name" :value="old('last_name')" required />

              {{-- can required be self-closing --}}
              <x-form-error name="last_name" />
            </div>
          </x-form-field>

          <x-form-field>
            <x-form-label for="email">Email</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="email" id="email" type="email" :value="old('email')" required />

              {{-- can be self-closing --}}
              <x-form-error name="email" />
            </div>
          </x-form-field>

          <x-form-field>
            <x-form-label for="password">Password</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="password" id="password" type="password" required />

              {{-- can be self-closing --}}
              <x-form-error name="password" />
            </div>
          </x-form-field>

          <x-form-field>
            <x-form-label for="password_confirmation">Confirm Password</x-form-label>
            
            <div class="mt-2">
              {{-- can be self-closing --}}
              <x-form-input name="password_confirmation" id="password_confirmation" type="password" required />

              {{-- can be self-closing --}}
              <x-form-error name="password_confirmation" />
            </div>
          </x-form-field>

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
        <a href="/" class="rounded-md px-3 py-2 text-sm font-semibold text-gray-500 hover:shadow-xs hover:bg-none hover:border hover:border-red-500 hover:text-red-500">Cancel</a>
        <x-form-button>Register</x-form-button>
      </div>
    </div>
  </form>
  
</x-layout>