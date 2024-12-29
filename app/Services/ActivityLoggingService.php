<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ActivityLoggingService{

    public function creation(string $object, array $data = []): void
    {
        $this->log('notice', 'User Created a ' . $object, $data);
    }

    public function update(string $object, array $data = []): void
    {
        $this->log('notice', 'User updated a ' . $object, $data);
    }

    public function destroy(string $object, array $data = []): void 
    {
        $this->log('notice', 'User Deleted a '. $object, $data);

    }

    public function rateLimitExceeded(string $object, array $data = []): void
    {
        $this->log('notice', 'User Exceeded rate limiting for: ' . $object, $data);
    }

    protected function log(string $level, string $message, array $data = []): void
    {
        Log::channel('activity')->log($level, $message, $data);
    }
}