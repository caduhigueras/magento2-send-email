<?php
/**
 * CodeBaby_Email | SendInterface.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

declare(strict_types=1);

namespace CodeBaby\Email\Api;

use CodeBaby\Email\Api\Data\ResponseInterface;

/**
 * Interface SendInterface
 * @package CodeBaby\Email\Api
 */
interface SendInterface
{
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
    ): ResponseInterface;
}
