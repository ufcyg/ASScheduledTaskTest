<?php declare(strict_types=1);

namespace SynlabOrderInterface\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class HealthServiceTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'as.mail_test_task';
    }

    public static function getDefaultInterval(): int
    {
        return 60; // 1minute
    }
}