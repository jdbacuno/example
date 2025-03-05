<x-layout>
  <x-slot:heading>
    Log In
  </x-slot:heading>

  {{-- @auth
  {{ redirect('/') }}
  @endauth --}}

  <form method="POST" action="/login">
    @csrf
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
  
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
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
        <x-form-button>Log in</x-form-button>
      </div>
    </div>
  </form>
  
</x-layout>