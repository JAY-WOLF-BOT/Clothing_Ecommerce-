<?php

namespace App\Support;

class Money
{
    /**
     * Cedis (as written by a human) into the integer pesewas we store.
     */
    public static function toPesewas(int|float $cedis): int
    {
        return (int) round($cedis * 100);
    }

    /**
     * Pesewas into the string a shopper reads: "GH₵ 1,150" rather than
     * "GH₵ 1,150.00" — cedi prices in this market are quoted in whole cedis,
     * and trailing zeros are noise on a price tag.
     */
    public static function format(int $pesewas): string
    {
        $symbol = config('store.currency.symbol', 'GH₵');
        $cedis = $pesewas / 100;

        $decimals = ($pesewas % 100 === 0) ? 0 : 2;

        return $symbol.' '.number_format($cedis, $decimals);
    }

    /**
     * The bare number, for places that already print the symbol once
     * (a totals column, an order message).
     */
    public static function amount(int $pesewas): string
    {
        $decimals = ($pesewas % 100 === 0) ? 0 : 2;

        return number_format($pesewas / 100, $decimals);
    }
}
