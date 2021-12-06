<?php

class Currency
{
    /**
     * @param mixed $country
     * @return string|array
     */

    public static function getCurrencyToUAH(mixed $country): string|array
    {
        $url = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json";
        $data = file_get_contents($url);
        $data = json_decode($data, true);
        $currency = [];

        if (is_array($country)) {
            foreach ($country as $item) {

                foreach ($data as $countries) {
                    if ($countries['cc'] === $item) {
                        $currency[$item] = [
                            "rate" => $countries['rate'],
                            "exchange-date" => $countries['exchangedate']
                        ];
                    }
                }
            }
            return $currency;

        }

        foreach ($data as $countries) {
            if ($countries['cc'] === $country) {
                $currency[$country] = [
                    "rate" => $countries['rate'],
                    "exchange-date" => $countries['exchangedate']
                ];
            }
        }


        return $currency;
    }
}