<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ForgetCacheJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tags;
    public $key;

    /**
     * Create a new job instance.
     */
    public function __construct($key, $tags = null)
    {
        $this->key = $key;
        $this->tags = $tags;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->tags != null) {
            Cache::tags($this->tags)->forget($this->key);
        } else {
            Cache::forget($this->key);
        }
    }
}
