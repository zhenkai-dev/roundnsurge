@component('admin.shared.input.select-component')
    @slot('name') {{ $name }} @endslot
    @slot('option')
        <option value="">{{ __('common.select_with_hyphen') }}</option>
        @foreach (get_order_list() as $orderGroupKey => $orderGroup)
            <optgroup label="{{ trans_choice('entity.' . $orderGroupKey, 2) }}">
                @foreach ($orderGroup as $order)
                    <option value="{{ $order['id'] }}">{{ $order['order_no'] }} - {{ $order['username'] }}</option>
                @endforeach
            </optgroup>
        @endforeach
    @endslot
@endcomponent