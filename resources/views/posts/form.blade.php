{{-- This form can be used for both the create and update pages - it will check the currently used route to alter it's behaviour such as altering it's form action, 
and re-populating media libary attachments --}}

<form id="posts-form" method="POST" enctype="multipart/form-data" action="{{ \Request::route()->getName() == 'posts.create'  ? route('posts.store') : route('posts.update', $post->id) }}">

    @if(Route::currentRouteName() == 'posts.edit')
        @method('PUT') 
    @endif

    @csrf

    <label for="title">Title</label>
    <input type="text" name="title" placeholder="Post Title" value="{{ $post->title ?? "" }}" >
    @if ($errors->any())
        <br/>
        <strong>Validation Errors:</strong><br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <hr/>

    <label for="media">Media</label>
    <br/>

    {{-- The div which will hold the dropzone file upload element --}}
    <div class="dropzone" id="media-dropzone"></div>
        
    <hr/>

    <button type="submit">
        Save Post
    </button>

</form>

<script>
  
    //Javascript libraries are included in layout.blade.php

    //Disable Dropzone autodiscover so we can manually define our Dropzone options without interference
    Dropzone.autoDiscover = false;

    //If we're editing a post, a copy should be stored on load where javacript can read the associated media from it
    var editingPost = null;

    @if(Route::currentRouteName() == 'posts.edit')

        editingPost = {!! json_encode($post->toArray(), JSON_HEX_TAG) !!};//json_hex_tag for security

    @endif

    initDropzone();

    //Function to repopulate dropzone upload with media from post.  Will be used after the Dropzone is initialized
    function repopulateMedia(post){

        console.log('Repopulating Media...');

        let dz = document.getElementById('media-dropzone').dropzone;
        
        post.media.forEach(function(media){

            dz.options.addedfile.call(dz, media);
            media.previewElement.classList.add('dz-complete');
            $('#posts-form').append(
                '<div id="' + media.file_name + '">' +
                    '<input type="hidden" name="media[]" value="' + media.file_name + '">' +
                    '<input type="hidden" name="media_original_name[]" value="' + media.name + '">' +
                '</div>'
            );
            //Do not let Dropzone create a thumbnail locally, just show the one generated server-side
            dz.emit('thumbnail', media, '{{ route('api.media.show', ['mediaItem' => 'replaceMe', 'size' => 'thumb']) }}'.replace('replaceMe', media.id));
        });
        
    }

    //Initialize the Dropzone uploader
    function initDropzone(){

        console.log('Initializing Dropzone...');

        $("#media-dropzone").dropzone({
            url: '{{ route('api.media.store') }}',
            maxFilesize: 2, // MB
            maxFiles: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            success: function (file, response) {
                //On successful upload, add the file to the form - a hidden input for the filename after upload, and a corresponding hidden input with the original file name
                //This passes the uploaded files details along with the post when it is saved
                $('#posts-form').append(
                    '<div id="' + response.name + '">' +
                        '<input type="hidden" name="media[]" value="' + response.name + '">' +
                        '<input type="hidden" name="media_original_name[]" value="' + response.original_name + '">' +
                    '</div>'
                );
                file.file_name = response.name;//set this so that removedFile function can find the element
            },
            thumbnail: function(file, thumb){
                //Thumbnail callback will prevent thumbnail from being applied automatically
                //Instead we set the background of the element to the thumbnail image so we can resize it properly to fill the preview area
                $(file.previewElement).find('.dz-image:first').css({
                    "background-size": "cover",
                    'background-image': 'url(' + thumb + ')',
                    });
            },
            error: function(file, message, xhr){
                //Remove the preview thumbnail from the Dropzone area if the upload fails due to error
                file.previewElement.remove();
            },
            removedfile: function (file) {
                file.previewElement.remove();
                //Form elements for media are grouped in divs with the file name as the ID so they can be removed at once
                if (typeof file.file_name !== 'undefined') $('#posts-form').find('div[id="' + file.file_name + '"]').remove();
            },
            init: function () {
                console.log('Dropzone Initialized...');
                //If editing, load existing media
                if(editingPost !== null){
                    repopulateMedia(editingPost);
                }
            }
        });
    }
</script>
