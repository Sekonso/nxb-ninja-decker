<x-layout title="profile edit">
    <form action="/profile" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <fieldset class="w-full p-6 flex flex-col items-center gap-6 bg-secondary text-secondary-content">
            {{-- Image input --}}
            <div class="flex flex-col items-center gap-4">
                <img src="{{ asset('storage/images/avatars/' . $user->avatar_filename) }}" alt="profile picture"
                    id="avatar-preview" class="h-24 w-24 object-cover object-center">
                <div>
                    <input type="file" name="avatar" onchange="previewAvatar(event)"
                        class="file-input-md bg-secondary border-accent border p-1 text-xs cursor-pointer hover:bg-accent" />
                </div>
                <x-forms.error name="avatar" class="text-xs"></x-forms.error>
            </div>

            {{-- Other input --}}
            <div class="flex flex-col gap-4 w-100">
                <div class="flex flex-col">
                    <label class="label">Username*</label>
                    <input type="text" name="name" value="{{ $user->name }}" placeholder="Username"
                        class="input-sm bg-base-100 text-base-content p-2 mb-1" />
                    <x-forms.error name="name" class="text-xs"></x-forms.error>
                </div>

                <div class="flex flex-col">
                    <label class="label">Email*</label>
                    <input type="email" name="email" value="{{ $user->email }}" placeholder="Email"
                        class="input-sm bg-base-100 text-base-content p-2 mb-1" />
                    <x-forms.error name="email" class="text-xs"></x-forms.error>
                </div>

                <div class="flex flex-col">
                    <label class="label">Password*</label>
                    <input type="password" name="password" placeholder="Current password"
                        class="input-sm bg-base-100 text-base-content p-2 mb-1" />
                    <x-forms.error name="password" class="text-xs"></x-forms.error>
                </div>

                <div class="flex flex-col">
                    <label class="label">New Password (optional)</label>
                    <input type="password" name="password_new" placeholder="New paassword"
                        class="input-sm bg-base-100 text-base-content p-2 mb-1" />
                    <x-forms.error name="password_new" class="text-xs"></x-forms.error>
                </div>
            </div>

            <button type="submit" class="btn btn-accent">Confirm change</button>
        </fieldset>
    </form>
</x-layout>

<script>
    let previewUrl = null;

    function previewAvatar(event) {
        const file = event.target.files[0];

        if (!file) return;

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }

        previewUrl = URL.createObjectURL(file);

        document.getElementById('avatar-preview').src = previewUrl;
    }
</script>