<?php
/**
 * CodeBaby_Email | SendMailInterface.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

declare(strict_types=1);

namespace CodeBaby\Email\Api;

interface MailInterface
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
    );
}
