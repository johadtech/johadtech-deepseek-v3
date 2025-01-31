<?php 

namespace Johadtech\DeepSeekV3\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Johadtech\DeepSeekV3\Facades\DeepSeek;

class ProcessAsyncDeepSeekRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected array $messages, protected array $params = []) {}

    public function handle()
    {
        return DeepSeek::chat($this->messages, $this->params);
    }
}