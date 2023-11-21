<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostBid;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LotWon;
use App\Mail\LotWinnerNotification;
class ExpireAuctions extends Command
{
    protected $signature = 'expire:auctions';

    protected $description = 'Видалення експірованих аукціонів';

    public function handle()
    {
        

        $this->info('Експіровані аукціони успішно вилучено.');
    }
}
