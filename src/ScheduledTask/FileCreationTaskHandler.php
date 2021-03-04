<?php declare(strict_types=1);

namespace SynlabOrderInterface\ScheduledTask;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class FileCreationTaskHandler extends ScheduledTaskHandler
{
    
    public function __construct(EntityRepositoryInterface $scheduledTaskRepository)
    {
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ FileCreationTask::class ];
    }

    public function run(): void
    {
        $folderName = bin2hex(random_bytes(5));
        if (!file_exists('../custom/plugins/ASScheduledTaskTest/' . $folderName)) {
            mkdir('../custom/plugins/SynlabOrderInterface/' . $folderName, 0777, true);
        }
    }    
}