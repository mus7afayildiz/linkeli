<div>
    <form action="{{ route('link.index')}}" method="get">
        <input type="text" name="search" id="search" value="{{ request('search')}}">
        <button type="submit">Search</button>
    </form>
</div>