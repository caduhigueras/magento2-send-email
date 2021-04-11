<?php
/**
 * CodeBaby_Email | ResponseInterface.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

declare(strict_types=1);

namespace CodeBaby\Email\Api\Data;

interface ResponseInterface
{
    /**
     * @return bool
     */
    public function getSuccess(): bool;

    /**
     * @param bool $success
     * @return void
     */
    public function setSuccess(bool $success): void;

    /**
     * @return string
     */
    public function getError(): string;

    /**
     * @param string $error
     * @return void
     */
    public function setError(string $error): void;
}
