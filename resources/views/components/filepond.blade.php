<div wire:ignore class="filePondContainer">
    <input type="file" class="fileInput" />
</div>

@script
<script>


    document.addEventListener('livewire:navigated', function () {
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginImagePreview);


            const filePondContainer = document.querySelector('.filePondContainer');
            const fileInput = filePondContainer.querySelector('.fileInput');

            const pond = FilePond.create(fileInput);

            let files = [];
            let uploadedFiles = @json($files);

            if (uploadedFiles.length > 0) {
                for (let i = 0; i < uploadedFiles.length; i++) {
                    files.push({
                        source: uploadedFiles[i],
                        options: {
                            type: 'local',
                            load: true
                        }
                    })
                }
            }

            pond.setOptions({
                server: {
                    load: (source, load, error, progress, abort, headers) => {
                        var myRequest = new Request(source);
                        fetch(myRequest).then((res) => {
                            return res.blob();
                        }).then(load);
                    },

                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        // Upload logic...
                        @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        $wire.dispatch('{{ $attributes['delete-event'] }}');
                        // Revert logic...
                        @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                    },
                    remove: (source, load, error) => {
                        $wire.dispatch('{{ $attributes['delete-event'] }}');

                        load()
                    },
                },
                files: files,
            });


    })

</script>
@endscript
