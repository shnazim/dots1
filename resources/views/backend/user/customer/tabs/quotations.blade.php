<div class="card">
    <div class="card-header">
        <span class="panel-title">{{ _lang('Quotations') }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table border-bottom">
                <thead>
                    <tr>
                        <th>{{ _lang('Date') }}</th>
                        <th>{{ _lang('Expired Date') }}</th>
                        <th>{{ _lang('Quotation Number') }}</th>
                        <th class="text-right">{{ _lang('Grand Total') }}</th>
                        <th class="text-center">{{ _lang('Status') }}</th>
                        <th class="text-center">{{ _lang('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $quotation)
                        <tr>
                            <td>{{ $quotation->quotation_date }}</td>
                            <td>{{ $quotation->expired_date }}</td>
                            <td>{{ $quotation->quotation_number }}</td>
                            <td class="text-right">{{ formatAmount($quotation->grand_total, currency_symbol(request()->activeBusiness->currency)) }}</td>
                            <td class="text-center">
                                @if ($quotation->getRawOriginal('expired_date') < date('Y-m-d'))
                                    {!! xss_clean(show_status(_lang('Expired'), 'secondary')) !!}
                                @else
                                {!! xss_clean(show_status(_lang('Active'), 'success')) !!}
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-xs btn-outline-primary" href="{{ route('quotations.show', $quotation['id']) }}"><i class="far fa-eye mr-1"></i>{{ _lang('Preview') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="float-right">
            {{ $quotations->links() }}
        </div>

    </div>
</div>