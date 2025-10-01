<div class="mt-2 text-sm text-gray-400 max-w-2xl">

    @if(isset($activity->changes['attributes']))
        @foreach($activity->changes['attributes'] as $field=>$value )

            @if(($field != 'created_at' && $field != 'updated_at' && $field != 'deleted_at'))
                <p class="my-1">
                    @if(!empty($value))
                        @if(str_contains($field,'_id'))
                            {{ str_replace('.name','',ucfirst(str_replace('_id', ' ', $field))) }}
                            @if(!empty($activity?->changes['old'][$field]))
                                @php
                                $type = strtolower(str_replace('_id', '', $field));
                                @endphp
                                : <span
                                    class="bg-red-100 line-through p-1 text-gray-600">{{ strip_tags($activity?->changes['old'][$field] ?? '' ) }}</span>
                                → <span
                                    class="bg-green-100 p-1 text-gray-600">{{ strip_tags($activity->subject->$type->name ?? $value ?? '' ) }}</span>
                            @else
                                : <span
                                    class="bg-green-100 p-1 text-gray-600">{{ is_bool($value) ? ($value ? 'True' : 'False') : strip_tags($value) }}</span>
                            @endif
                        @else
                            {{ str_replace('.name','',ucfirst(str_replace('_', ' ', $field))) }}
                            @if(!empty($activity?->changes['old'][$field]))
                                : <span
                                    class="bg-red-100 line-through p-1 text-gray-600">{{ $activity?->changes['old'][$field] ?? '' }}</span>
                                → <span
                                    class="bg-green-100 p-1 text-gray-600">{{ strip_tags($value) }}</span>
                            @else
                                : <span
                                    class="bg-green-100 p-1 text-gray-600">{{ is_bool($value) ? ($value ? 'True' : 'False') : strip_tags($value) }}</span>
                            @endif
                        @endif
                    @endif
                </p>

            @endif

        @endforeach
    @else
        @foreach($activity->changes['old'] as $field=>$value )

            @if(!str_contains($field,'_id') && ($field != 'created_at' && $field != 'updated_at' && $field != 'deleted_at') && !empty($value))

                <p class="my-1">{{ str_replace('.name','',ucfirst(str_replace('_', ' ', $field))) }}
                    : <span class="bg-red-100 line-through p-1 text-gray-600">
                                                                        {{ strip_tags($activity?->changes['old'][$field]) ?? '' }}
                                                    </span>
                </p>

            @endif

        @endforeach
    @endif
</div>
