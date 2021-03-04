<?php declare(strict_types=1);

namespace ASScheduledTaskTest\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class EmailTask extends ScheduledTask
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