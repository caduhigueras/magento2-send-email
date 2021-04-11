<?php
/**
 * CodeBaby_Email | Response.php
 * Created by CodeBaby DevTeam.
 * User: cadu.higueras
 * Date: 10/4/2021
 **/

namespace CodeBaby\Email\Model\Email;


use CodeBaby\Email\Api\Data\ResponseInterface;

class Response implements ResponseInterface
{

    /** @var bool $success */
    private bool $success;

    /** @var string $error */
    private string $error;

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }
}
