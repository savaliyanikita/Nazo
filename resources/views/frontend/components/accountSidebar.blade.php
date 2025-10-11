<div class="list-group shadow-sm mb-4">
    <a href="{{ route('account.index') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.index') ? 'active' : '' }}">
        Your Account
    </a>
    <a href="{{ route('account.orders') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.orders') ? 'active' : '' }}">
        Order History
    </a>
    <a href="{{ route('account.wishlist') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.wishlist') ? 'active' : '' }}">
        Favorites
    </a>
    <!-- <a href="{{ route('account.subscriptions') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.subscriptions') ? 'active' : '' }}">
        Subscriptions
    </a>
    <a href="{{ route('account.wallet') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.wallet') ? 'active' : '' }}">
        Wallet
    </a>
    <a href="{{ route('account.address-book') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.address-book') ? 'active' : '' }}">
        Address Book
    </a>
    <a href="{{ route('account.email-preferences') }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('account.email-preferences') ? 'active' : '' }}">
        Email Communications
    </a> -->
</div>
