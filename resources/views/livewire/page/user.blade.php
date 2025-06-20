<x-container class="pt-8" x-data="{ showCreateModal: false, showEditModal: false }" x-on:user_edit_populated.window="showEditModal = true" x-on:user_edit_submitted.window="showEditModal = false"
    x-on:user_create_submitted.window="showCreateModal = false">
    <div class="bg-white p-4 rounded-xl shadow-2xl">
        <div class="flex justify-end mb-4">
            <button class="btn btn-primary" x-on:click="showCreateModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create user
            </button>
        </div>
        <table class="table table-auto">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Remember token</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->email_verified_at }}</td>
                        <td>{{ $user->created_at->format('d F Y H:i:s') }}</td>
                        <td>{{ $user->updated_at->format('d F Y H:i:s') }}</td>
                        <td class="flex gap-2">
                            <button class="btn btn-square btn-sm" wire:click="populateUser({{ $user->id }})" x-data="{ loading: false }"
                                x-on:user_edit_populated.window="loading = false" x-on:click="loading = true" x-bind:disabled="loading">
                                <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                <span x-show="loading" class="loading loading-spinner size-4"></span>
                            </button>
                            <button class="btn btn-square btn-error btn-sm" x-on:click="if (!confirm('anda yakin?')) $event.stopImmediatePropagation()"
                                wire:click="deleteUser({{ $user->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-4 stroke-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $this->users->links() }}
        </div>
    </div>

    {{-- ini modal create --}}
    <div x-show="showCreateModal" x-transition x-transition:enter.scale.100 x-transition:enter.opacity.0 x-transition:leave.opacity.0
        x-transition:leave.scale.100 class="bg-black/20 backdrop-blur-[2px] inset-0 fixed z-40 flex justify-center items-start pt-20">
        <div x-show="showCreateModal" x-transition class="bg-white p-4 shadow-xl rounded-xl px-5 lg:min-w-lg" x-on:click.outside="showCreateModal = false">
            <h3 class="text-lg text-gray-400 text-center font-semibold mb-4 uppercase">Add user data</h3>
            <form wire:submit="createUser()" x-data="{ loading: false }" x-on:submit="loading = true" x-on:user_create_progressed.window="loading = false">
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Name</legend>
                    <input type="text" class="input w-full" placeholder="Type a name..." wire:model="createForm.name" />
                    <p class="label">"Your" name, not someone else.</p>
                    @error('createForm.name')
                        <span class="text-red-500 text-sm italic">{{ $message }}</span>
                    @enderror
                </fieldset>
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Email</legend>
                    <input type="text" class="input w-full" placeholder="Type your email.." wire:model="createForm.email" />
                    <p class="label">Email is the one with <code>@</code> symbol</p>
                    @error('createForm.name')
                        <span class="text-red-500 text-sm italic">{{ $message }}</span>
                    @enderror
                </fieldset>
                @error('error')
                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                @enderror
                <hr class="my-4">
                <button class="btn btn-block btn-primary mt-4" type="submit" x-bind:disabled="loading">
                    <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    <span x-show="loading" class="loading loading-spinner"></span>
                    Send
                </button>
            </form>
        </div>
    </div>

    {{-- ini modal edit --}}
    <div x-show="showEditModal" x-transition x-transition:enter.scale.100 x-transition:enter.opacity.0 x-transition:leave.opacity.0 x-transition:leave.scale.100
        class="bg-black/20 backdrop-blur-[2px] inset-0 fixed z-40 flex justify-center items-start pt-20">
        <div x-show="showEditModal" x-transition class="bg-white p-4 shadow-xl rounded-xl px-5 lg:min-w-lg" x-on:click.outside="showEditModal = false">
            <h3 class="text-lg text-gray-400 text-center font-semibold mb-4 uppercase">Edit user data</h3>
            <form wire:submit="editUser()" x-data="{ loading: false }" x-on:submit="loading = true" x-on:user_edit_progressed.window="loading = false">
                <input type="hidden" wire:model="editForm.id">
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Name</legend>
                    <input type="text" class="input w-full" placeholder="My awesome page" wire:model="editForm.name" />
                    <p class="label">"Your" name, not someone else.</p>
                    @error('editForm.name')
                        <span class="text-red-500 text-sm italic">{{ $message }}</span>
                    @enderror
                </fieldset>
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Email</legend>
                    <input type="text" class="input w-full" placeholder="My awesome page" wire:model="editForm.email" />
                    <p class="label">Email is the one with <code>@</code> symbol</p>
                    @error('editForm.email')
                        <span class="text-red-500 text-sm italic">{{ $message }}</span>
                    @enderror
                </fieldset>
                @error('error')
                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                @enderror
                <hr class="my-4">
                <button class="btn btn-block btn-primary mt-4" type="submit" x-bind:disabled="loading">
                    <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    <span x-show="loading" class="loading loading-spinner"></span>
                    Send
                </button>
            </form>
        </div>
    </div>
</x-container>
