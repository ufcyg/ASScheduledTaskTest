<?php declare(strict_types=1);

namespace ASScheduledTaskTest\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class FileCreationTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'as.file_creation_task';
    }

    public static function getDefaultInterval(): int
    {
        return 60; // 1minute
    }
}