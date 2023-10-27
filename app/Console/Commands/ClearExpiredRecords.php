<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearExpiredRecords extends Command
{

    protected $signature = 'clear-expired-records';

    protected $description = 'Clear expired records from the database';


    public function handle()
    {
        $expireTime = Carbon::now()->subDay();
        $deletedRows = Post::where('story_post', 1)->where('created_at', '<=', $expireTime)->delete();
        $this->info("Deleted $deletedRows expired stories.");
    }
}
