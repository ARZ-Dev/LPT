<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Team #{{ $team->id }}</h5>
                    <a href="{{ route('teams') }}" class="btn btn-primary mb-2 text-nowrap">
                        Currency
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Team:</span>
                            <span class="text-dark" >{{ $team->nickname }} </span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Level Category:</span>
                            <span class="text-dark" >{{ $team->levelCategory->name }}</span>
                        </div>



                    </div>
                </div>
            </div>



        </div>
    </div>

    @script
    <script>
        document.addEventListener('livewire:navigated', function () {
            var status={{$status}};
            if (status=="1") {$('input').prop('disabled', true);}
        });

        triggerCleave()
        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
            triggerCleave()
        })

        $(document).on('change', '.currency', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })
    </script>
    @endscript
</div>
