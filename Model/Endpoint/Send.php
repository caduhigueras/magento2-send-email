<?php
/**
 * CodeBaby_Email | Send.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

namespace CodeBaby\Email\Model\Endpoint;

use CodeBaby\Email\Api\Data\ResponseInterface;
use CodeBaby\Email\Api\SendInterface;
use CodeBaby\Email\Model\Email\ResponseFactory;
use CodeBaby\Email\Model\Service\MailService;

class Send implements SendInterface
{
    private ResponseFactory $responseFactory;
    private MailService $mailService;

    /**
     * Send constructor.
     * @param ResponseFactory $responseFactory
     * @param MailService $mailService
     */
    public function __construct(ResponseFactory $responseFactory, MailService $mailService)
    {
        $this->responseFactory = $responseFactory;
        $this->mailService = $mailService;
    }

    /**
     * @param string[] $sendTo
     * @param string[] $sender
     * @param string[] $templateVars
     * @param string|null $subject
     * @param string|null $areaCode
     * @param int|null $storeId
     * @param string[]|null $cc
     * @param string[]|null $bcc
     * @param string|null $replyTo
     * @param int|string|null $template
     * @return ResponseInterface
     */
    public function execute(
        array $sendTo,
        array $sender,
        array $templateVars,
        ?string $subject,
        ?string $areaCode = null,
        ?int $storeId = null,
        ?array $cc = null,
        ?array $bcc = null,
        ?string $replyTo = null,
        $template = null
    ): ResponseInterface {
        $result = $this->mailService->handle(
            $sendTo,
            $sender,
            $templateVars,
            $subject ?: null,
            $areaCode ?: null,
            $storeId ?: null,
            $cc ?: null,
            $bcc ?: null,
            $replyTo ?: null,
            $template
        );

        /** @var ResponseInterface $response */
        $response = $this->responseFactory->create();

        $response->setSuccess($result['success']);
        $response->setError($result['error'] ?: '');

        return $response;
    }
}
