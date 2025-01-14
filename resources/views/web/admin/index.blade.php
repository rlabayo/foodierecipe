<x-app-layout>
  <div class="min-h-[85vh] mx-auto py-4 px-4 max-w-7xl">
    <h1 class="text-[--secondary] text-2xl font-semibold px-4">Users</h1>
    <div class="relative overflow-x-auto my-4">
        <table class="w-full text-sm text-left rtl:text-right bg-white">
            <thead class="text-xs text-gray-700 uppercase ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Admin Verified
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
              @foreach($users as $item) 
                <tr class="bg-white border-b">
                  <td class="px-6 py-4">{{$item->name}}</td>
                  <td class="px-6 py-4">{{$item->email}}</td>
                  <td class="px-6 py-4">{{$item->admin_verified ? 'YES' : 'NO'}}</td>
                  <td class="px-6 py-4">{{$item->created_at->diffForHumans()}}</td>
                  <th class="px-6 py-4">
                    @if(!$item->admin_verified)
                      <a href="{{ route('admin.verify_account', Crypt::encrypt($item->id)) }}" alt="Verify Account" class="flex justify-center text-center py-2 px-2 font-semibold rounded-md bg-[--primary] text-white hover:bg-[--secondary] hover:border-1 hover:border-gray-500">Verify Account</a>
                    @else
                      <span class="text-blue-700">Verified</span>
                    @endif
                  </th>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 my-4 w-full">{{ $users->links() }}</div>
  </div>
</x-app-layout>