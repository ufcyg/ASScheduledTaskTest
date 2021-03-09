<?php declare(strict_types=1);

namespace ASScheduledTaskTest\ScheduledTask;

use ASMailService\Core\MailServiceHelper;
use Exception;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class FileCreationTaskHandler extends ScheduledTaskHandler
{
    /** @var MailServiceHelper $mailserviceHelper */
    private $mailserviceHelper;
    /** @var SystemConfigService $systemConfigService */
    protected $systemConfigService;
    public function __construct(EntityRepositoryInterface $scheduledTaskRepository,
                                MailServiceHelper $mailserviceHelper,
                                SystemConfigService $systemConfigService)
    {
        $this->mailserviceHelper = $mailserviceHelper;
        $this->systemConfigService = $systemConfigService;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ FileCreationTask::class ];
    }

    public function run(): void
    {
        $notificationSalesChannel = $this->systemConfigService->get('SynlabOrderInterface.config.fallbackSaleschannelNotification');
        try {
            $this->mailserviceHelper->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,'FileCreationTaskHandler','this is a testmail','Trying to get working directory','Trying to get working directory',['']);
            
            // $a = 'asd';
            $a = getcwd();
            $this->mailserviceHelper->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,'FileCreationTaskHandler','controller test',$a,$a,['']);
            
            $folderName = bin2hex(random_bytes(5));
            if (!file_exists('../custom/plugins/ASScheduledTaskTest/' . $folderName)) {
                mkdir('../custom/plugins/ASScheduledTaskTest/' . $folderName, 0777, true);
            }
        }
        catch (Exception $e){
            
            $this->mailserviceHelper->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,'FileCreationTaskHandler','exception occured',$e->getMessage(),$e->getMessage(),['']);
        }
    }    
}