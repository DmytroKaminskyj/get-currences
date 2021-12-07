<?php

class Currency
{
    /**
     * @var string  - {URL National Bank of Ukraine.}
     */
    private static string $url = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json";

    /**
     * @param mixed $country   --  {country code like "USD" or "EUR".}
     * @param $url
     * @return string|array
     */

    public static function getCurrencyUAH(mixed $country): string|array
    {

        $data = file_get_contents(self::$url);
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