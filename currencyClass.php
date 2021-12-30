<?php

declare(strict_types=1);

class Currency
{
    /**
     * @var string  URL National Bank of Ukraine.
     */
    private static string $url = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json";

    /**
     * @param mixed $countryCode  country code like string - "USD","EUR" or array $foo = ["USD","EUR"];.
     * @return array
     */

    public static function getCurrencyUAH(string|array $countryCode): array
    {

        $data = file_get_contents(self::$url);
        $data = json_decode($data, true);
        $currency = [];

        if (is_array($countryCode)) {
            foreach ($countryCode as $item) {

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

            if ($countries['cc'] === $countryCode) {
                $currency[$countryCode] = [
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