@php $current = config('app.available_locales')[app()->getLocale()]; @endphp

<details class="lang-switcher">
    <summary>
        <span>{{ $current['flag'] }}</span>
        <span>{{ strtoupper(app()->getLocale()) }}</span>
        <span class="arrow">▾</span>
    </summary>

    <div class="lang-menu">
        @foreach (config('app.available_locales') as $code => $lang)
            <a href="{{ route('lang.switch', $code) }}"
               class="{{ app()->getLocale() === $code ? 'active' : '' }}">
                {{ $lang['flag'] }} {{ $lang['name'] }}
            </a>
        @endforeach
    </div>
</details>

<style>
    .lang-switcher { position: relative; display: inline-block; font-size: 14px; }
    .lang-switcher summary {
        list-style: none; cursor: pointer; display: flex; align-items: center; gap: 6px;
        padding: 8px 12px; border-radius: 10px;
        background: rgba(255,255,255,.95); color: #1e1b4b;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
    }
    .lang-switcher summary::-webkit-details-marker { display: none; }
    .lang-menu {
        position: absolute; right: 0; top: calc(100% + 6px); min-width: 160px;
        background: #fff; border-radius: 12px; padding: 6px;
        box-shadow: 0 8px 24px rgba(0,0,0,.2); z-index: 50;
    }
    .lang-menu a {
        display: block; padding: 8px 10px; border-radius: 8px;
        color: #1f2937; text-decoration: none;
    }
    .lang-menu a:hover { background: #f3f0ff; }
    .lang-menu a.active { background: #ede9fe; font-weight: 600; color: #5b21b6; }
</style>
