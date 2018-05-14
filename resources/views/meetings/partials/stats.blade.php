<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ __('meeting.winner') }}</td>
            <td class="col-xs-2 text-center">{{ __('group.winner_payoff') }}</td>
            <td class="col-xs-2 text-center">{{ __('meeting.payment_total') }}</td>
            <td class="col-xs-2 text-center">{{ __('meeting.outstanding') }}</td>
        </tr>
        <tr>
            @php
                $winnerName = $meeting->winner->user;
                if ($winnerName instanceof App\User) {
                    $winnerName = $winnerName->name;
                }
            @endphp
            {{-- <td class="text-center lead" style="border-top: none;">{{ $winnerName = optional(optional($meeting->winner)->user)->name }}</td> --}}
            <td class="text-center lead" style="border-top: none;">{{ $winnerName }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($group->winner_payoff) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($paymentTotal = $payments->sum('amount')) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($outstanding = $group->winner_payoff - $paymentTotal) }}</td>
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ __('meeting.winner') }} <span class="pull-right">{{ $winnerName }}</span></li>
    <li class="list-group-item">{{ __('group.winner_payoff') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($group->winner_payoff) }}</span></li>
    <li class="list-group-item">{{ __('meeting.payment_total') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($paymentTotal) }}</span></li>
    <li class="list-group-item">{{ __('meeting.outstanding') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($outstanding) }}</span></li>
</ul>
