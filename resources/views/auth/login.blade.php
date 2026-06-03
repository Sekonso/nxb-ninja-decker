<x-layout-auth title="login">
    <form action="/login" method="POST">
        @csrf

        <div class="mx-auto">
            <h1 class="text-center text-primary-content text-3xl mb-4">Login</h1>
        </div>

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            {{-- <legend class="fieldset-legend">Login</legend> --}}

            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="input" />
            <x-forms.error name="email"></x-forms.error>

            <label class="label">Password</label>
            <input type="password" name="password" placeholder="Password" class="input" />
            <x-forms.error name="password"></x-forms.error>

            <x-forms.error name="general"></x-forms.error>
            
            <span class="mt-2">Not registered yet? <a href="/register" class="text-accent">Register here</a> </span>

            <button type="submit" class="btn btn-neutral mt-2">Login</button>
        </fieldset>
    </form>
</x-layout-auth>