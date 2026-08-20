<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        {{-- Показуємо лише ім'я користувача --}}
        {{ explode(' ', Auth::guard('client')->user()->full_name)[0] ?? 'Користувач' }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="{{ route('client.data') }}">Мої дані</a></li>
        <li><a class="dropdown-item" href="{{ route('client.actions') }}">Мої дії</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ route('client.logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Вийти</button>
            </form>
        </li>
    </ul>
</div>