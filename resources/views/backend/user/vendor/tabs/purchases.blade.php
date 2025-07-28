<div class="card">
    <div class="card-header">
        <span class="panel-title">{{ _lang('Purchase / Bill') }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table border-bottom">
                <thead>
                    <tr>
                        <th>{{ _lang('Date') }}</th>
                        <th>{{ _lang('Due Date') }}</th>
                        <th>{{ _lang('Bill No') }}</th>
                        <th class="text-right">{{ _lang('Grand Total') }}</th>
                        <th class="text-right">{{ _lang('Amount Due') }}</th>
                        <th class="text-center">{{ _lang('Status') }}</th>
                        <th class="text-center">{{ _lang('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->purchase_date }}</td>
                            <td>{{ $purchase->due_date }}</td>
                            <td>{{ $purchase->bill_no }}</td>
                            <td class="text-right">{{ formatAmount($purchase->grand_total, currency_symbol(request()->activeBusiness->currency)) }}</td>
                            <td class="text-right">{{ formatAmount($purchase->grand_total - $purchase->paid, currency_symbol(request()->activeBusiness->currency)) }}</td>
                            <td class="text-center">{!! xss_clean(purchase_status($purchase)) !!}</td>
                            <td class="text-center">
                                <a class="btn btn-xs btn-outline-primary" href="{{ route('purchases.show', $purchase['id']) }}"><i class="far fa-eye mr-1"></i>{{ _lang('Preview') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="float-right">
            {{ $purchases->links() }}
        </div>
    </div>
</div>