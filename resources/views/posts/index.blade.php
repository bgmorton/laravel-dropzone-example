@extends('posts.layout')

@section('content')

    <h2>List Posts</h2>

    <a href="{{ route('posts.create') }}"> Create New Post</a>

    @if ($message = Session::get('success'))
        <div>
            <p>{{ $message }}</p>
        </div>
    @endif

    <table>

        <tr>
            <th>Title</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Action</th>
        </tr>

        @foreach ($posts as $post)

            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->created_at }}</td>
                <td>{{ $post->updated_at }}</td>
                <td>
                    <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                        <a href="{{ route('posts.show', $post->id) }}">Show</a>
                        <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" >Delete</button>
                    </form>
                </td>
            </tr>

        @endforeach

    </table>

    {!! $posts->links() !!}

@endsection