<div
     wire:ignore
     x-data
     x-init="() => {
        const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
        post.setOptions({
            // Set the initial value of the file if it exists
            files: [
                {
                    source: 'http://127.0.0.1:8000/storage/national_ids/ldI9TlQE5NW2HB61CPd3QhSV7yu5RfBt24v6Wnrh.jpg',
                    options: {
                        type: 'local',
                    },
                },
            ],

            server: {
                // other server options...

                 load: null,

                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    // Upload logic...
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    // Revert logic...
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },



            // other options...
        });

        post.on('processfile', (error, file) => {
            console.log(error)
            if (!error) {
            }
        });

    }"
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" class="test-filepond" />
</div>

@once
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endonce

@once
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginImagePreview);
    </script>
@endonce
