
<form action="{{ route('link.index')}}" method="get" class="flex items-center space-x-2">
    <input type="text" name="search" id="search" value="{{ request('search')}}" placeholder="Notes de recherche..." class="border border-gray-300 dark:border-gray-600 rounded-md p-2 focus:ring focus:ring-blue-300">
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Recherche</button>
</form>
