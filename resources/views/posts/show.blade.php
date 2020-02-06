@extends('posts.layout')

@section('content')

    <h1>Preview Post</h1>

    <table>
        <tbody>
            <tr>
                <th>
                    Title
                </th>
                <td>
                    {{ $post->title }}
                </td>
            </tr>
            <tr>
                <th>
                    Created
                </th>
                <td>
                    {{ $post->created_at }}
                </td>
            </tr>
            <tr>
                <th>
                    Updated
                </th>
                <td>
                    {{ $post->updated_at }}
                </td>
            </tr>
            <tr>
                <th>
                    Media
                </th>
                <td>

                    {{-- Show each of the attached media library items - a clickable thumbnail which links to the large version --}}
                    @foreach ($post->media as $mediaItem)
                        
                        <a href="{{ route('api.media.show', ['mediaItem' => $mediaItem->id, 'size' => 'large']) }}">
                            <img src="{{ route('api.media.show', ['mediaItem' => $mediaItem->id, 'size' => 'thumb']) }}">
                        </a>
                        <p>
                            {{$mediaItem->name}}
                        </p>

                    @endforeach
                    <hr/>
                </td>
            </tr>
        </tbody>
    </table>

@endsection