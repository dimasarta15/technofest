@php $dropzoneId = isset($dz_id) ? $dz_id : \Str::random(8);@endphp
<div id="{{$dropzoneId}}" class="dropzone">
    <div class="dz-default dz-message">
        <br>
        @if (empty($title))
            <h3>Drop files here or click to upload.</h3>
        @else
            <h3>{{ $title }}</h3>
        @endif
        @if (empty($title))
            <p class="text-muted">Any related files you can upload <br>
        @else
            <p class="text-muted"> {{ $desc }}<br>
        @endif
            <small>One file can be max {{ config('media.max_size', 0) / 1000 }} MB</small></p>
    </div>
</div>
<!-- Dropzone {{ $dropzoneId }} -->

@push('js-uploader')
<script>
    // Turn off auto discovery
    Dropzone.autoDiscover = false;

    $(function () {
        var uploadedFiles = [];
        // Attach dropzone on element
        $("#{{ $dropzoneId }}").dropzone({
            url: "{{ route('backsite.project.store-image') }}",
            addRemoveLinks: true,
            maxFilesize: {{ isset($maxFileSize) ? $maxFileSize : config('media.max_size', 1000) / 1000 }},
            maxFiles: {{ config('media.max_file', 5) }},
            acceptedFiles: "{!! isset($acceptedFiles) ? $acceptedFiles : config('media.allowed') !!}",
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            params: {!! isset($params) ? json_encode($params) : '{}'  !!},
            init: function () {
                // uploaded files

                @if(isset($uploadedFiles) && count($uploadedFiles))
                    // show already uploaded files
                    uploadedFiles = {!! json_encode($uploadedFiles) !!};
                    var self = this;

                    uploadedFiles.forEach(function (file) {
                        // Create a mock uploaded file:
                        var uploadedFile = {
                            name: file.ori_image,
                            id: file.id,
                            is_db: 1,

                            //uid: file.uid,
                            /*size: file.size,
                            type: file.mime,*/
                            dataURL: "/storage/"+file.ori_image
                        };

                        // Call the default addedfile event
                        self.emit("addedfile", uploadedFile);
                        self.emit("success", uploadedFile);

                        // Image? lets make thumbnail
                        self.createThumbnailFromUrl(
                            uploadedFile,
                            self.options.thumbnailWidth,
                            self.options.thumbnailHeight,
                            self.options.thumbnailMethod,
                            true, function(thumbnail) {
                                self.emit('thumbnail', uploadedFile, thumbnail);
                        });


                        // fire complete event to get rid of progress bar etc
                        self.emit("complete", uploadedFile);
                    })

                    var htmlOpts = `<option value="" selected disabled>Choose One</option>`;
                    var thumb = '{{ $thumb }}';
                    $.each(uploadedFiles, function( index, value ) {
                        htmlOpts += `<option value="${value.id}" id="${value.ori_image}" ${(thumb == value.small_image ? "selected" : "")}>${value.ori_image}</option>`
                    });
                    $(img_thumb).attr('src', '/storage/'+thumb);

                    $("#sel_thumb").html(htmlOpts)
                @endif
        
                this.on("success", function (file, responseText) {
                    uploadedFiles.push({
                        id: responseText.id,
                        ori_name: file.upload.filename,
                        name: responseText.small_image,

                        //uid: responseText.uid,
                        uuid: file.upload.uuid,
                        size: file.size,
                        type: file.mime,
                        dataURL: file.url
                    });

                    console.log(uploadedFiles)

                    var htmlOpts = `<option value="" selected disabled>Choose One</option>`;
                    $.each(uploadedFiles, function( index, value ) {
                        let label = ''
                        let attrId = ''
                        if (value.ori_image == undefined) {
                            console.log(1, value)
                            attrId = value.name
                            label = String(value.ori_name).replace('project/', value.ori_name)
                        } else {
                            console.log(2, value)
                            attrId = value.small_image
                            label = String(value.small_image).replace('project/', '')
                        }
                        
                        htmlOpts += `<option value="${value.id}" id="${attrId}">${label}</option>`;
                    });

                    $("#sel_thumb").html(htmlOpts)
                });

                // Handle added file
                this.on('addedfile', function(file) {
                    var thumb = getIconFromFilename(file);
                    $(file.previewElement).find(".dz-image img").attr("src", thumb);
                })
                console.log('ssss', uploadedFiles)

                // handle remove file to delete on server
                this.on("removedfile", function (file) {
                    // try to find in uploadedFiles
                    var found = uploadedFiles.find(function (item) {
                        // check if filename and size matched
                        if (file.is_db != 1) {
                            return (item.uuid === file.upload.uuid) && (item.size === file.size);
                        } else {
                            return (item.id === file.id);
                        }
                    })
                    console.log('ok', found);

                    // If got the file lets make a delete request by id
                    if( found != undefined) {
                        console.log(found)
                        $.ajax({
                            url: route('backsite.project.destroy-image', {id: found.id}),
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            type: 'DELETE',
                            success: function(response) {
                                console.log('deleted');
                            }
                        });
                    }
                });

                // Handle errors
                this.on('error', function(file, response) {
                    var errMsg = response;

                    if( response.message ) errMsg = response.message;
                    if( response.file ) errMsg = response.file[0];

                    $(file.previewElement).find('.dz-error-message').text(errMsg);
                });
            }
        });
    })

// Get Icon for file type
function getIconFromFilename(file) {
    // get the extension
    var ext = file.name.split('.').pop().toLowerCase();

    // if its not an image
    if( file.type.indexOf('image') === -1 ) {

        // handle the alias for extensions
        /*if(ext === 'docx') {
            ext = 'doc'
        } else if (ext === 'xlsx') {
            ext = 'xls'
        }*/

        return "/images/icon/"+ext+".svg";
    }

    // return a placeholder for other files
    return '/images/icon/txt.svg';
}
</script>
@endpush