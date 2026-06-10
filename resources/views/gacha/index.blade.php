<x-layout title="Gacha">
    <div class="bg-accent text-accent-content p-4 mb-8">
        <h1 class="text-4xl">Card Gacha</h1>
    </div>

    <div class="flex flex-col gap-6">
        {{-- coin --}}
        <div class="flex flex-row gap-2">
            <img src="{{ asset('storage/images/coins.svg') }}" alt="coins" class="size-6">
            <span>{{ $user->coins }}</span>
        </div>

        {{-- banner --}}
        <div>
            <img src="{{ asset('storage/images/gacha_banner.png') }}" alt="gacha banner">
        </div>

        {{-- CTA's --}}
        <div class="flex flex-col gap-4 text-head">
            @if ($user->latest_daily == null || $user->latest_daily < today()->toDateTimeString())
                <form action="/gacha/daily" method="post" onsubmit="beforeSubmit(event, 'submit-gacha-daily')">
                    @csrf
                    <button type="submit" id="submit-gacha-daily" class="btn btn-accent text-xl w-full">Free daily 1x</button>
                </form>
            @else
                <div class="btn btn-accent btn-disabled flex items-center gap-2">
                    <span class="text-xl">
                        No Free draw until
                    </span>

                    <span class="countdown text-head text-2xl">
                        <span id="hours" style="--value:0; --digits:2;"></span>
                        :
                        <span id="minutes" style="--value:0; --digits:2;"></span>
                        :
                        <span id="seconds" style="--value:0; --digits:2;"></span>
                    </span>
                </div>
            @endif

            @if ($user->coins >= 100)
                <form action="/gacha/paid" method="post" onsubmit="beforeSubmit(event, 'submit-gacha-paid')">
                    @csrf
                    <button type="submit" id="submit-gacha-paid" class="btn btn-accent text-xl w-full">
                        100 <img src="{{ asset('storage/images/coins.svg') }}" alt="coins" class="size-6">
                    </button>
                </form>
            @else
                <div class="btn btn-accent btn-disabled text-xl grayscale">
                    Not enough coins
                    ( 100 <img src="{{ asset('storage/images/coins.svg') }}" alt="coins" class="size-6">)
                </div>
            @endif

        </div>
    </div>
</x-layout>

{{-- Countdown script --}}
<script>
    let remainingInHours = {{ floor(now()->diffInHours(now()->endOfDay())) }};
    let remainingInMinutes = {{ floor(now()->diffInMinutes(now()->endOfDay()) % 60) }};
    let remainingInSeconds = {{ floor(now()->diffInSeconds(now()->endOfDay()) % 60) }};

    function setCountdown() {
        document.getElementById('hours').style.setProperty('--value', remainingInHours);
        document.getElementById('minutes').style.setProperty('--value', remainingInMinutes);
        document.getElementById('seconds').style.setProperty('--value', remainingInSeconds);
    }

    function updateCountdown() {
        remainingInSeconds--;

        if (remainingInSeconds < 0) {
            remainingInSeconds = 59;
            remainingInMinutes--;

            if (remainingInMinutes < 0) {
                remainingInMinutes = 59;
                remainingInHours--;

                if (remainingInHours < 0) {
                    remainingInHours = 0;
                    remainingInMinutes = 0;
                    remainingInSeconds = 0;
                }
            }
        }

        if (remainingInSeconds <= 0 && remainingInMinutes <= 0 && remainingInHours <= 0) {
            location.reload();
        }

        setCountdown();
    }

    setCountdown();
    setInterval(updateCountdown, 1000);
</script>