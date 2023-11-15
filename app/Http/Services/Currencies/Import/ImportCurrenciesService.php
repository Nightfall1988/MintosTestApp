<?php 
namespace App\Http\Services\Currencies\Import;

use App\Models\Currency;

class ImportCurrenciesService
{
    public function execute()
    {
        $xmlString = file_get_contents('https://www.bank.lv/vk/ecb.xml');
        $xmlObject = simplexml_load_string($xmlString);
                   
        $json = json_encode($xmlObject);
        $response = json_decode($json, true);
        
        foreach ($response['Currencies']['Currency'] as $currency)
        {
            Currency::updateOrCreate([
                'id' => $currency['ID'],
            ], [
                'symbol' => $currency['ID'],
                'rate' => (int) ((float) $currency['Rate'] * 100000)
            ]);
        }
    }
}
?>