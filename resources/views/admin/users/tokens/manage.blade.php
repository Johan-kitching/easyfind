<div>
    @livewire('wire-elements-modal')
    @if ($this->user->tokens->isNotEmpty())
        <x-card.card>

            <x-card.header subject="Manage API Tokens" description="You may delete any of your existing tokens if they are no longer needed."/>

                <div class="mt-6 grid grid-cols-4 gap-6">
                    <div class="col-span-4 sm:col-span-3 space-y-4">
                        @foreach ($this->user->tokens->sortBy('name') as $token)
                            <div class="flex items-center justify-between">
                                <div>
                                    {{ $token->name }}
                                </div>

                                <div class="flex items-center space-x-4">
                                    @if ($token->last_used_at)
                                        <div class="text-sm text-gray-400">
                                            Last Active {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @endif

                                    @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                        <x-button wire:click="manageApiTokenPermissions({{ $token->id }})" spinner label="Permissions" />
                                    @endif
                                    <x-button negative wire:click="confirmApiTokenDeletion({{ $token->id }})" spinner label="Delete" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

        </x-card.card>
    @endif

    <!-- API Token Permissions Modal -->
    <x-dialog-modal wire:model.live="managingApiTokenPermissions">
        <x-slot name="title">
            API Token Permissions
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <label class="flex items-center">
                        <x-checkbox id="{{ $permission }}" label="{{ $permission }}" :value="$permission" wire:model="updateApiTokenForm.permissions" />
                    </label>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex space-x-3 justify-end">
                <x-button wire:click="$set('managingApiTokenPermissions', false)" label="Cancel" />
                <x-button primary wire:click="updateApiToken" spinner label="Save" />
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Token Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingApiTokenDeletion">
        <x-slot name="title">
            Delete API Token
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to delete this API token?
        </x-slot>

        <x-slot name="footer">
            <div class="flex space-x-3 justify-end">
                <x-button wire:click="$toggle('confirmingApiTokenDeletion')" label="Cancel" />
                <x-button negative wire:click="deleteApiToken" spinner label="Delete" />
            </div>
        </x-slot>
    </x-confirmation-modal>

</div>
