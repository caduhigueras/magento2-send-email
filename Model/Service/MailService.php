<?php
/**
 * CodeBaby_Email | MailService.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

declare(strict_types=1);

namespace CodeBaby\Email\Model\Service;

use CodeBaby\Email\Api\MailInterface;
use CodeBaby\Email\Model\Handler\TemplateHandler;
use CodeBaby\Email\Model\Handler\TemplateVarsHandler;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\Store;
use Psr\Log\LoggerInterface;

/**
 * In charge of sending the generic e-mails. To send via AJAX,
 * please use webapi endpoint \CodeBaby\Email\Model\Endpoint\Send
 *
 * Class MailService
 * @package CodeBaby\Email\Model\Service
 */
class MailService implements MailInterface
{
    private StateInterface $inlineTranslation;
    private TransportBuilder $transportBuilder;
    private TemplateHandler $templateHandler;
    private TemplateVarsHandler $templateVarsHandler;
    private LoggerInterface $logger;

    /**
     * MailService constructor.
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param TemplateHandler $templateHandler
     * @param TemplateVarsHandler $templateVarsHandler
     * @param LoggerInterface $logger
     */
    public function __construct(
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        TemplateHandler $templateHandler,
        TemplateVarsHandler $templateVarsHandler,
        LoggerInterface $logger
    ) {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->templateHandler = $templateHandler;
        $this->templateVarsHandler = $templateVarsHandler;
        $this->logger = $logger;
    }

    /**
     * Sends the Email based on the settings
     *
     * @param string[] $sendTo
     * @param string[] $sender
     * @param string[] $templateVars
     * @param string|null $subject
     * @param string|null $areaCode
     * @param int|null $storeId
     * @param string[]|null $cc
     * @param string[]|null $bcc
     * @param string|null $replyTo
     * @param null|int|string $template
     * @return string[]
     */
    public function handle(
        array $sendTo,
        array $sender,
        array $templateVars,
        ?string $subject,
        ?string $areaCode,
        ?int $storeId,
        ?array $cc,
        ?array $bcc,
        ?string $replyTo,
        $template = null
    ): array {
        $result = ['success' => true, 'error' => null];

        $this->inlineTranslation->suspend();
        try {
            $handledTemplate = $this->templateHandler->handle($template);
            $handledTemplateVars = $this->templateVarsHandler->handle(
                $templateVars,
                !$template,
                $subject
            );
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($handledTemplate)
                ->setTemplateOptions(
                    [
                        'area' => $areaCode ?: \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $storeId ?: Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($handledTemplateVars)
                ->setFromByScope($sender)
                ->addTo($sendTo['email'])
                ->addCc($cc)
                ->addBcc($bcc)
                ->setReplyTo($replyTo)
                ->getTransport();
            try {
                $transport->sendMessage();
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
                $result['success'] = false;
                $result['error'] = $e->getMessage();
            }
        } catch (MailException $e) {
            $this->logger->critical($e->getMessage());
            $result['success'] = false;
            $result['error'] = $e->getMessage();
        } catch (LocalizedException $le) {
            $this->logger->critical($le->getMessage());
            $result['success'] = false;
            $result['error'] = $le->getMessage();
        }

        $this->inlineTranslation->resume();
        return $result;
    }
}
