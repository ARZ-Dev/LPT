<div wire:ignore class="filePondContainer"
     wire:model="{{ $attributes['wire:model'] }}"
     delete-event="{{ $attributes['delete-event'] }}"
     allow-remove="{{ $attributes['allow-remove'] }}"
     file-path="{{ $attributes['file-path'] }}"
     is-multiple="{{ $attributes['is-multiple'] }}"
>
    <input type="file" class="fileInput" />
</div>

@script
<script>


    document.addEventListener('livewire:navigated', function () {
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginImagePreview);


        const filePondContainers = document.querySelectorAll('.filePondContainer');

        filePondContainers.forEach((container, index) => {

            const fileInput = container.querySelector('.fileInput');
            const wireModel = container.getAttribute('wire:model');
            const deleteEvent = container.getAttribute('delete-event');
            const allowRemove = container.getAttribute('allow-remove');
            const uploadedFile = container.getAttribute('file-path');
            const isMultiple = container.getAttribute('is-multiple');

            let options = {};
            if (allowRemove == "false") {
                options.allowRemove = false;
            }

            const pond = FilePond.create(fileInput, options);

            let files = [];

            if (isMultiple === "false" && uploadedFile !== "") {
                files.push({
                    source: uploadedFile,
                    options: {
                        type: 'local',
                        load: true
                    }
                })
            } else {
                let uploadedFiles = @json($files ?? []);

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
                    @this.upload(wireModel, file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        $wire.dispatch(deleteEvent);
                        // Revert logic...
                    @this.removeUpload(wireModel, filename, load)
                    },
                    remove: (source, load, error) => {
                        $wire.dispatch(deleteEvent);

                        load()
                    },
                },
                files: files,
            });

        });

    })

</script>
@endscript
