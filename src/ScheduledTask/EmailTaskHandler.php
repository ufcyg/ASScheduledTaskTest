<?php declare(strict_types=1);

namespace ASScheduledTaskTest\ScheduledTask;

use ASMailService\Core\MailServiceHelper;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class EmailTaskHandler extends ScheduledTaskHandler
{    
    /** @var MailServiceHelper $asMailService */
    protected $asMailService;
    /** @var SystemConfigService $systemConfigService */
    protected $systemConfigService;

    public function __construct(EntityRepositoryInterface $scheduledTaskRepository,
                                MailServiceHelper $asMailService,
                                SystemConfigService $systemConfigService)
    {
        $this->asMailService = $asMailService;
        $this->systemConfigService = $systemConfigService;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ EmailTask::class ];
    }

    public function run(): void
    {
        $workdir = getcwd();
        $notificationSalesChannel = $this->systemConfigService->get('SynlabOrderInterface.config.fallbackSaleschannelNotification');
        $this->asMailService->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],
                                            $notificationSalesChannel,
                                            'cronjobtester',
                                            'pre chdir',
                                            $workdir,
                                            $workdir,
                                            ['']);

        $WORK_DIR = $this->systemConfigService->get('ASScheduledTaskTest.config.workingDirectory');
        chdir($WORK_DIR);
        $workdir = getcwd();
        $this->asMailService->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],
                                            $notificationSalesChannel,
                                            'cronjobtester',
                                            'post chdir',
                                            $workdir,
                                            $workdir,
                                            ['']);
    }    
}