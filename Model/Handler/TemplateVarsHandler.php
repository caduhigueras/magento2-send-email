<?php
/**
 * CodeBaby_Email | TemplateVarsHandler.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

declare(strict_types=1);

namespace CodeBaby\Email\Model\Handler;

/**
 * Class TemplateVarsResolver
 * @package CodeBaby\Email\Model\Handler
 */
class TemplateVarsHandler
{
    /**
     * In case there is no template, format Template Vars to adjust to our generic email template
     *
     * @param string[] $templateVars
     * @param bool $useDefaultTemplate
     * @param ?string $subject
     * @return string[]
     */
    public function handle(array $templateVars, bool $useDefaultTemplate, ?string $subject): array
    {
        if (!$useDefaultTemplate) {
            return $templateVars;
        }
        $vars = [];
        $data = [
            'data' => $templateVars,
            'subject' => $subject ?: ''
        ];
        $vars['data'] = $data;
        return $vars;
    }
}
