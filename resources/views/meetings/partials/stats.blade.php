<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ __('meeting.winner') }}</td>
            <td class="col-xs-2 text-center">{{ __('group.winner_payoff') }}</td>
            <td class="col-xs-2 text-center">{{ __('meeting.payment_total') }}</td>
            <td class="col-xs-2 text-center">{{ __('meeting.outstanding') }}</td>
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ $meeting->winner_id }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($group->winner_payoff) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($paymentTotal = $payments->sum('amount')) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($outstanding = $group->winner_payoff - $paymentTotal) }}</td>
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ __('group.winner_payoff') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($group->winner_payoff) }}</span></li>
    <li class="list-group-item">{{ __('meeting.payment_total') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($paymentTotal) }}</span></li>
    <li class="list-group-item">{{ __('meeting.outstanding') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($outstanding) }}</span></li>
</ul>
