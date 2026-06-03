<x-layout-auth title="register">
    <form action="/register" method="POST">
        @csrf

        <div class="mx-auto">
            <h1 class="text-center text-primary-content text-3xl mb-4">Register</h1>
        </div>

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            {{-- <legend class="fieldset-legend">Register</legend> --}}

            <label class="label">Username</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Username" class="input" />
            <x-forms.error name="name"></x-forms.error>

            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="input" />
            <x-forms.error name="email"></x-forms.error>

            <label class="label">Password</label>
            <input type="password" name="password" placeholder="Password" class="input" />
            <x-forms.error name="password"></x-forms.error>

            <span class="mt-2">Have an account? <a href="/login" class="text-accent">Login here</a> </span>

            <button type="submit" class="btn btn-neutral mt-4">Register</button>
        </fieldset>
    </form>
</x-layout-auth>