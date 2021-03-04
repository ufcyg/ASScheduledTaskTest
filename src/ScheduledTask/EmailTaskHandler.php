<?php declare(strict_types=1);

namespace SynlabOrderInterface\ScheduledTask;

use ASMailService\Core\MailServiceHelper;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class EmailTaskHandler extends ScheduledTaskHandler
{    
    /** @var MailServiceHelper $asMailService */
    protected $asMailService;

    public function __construct(EntityRepositoryInterface $scheduledTaskRepository,
                                MailServiceHelper $asMailService)
    {
        $this->asMailService = $asMailService;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ EmailTask::class ];
    }

    public function run(): void
    {
        $notificationSalesChannel = $this->systemConfigService->get('SynlabOrderInterface.config.fallbackSaleschannelNotification');
        $this->asMailService->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,'cronjobtester','this is a testmail','testmail<br>testing shit','testmail<br>testing shit',['']);
    }    
}