<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full block text-lg font-medium disabled:opacity-60 text-gray-700 dark:text-gray-400 invalidated:text-negative-600 dark:invalidated:text-negative-700">
            Please select the dates you want to make this machinery unavailable.
        </div>
        <div class="mt-4 w-full">
            <x-datetime-picker
                wire:model.live="startDate"
                label="Start Date"
                placeholder="Start Date"
                without-timezone
                disable-past-dates
            />
        </div>
        <div class="mt-4 w-full">
            <x-datetime-picker
                wire:model.live="endDate"
                label="End Date"
                placeholder="End Date"
                without-timezone
                disable-past-dates
            />
        </div>
        <div class="mt-4 w-full block text-lg font-medium disabled:opacity-60 text-gray-700 dark:text-gray-400 invalidated:text-negative-600 dark:invalidated:text-negative-700">
            Currently this machinery is not available on these dates.
        </div>
        <livewire:machinery-availability-table machinery-id="{{$machinery->id}}"/>
    </div>
</div>
