# Coinbase Currency Rate Importer

Designed for use in a Magento system that can use Bitcoin as a native currency (not supported by default).

Prices are converted based on the rates given by the Coinbase API at
https://coinbase.com/api/v1/currencies/exchange_rates

This version includes manual updates for currencies.


Features
-------------
Uses all btc_to_XXX currencies from the API (excluding btc_to_btc) to get currency information.
Runs every 15 minutes via CRON to ensure currency accuracy.

Compatibility
-------------
Coinbase CurrencyConverter has been tested with the following Magento versions:
- Magento Community Edition 1.9.0.1

But is expected to also be compatible with:
Coinbase CurrencyConverter has been tested with the following Magento versions:
- Magento Community Edition 1.5.1.0
- Magento Community Edition 1.6.2.0
- Magento Community Edition 1.7.0.2
- Magento Community Edition 1.8.0.0

Recommended Additional Modules
-------------
Aoe_Scheduler - Because the CRON job may want adjusting and that's not possible through the standard currency interface.

https://github.com/AOEpeople/Aoe_Scheduler/

Installation Notes
-------------
* Be sure to set Coinbase as your currency rate provider in Scheduled Import Settings under System -> Configuration -> Currency Setup

Works best with a modgit install

```
modgit clone coibasecurrencyrateimporter https://github.com/drewdotpro/CoinbaseCurrencyRateImporter.git
```



