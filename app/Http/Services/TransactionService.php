<?php 
namespace App\Http\Services;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Support\Facades\Artisan;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionService 
{
    private Account $sender;

    private Account $recipient;

    private float $amount;

    public function __construct(string $senderId, string $recipientId, float $amount)
    {
        // MAKE SO SENDER CAN'T SEND MORE THAN HE HAS
        $this->sender = Account::where('id', '=', $senderId)->first();
        $this->recipient = Account::where('id', '=', $recipientId)->first();
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
        $converted = number_format(($recipientCurrency->rate / 100000) * $amount, 2, '.', ''); // CONVERTED EURO TO STH
        $this->make($amount, $converted);
    }

    public function convertWithRecipientEuro(Currency $recipientCurrency, float $amount) // ISNT RIGHT
    {
        $converted = number_format((100000/$recipientCurrency->rate) * $amount, 2, '.', ''); 
        $this->make($amount, $converted);
    }

    public function convertWithoutEuro(Currency $senderCurrency, Currency $recipientCurrency, float $amount)
    {
        $senderConvertedToEuro = number_format((100000 / $senderCurrency->rate) * $amount, 2, '.', '');
        $convertedToRecipientCurrency = number_format(($recipientCurrency->rate / 100000) * $senderConvertedToEuro, 2, '.', '');
        $this->make($amount, $convertedToRecipientCurrency);
    }

    public function convertToEur(Currency $currency, float $amount)
    {
        $converted = number_format(($currency->rate / 100000) * $amount, 2, '.', '');
        return $converted;
    }

    public function make($recipientAmount, $senderAmount)
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
        $clientId = Auth::user()->id;
        $transaction->client_id = $clientId;
        $transaction->sender_id = $this->sender->id;
        $transaction->recipient_id = $this->recipient->id;
        $transaction->amount = $this->amount;
        $transaction->currency = $this->sender->currency;
        $transaction->save();
    }
}
?>
