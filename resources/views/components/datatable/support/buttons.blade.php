<div class="w-full text-center p-2">
    <x-button positive label="Open Tickets" icon="book-open" href="{{route('supportTickets','active')}}" />
    <x-button negative label="Closed Tickets" icon="ban" href="{{route('supportTickets','done')}}" />
</div>
