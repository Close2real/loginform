<?php

namespace App\Utils\Objects\User\Mock;

use JMS\Serializer\Annotation\Type;

class UserExtraData
{

    /**
     * @Type("string")
     * @var string|null
     */
    private $name;

    /**
     * @Type("string")
     * @var string|null
     */
    private $value;

    /**
     * @Type("int")
     * @var int|null
     */
    private $position;

    /**
     * @Type("string")
     * @var string|null
     */
    private $type;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return UserExtraData
     */
    public function setName(?string $name): UserExtraData
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return UserExtraData
     */
    public function setValue(?string $value): UserExtraData
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     * @return UserExtraData
     */
    public function setPosition(?int $position): UserExtraData
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return UserExtraData
     */
    public function setType(?string $type): UserExtraData
    {
        $this->type = $type;
        return $this;
    }

}