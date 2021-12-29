<?php

declare(strict_types=1);

class Currency
{
    /**
     * @var string  - {URL National Bank of Ukraine.}
     */
    protected static string $url = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json";

    /**
     * @param mixed $country --  {country code like "USD" or "EUR".}
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

    /**
     * @return array - {return all country code from National Bank of Ukraine.}
     */

    public static function getCountryList(): array
    {
        $data = file_get_contents(self::$url);
        $data = json_decode($data, true);
        $countryside = [];

        foreach ($data as $item) {
            $countryside[] = $item['cc'];
        }
        return $countryside;
    }
}