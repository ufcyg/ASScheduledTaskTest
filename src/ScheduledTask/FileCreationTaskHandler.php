<?php declare(strict_types=1);

namespace ASScheduledTaskTest\ScheduledTask;

use ASMailService\Core\MailServiceHelper;
use Exception;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class FileCreationTaskHandler extends ScheduledTaskHandler
{
    /** @var MailServiceHelper $mailserviceHelper */
    private $mailserviceHelper;
    public function __construct(EntityRepositoryInterface $scheduledTaskRepository,
                                MailServiceHelper $mailserviceHelper)
    {
        $this->mailserviceHelper = $mailserviceHelper;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ FileCreationTask::class ];
    }

    public function run(): void
    {
        try {
            $folderName = bin2hex(random_bytes(5));
            if (!file_exists('../custom/plugins/ASScheduledTaskTest/' . $folderName)) {
                mkdir('../custom/plugins/ASScheduledTaskTest/' . $folderName, 0777, true);
            }
        }
        catch (Exception $e){
            $notificationSalesChannel = $this->systemConfigService->get('SynlabOrderInterface.config.fallbackSaleschannelNotification');
            $this->asMailService->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,'cronjobtester','this is a testmail',$e,$e,['']);
        }
    }    
}