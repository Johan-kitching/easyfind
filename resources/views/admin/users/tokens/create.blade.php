<div>
    <x-input.forms.form action="createApiToken">
        <x-card.card>

            <x-card.header subject="Create API Token" description="API tokens allow third-party services to authenticate with our application on your behalf."/>

            <div class="mt-6 grid grid-cols-4 gap-6">

                <div class="col-span-4 sm:col-span-2">
                    <x-input wire:model.live.debounce.500ms="createApiTokenForm.name" label="Name" required autofocus />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasPermissions())
                    <div class="col-span-6">
                        <x-label for="permissions" value="Permissions"/>

                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                                <label class="flex items-center">
                                    <x-checkbox id="{{ $permission }}" label="{{ $permission }}" :value="$permission" wire:model="createApiTokenForm.permissions" />
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <x-slot name="footer">
                <div class="flex justify-end items-center">
                    <x-html.notify/>
                    <x-button   type="submit" spinner label="Add" />

                </div>
            </x-slot>

        </x-card.card>
    </x-input.forms.form>

    <!-- Token Value Modal -->
    <x-dialog-modal wire:model.live="displayingToken">
        <x-slot name="title">
            {{ __('API Token') }}
        </x-slot>

        <x-slot name="content">
            <div>
                {{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
            </div>

            <x-input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken"
                         class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full"
                         autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                         @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)"
            />
        </x-slot>

        <x-slot name="footer">
            <x-button primary wire:click="$set('displayingToken', false)" spinner label="Close" />
        </x-slot>
    </x-dialog-modal>

</div>
