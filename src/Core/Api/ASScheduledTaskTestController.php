<?php declare(strict_types=1);

namespace ASScheduledTaskTest\Core\Api;

use ASMailService\Core\MailServiceHelper;
use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @RouteScope(scopes={"api"})
 */
class ASScheduledTaskTestController extends AbstractController
{
    /** @var SystemConfigService $systemConfigService */
    private $systemConfigService;
    /** @var MailServiceHelper $mailServiceHelper */
    private $mailServiceHelper;
    /** @var string $senderName */
    private $senderName;
    public function __construct(SystemConfigService $systemConfigService,
                                MailServiceHelper $mailServiceHelper)
    {
        $this->systemConfigService = $systemConfigService;
        $this->mailServiceHelper = $mailServiceHelper;
        $this->senderName = 'cronjobtester';
    }

    /**
     * @Route("/api/v{version}/_action/as-scheduled/dummyRoute", name="api.custom.as_disposition_control.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {
        $notificationSalesChannel = $this->systemConfigService->get('SynlabOrderInterface.config.fallbackSaleschannelNotification');
        $this->mailServiceHelper->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,$this->senderName,'controller test','henlo','henlo',['']);
        $a = getcwd();
        $this->mailServiceHelper->sendMyMail(['patrick.thimm@synlab.com'=>'patrick thimm'],$notificationSalesChannel,$this->senderName,'controller test',$a,$a,['']);
        return new Response('',Response::HTTP_NO_CONTENT);
    }

    
}