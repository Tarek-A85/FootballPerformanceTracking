<?php

namespace App\Services;

abstract class BaseService{
    
    protected $activity_logger;

    public function __construct(ActivityLoggingService $activity_logger)
    {
        $this->activity_logger = $activity_logger;
    }
}