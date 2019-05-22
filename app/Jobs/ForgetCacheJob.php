<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ForgetCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
