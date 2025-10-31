<?php

if (!function_exists('formatMandatDate')) {
    /**
     * Formate une date de mandat selon la précision (année, mois, jour).
     * @param string|null $date
     * @param string|null $precision
     * @return string
     */
    function formatMandatDate($date, $precision)
    {
        if (!$date) return '';
        if ($precision === 'année' || $precision === 'year') {
            // Si la date est au format AAAA, retourne directement
            if (preg_match('/^\d{4}$/', $date)) {
                return $date;
            }
            // Sinon, extraire l'année
            return date('Y', strtotime($date));
        }
        if ($precision === 'mois' || $precision === 'month') {
            // Si la date est au format AAAA-MM
            if (preg_match('/^(\d{4})-(\d{2})$/', $date, $matches)) {
                $mois = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                $moisNom = date('F', strtotime("{$matches[1]}-{$mois}-01"));
                return __($moisNom) . ' ' . $matches[1];
            }
            return date('F Y', strtotime($date));
        }
        if ($precision === 'jour' || $precision === 'day') {
            return date('d/m/Y', strtotime($date));
        }
        // Par défaut, retourne la date brute
        return $date;
    }
}
