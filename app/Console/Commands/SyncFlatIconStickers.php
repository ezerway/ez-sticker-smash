<?php

namespace App\Console\Commands;

use App\Services\SyncFlatIconStickerService;
use Illuminate\Console\Command;

class SyncFlatIconStickers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:flat-icon-stickers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync: Flaticon stickers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SyncFlatIconStickerService::sync();
        return 0;
    }
}
