<?php 
namespace App\Http\Services;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Support\Facades\Artisan;
use App\Models\Transaction;

class TransactionService 
{
    private Account $sender;

    private Account $recipient;

    private float $amount;

    public function __construct(string $senderIBAN, string $recipientIBAN, float $amount)
    {
        $this->sender = Account::where('account_number', '=', $senderIBAN)->first();
        $this->recipient = Account::where('account_number', '=', $recipientIBAN)->first();
        $this->amount = $amount;
    }
    public function transfer()
    {
        if ($this->checkCurrency()) {
            $this->make($this->amount, $this->amount);
        } else {
            $this->convert();
        }
    }

    public function checkCurrency()
    {
        $senderCurrency = $this->sender->currency;
        $recipientCurrency = $this->recipient->currency;
        if ($senderCurrency == $recipientCurrency) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public function convert()
    {
        Artisan::call('currency:import');
        
        $recipientCurrency = Currency::where("symbol", "=", $this->recipient->currency)->first();
        $senderCurrency = Currency::where("symbol", "=", $this->sender->currency)->first();

        if ($this->sender->currency != 'EUR' && $this->recipient->currency != 'EUR')
        {
            $this->convertWithoutEuro($senderCurrency, $recipientCurrency, $this->amount);
        } 
        elseif ($this->sender->currency == 'EUR' && $this->recipient->currency != 'EUR')
        {
            $this->convertWithSenderEuro($recipientCurrency, $this->amount);
        } 
        elseif ($this->sender->currency != 'EUR' && $this->recipient->currency == 'EUR') 
        {
            $this->convertWithRecipientEuro($senderCurrency, $this->amount);
        }
    }

    public function convertWithSenderEuro($recipientCurrency, float $amount)
    {
        $converted = number_format(($recipientCurrency->rate / 100000) * $amount, 2); // CONVERTED EURO TO STH
        $this->make($amount, $converted);
    }

    public function convertWithRecipientEuro(Currency $recipientCurrency, float $amount) // ISNT RIGHT
    {
        $converted = number_format((100000/$recipientCurrency->rate) * $amount, 2); 
        $this->make($amount, $converted);
    }

    public function convertWithoutEuro(Currency $senderCurrency, Currency $recipientCurrency, float $amount)
    {
        $senderConvertedToEuro = number_format((100000 / $senderCurrency->rate) * $amount, 2);
        $convertedToRecipientCurrency = number_format(($recipientCurrency->rate / 100000) * $senderConvertedToEuro, 2);
        $this->make($amount, $convertedToRecipientCurrency);
    }

    public function convertToEur(Currency $currency, float $amount)
    {
        $converted = number_format(($currency->rate / 100000) * $amount, 2);
        return $converted;
    }

    public function make($senderAmount, $recipientAmount)
    {
        $this->recipient->current_balance +=  $recipientAmount;
        $this->sender->current_balance -= $senderAmount;
        $this->sender->save();
        $this->recipient->save();
        $this->saveToHistory();
    }

    public function saveToHistory()
    {
        $transaction = new Transaction;
        $transaction->sender_id = $this->sender->user_id;
        $transaction->sender_account = $this->sender->account_number;
        $transaction->recipient_id = $this->recipient->user_id;
        $transaction->recipient_account = $this->recipient->account_number;
        $transaction->amount = $this->amount;
        $transaction->currency = $this->sender->currency;
        $transaction->save();
    }
}
?>
