<?php
/**
 * CodeBaby_Email | TemplateHandler.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

declare(strict_types=1);

namespace CodeBaby\Email\Model\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class TemplateResolver
 * @package CodeBaby\Email\Model\Handler
 */
class TemplateHandler
{
    const DEFAULT_CODEBABY_TEMPLATE_ID = 'codebaby_default_email';
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $template
     * @return int|string
     */
    public function handle($template)
    {
        if (!$template) {
            return self::DEFAULT_CODEBABY_TEMPLATE_ID;
        } else {
            /**
             * if template comes as scope config, ex: sales_email/order/template
             * extract it's identifier
             */
            if (strpos($template, '/') !== false) {
                //if template is coming as scope config, ex: sales_email/order/template - we need to
                $template = $this->scopeConfig->getValue(
                    $template,
                    ScopeInterface::SCOPE_STORE
                );
            }
        }
        return $template ?: self::DEFAULT_CODEBABY_TEMPLATE_ID;
    }
}
