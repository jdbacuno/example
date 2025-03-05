<x-layout>
  <x-slot:heading>
    Jobs Page
  </x-slot:heading>

  <div>
    @foreach ($jobs as $job)
      <a href="/jobs/{{ $job['id'] }}" class="block px-4 py-6 border border-gray-200 mb-2 hover:bg-white hover:border-gray-500 rounded-lg">
        <div class="text-blue-500 font-bold">{{ $job->employer->name }}</div>

        <div>
          <strong>{{ $job['title'] }}</strong>: Pays {{ $job['salary'] }} per year.
        </div>
      </a>
    @endforeach

    <div>
      {{ $jobs->links() }}
    </div>
  </div>

</x-layout>