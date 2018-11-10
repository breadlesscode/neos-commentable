<?php
namespace Breadlesscode\Commentable\Dto;

interface CommentDtoInterface
{
    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     */
    public function setEmail(string $email): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     */
    public function setContent(string $content): void;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void;

    /**
     * @return bool
     */
    public function isHidden(): bool;

    /**
     * @param bool $isHidden
     */
    public function setIsHidden(bool $isHidden): void;
}
